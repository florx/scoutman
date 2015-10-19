<?php namespace App\Http\Controllers;

use App\Commands\SendEmail;
use App\Commands\SendSms;
use App\Email;
use App\EmailFrom;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sms;
use App\SmsFrom;
use App\User;
use App\Youth;
use App\YouthParent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;

class CommController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
        //dd(Session::all());
        return view('comm.index', ['modelData' => Session::get('comm_options'),
                                   'attachments' => Session::get('comm_attach'),
                                    'timezoneList' => $this->getTimezones()]);
	}

    public function sms(){
        $smsList = Sms::all();
        return view('comm.smsList', compact('smsList'));
    }

    public function smsView(Sms $sms){
        return view('comm.sms', compact('sms'));
    }

    public function emails(){
        $emailList = Email::all();
        return view('comm.emailList', compact('emailList'));
    }

    public function emailView(Email $email){
        return view('comm.email', compact('email'));
    }

    public function storeOptions(Request $request){
        $this->validate($request, [
            'sms_content' => 'required_if:type.sms,Y|max:459',
            'email_subject' => 'required_if:type.email,Y',
            'email_content' => 'required_if:type.email,Y',
            'type' => 'required',
            'recipient' => 'required',
            'schedule_time' => 'required_if:schedule,Y|date|before:'.date('Y-m-d', strtotime('+2 weeks')). '|after:'.date('Y-m-d'),
        ], [
            'required_if' => 'The :attribute is required.',
        ]);

        Session::put('comm_options', $request->except('_token', 'files'));

        $attach = $this->attachFiles($request);

        if($attach !== true){
            return $attach;
        }

        return redirect('comm/recipients');
    }

    public function recipients(){

        $commOptions = Session::get('comm_options');
        $youths = Youth::whereIn('section_id', array_keys($commOptions['recipient']))->get();
        $adults = User::all();
        $modelData = Session::get('comm_recipients');

        return view('comm.recipients', compact('youths', 'adults', 'modelData'));
    }

    public function storeRecipients(Request $request){
        Session::put('comm_recipients', $request->except('_token'));

        return redirect('comm/preview');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function preview(){
        return view('comm.preview', $this->resolveVars());
    }

    public function send(){
        $commRecipients = $commOptions = $smsFrom = null;
        $emailFrom = $scheduleDate = $attachments = null;
        $emailObj = $smsObj = null;
        extract($this->resolveVars());

        //dd($scheduleDate);

        if (isset($commOptions['type']['email'])) {
            $emailObj = Email::create([
                'email_from_id' => $commOptions['email_from'],
                'user_id' => Auth::id(),
                'subject' => $commOptions['email_subject'],
                'content' => nl2br($commOptions['email_content']),
                'attachments' => serialize($attachments),
                'schedule' => $scheduleDate,
            ]);
        }

        if (isset($commOptions['type']['sms'])) {
            $smsObj = Sms::create([
                'sms_from_id' => $commOptions['sms_from'],
                'user_id' => Auth::id(),
                'content' => $commOptions['sms_content'],
                'schedule' => $scheduleDate,
            ]);
        }



        if(isset($commRecipients['recipient_youth'])) {
            foreach ($commRecipients['recipient_youth'] as $youth) {
                if (isset($commOptions['type']['email'])) {
                    Queue::later($scheduleDate, new SendEmail(['id' => $emailObj->id, 'youth_id' => $youth->id]));
                    $emailObj->youths()->attach([$youth->id => ['status' => 'Queued']]);

                    foreach($youth->parents as $parent){
                        Queue::later($scheduleDate, new SendEmail(['id' => $emailObj->id, 'youth_parent_id' => $parent->id]));
                        $emailObj->parents()->attach([$parent->id => ['status' => 'Queued']]);
                    }
                }

                if (isset($commOptions['type']['sms'])) {
                    Queue::later($scheduleDate, new SendSms(['id' => $smsObj->id, 'youth_id' => $youth->id]));
                    $smsObj->youths()->attach([$youth->id => ['status' => 'Queued']]);

                    foreach($youth->parents as $parent){
                        Queue::later($scheduleDate, new SendSms(['id' => $smsObj->id, 'youth_parent_id' => $parent->id]));
                        $smsObj->parents()->attach([$parent->id => ['status' => 'Queued']]);
                    }
                }
            }
        }

        if(isset($commRecipients['recipient_adult'])) {
            foreach ($commRecipients['recipient_adult'] as $user) {
                if (isset($commOptions['type']['email'])) {
                    Queue::later($scheduleDate, new SendEmail(['id' => $emailObj->id, 'user_id' => $user->id]));
                    $emailObj->users()->attach([$user->id => ['status' => 'Queued']]);
                }

                if (isset($commOptions['type']['sms'])) {
                    Queue::later($scheduleDate, new SendSms(['id' => $smsObj->id, 'user_id' => $user->id]));
                    $smsObj->users()->attach([$user->id => ['status' => 'Queued']]);
                }
            }
        }

        $this->clearSession();

        \Flash::success('That message has been queued to send!');

        return redirect('comm');
    }

    private function attachFiles($request){
        $filesToAttach = Session::get('comm_attach');

        if(is_null($filesToAttach)){
            $filesToAttach = [];
        }

        $uploadErrorMessages = [];
        $destPath = 'uploads';

        foreach($request->all()['files'] as $file){
            if(is_null($file)) continue;

            $fileName = trim($file->getClientOriginalName());

            if($file->isValid()){
                if($file->move($destPath, $fileName)) {
                    $filesToAttach[] = $fileName;
                }else{
                    $uploadErrorMessages[] = 'Unable to upload ' . $fileName;
                }
            }else{
                $uploadErrorMessages[] = 'File is invalid: ' . $fileName;
            }
        }

        Session::put('comm_attach', $filesToAttach);

        //dd(Session::all());

        if(count($uploadErrorMessages) > 0){
            \Flash::message(join(', ', $uploadErrorMessages));
            return redirect('comm');
        }

        return true;
    }

    private function resolveVars(){
        $smsFrom = $emailFrom = null;
        $commOptions = Session::get('comm_options');
        $commRecipients = Session::get('comm_recipients');
        $attachments = Session::get('comm_attach');

        if(isset($commRecipients['recipient_youth'])) {
            $commRecipients['recipient_youth'] = Youth::whereIn('id', array_keys($commRecipients['recipient_youth']))->get();
        }

        if(isset($commRecipients['recipient_adult'])) {
            $commRecipients['recipient_adult'] = User::whereIn('id', array_keys($commRecipients['recipient_adult']))->get();
        }

        if(isset($commOptions['type']['sms'])) {
            $smsFrom = SmsFrom::find($commOptions['sms_from']);
        }

        if(isset($commOptions['type']['email'])) {
            $emailFrom = EmailFrom::find($commOptions['email_from']);
        }

        if(isset($commOptions['schedule']) && $commOptions['schedule'] == 'Y'){
            $scheduleDate = Carbon::parse($commOptions['schedule_time'], $commOptions['schedule_timezone']);

        }else{
            $scheduleDate = Carbon::now();
        }

        if(isset($commOptions['schedule_timezone'])){
            $scheduleTimezone = $commOptions['schedule_timezone'];
        }

        return compact('commOptions', 'commRecipients', 'smsFrom', 'emailFrom', 'scheduleDate', 'scheduleTimezone', 'attachments');
    }

    private function clearSession()
    {
        Session::forget('comm_options');
        Session::forget('comm_recipients');
        Session::forget('comm_attach');
    }

    function getTimezones(){
        $zones = timezone_identifiers_list();
        $locations = array();

        foreach ($zones as $zone)
        {
            $locations[$zone] = str_replace('_', ' ', $zone);
        }

        return $locations;
    }

}
