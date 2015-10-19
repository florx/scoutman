<?php namespace App\Commands;

use App\Commands\Command;

use App\Sms;
use App\User;
use App\Youth;
use App\YouthParent;
use Helpers\ScoutManTelephone;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Helpers\Textlocal;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Config\Definition\Exception\Exception;

class SendSms extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

    protected $options;

    /**
     * Create a new command instance.
     * @param $options
     */
	public function __construct($options)
	{
        $this->options = $options;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$textLocal = new Textlocal();
        $customID = '';

        $sms = Sms::find($this->options['id']);
        if(is_null($sms)){
            $this->delete();
            throw new Exception('Cannot find SMS row to send');
        }

        if(isset($this->options['youth_id'])){
            $youth = Youth::find($this->options['youth_id']);
            $to = $youth->telephone;
            $customID = 'youth_id|' . $youth->id;
        }elseif(isset($this->options['youth_parent_id'])){
            $parent = YouthParent::find($this->options['youth_parent_id']);
            $to = $parent->telephone;
            $customID = 'youth_parent_id|' . $parent->id;
        }elseif(isset($this->options['user_id'])){
            $user = User::find($this->options['user_id']);
            $to = $user->telephone;
            $customID = 'user_id|' . $user->id;
        }else{
            throw new Exception('Unknown recipient!');
        }

        if(empty($to)){
            $this->updateStatus($sms, 'Failed - Empty Number');
            $this->delete();
            throw new Exception('Telephone is empty');
        }

        if(!ScoutManTelephone::isMobile($to)){
            $this->updateStatus($sms, 'Failed - Invalid Number');
            $this->delete();
            throw new Exception('Doesn\'t look like a valid number ' . $to);
        }


        Log::debug('SENDING SMS To: ' . $to . ', ' . $sms->sender->from  . ' | ' . $sms->content);

        try {
            $response = $textLocal->sendSms(
                [$to],
                $sms->content,
                $sms->sender->from,
                null, //schedule - we do this manually
                env('TEXTLOCAL_TEST', true), //test mode
                null, //delivery url (set at textlocal level)
                $sms->id . '|' . $customID //custom ID (for delivery reports)
            );

            if($response->status = 'success'){
                if(env('TEXTLOCAL_TEST', true)) {
                    $this->updateStatus($sms, 'Sent (Test Mode)');
                }else{
                    $this->updateStatus($sms, 'Sent');
                }
            }else{
                $this->updateStatus($sms, $response->status);
            }
        }catch (Exception $e) {
            $this->updateStatus($sms, $e->getMessage());
        }


	}

    private function updateStatus($sms, $status){
        if(isset($this->options['youth_id'])){
            $sms->youths()->updateExistingPivot($this->options['youth_id'], ['status' => $status]);
        }elseif(isset($this->options['youth_parent_id'])){
            $sms->parents()->updateExistingPivot($this->options['youth_parent_id'], ['status' => $status]);
        }elseif(isset($this->options['user_id'])){
            $sms->users()->updateExistingPivot($this->options['user_id'], ['status' => $status]);
        }
    }

}
