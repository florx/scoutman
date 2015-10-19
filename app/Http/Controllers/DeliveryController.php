<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sms;
use App\User;
use App\Youth;
use App\YouthParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller {


	public function sms(Request $request)
	{
        $number = $request->get('number');
        $textlocalStatus = $request->get('status');
        $customID = $request->get('customID');

        Log::debug('Receiving Delivery report: ' . $number . ', ' . $textlocalStatus  . ', ' . $customID);
        Log::debug('POST vars: ' . print_R($request->all(), true));

        list($smsID, $type, $typeID) = explode('|', $customID);

        $sms = Sms::find($smsID);
        if(is_null($sms)) {
            return;
        }

        $status = '';

        switch($textlocalStatus){
            case 'D':
                $status = 'Delivered';
                break;
            case 'U':
                $status = 'Undelivered';
                break;
            case 'P':
                $status = 'Message en route';
                break;
            case 'I':
                $status = 'Failed - Invalid Phone Number (TextLocal)';
                break;
            case 'E':
                $status = 'Message Expired';
                break;
            case '?':
                $status = 'Sent - unknown delivery status';
                break;
            default:
                $status = 'Unknown TextLocal Status: ' . $textlocalStatus;
        }

        switch($type){
            case 'youth_id':
                $sms->youths()->updateExistingPivot($typeID, ['status' => $status]);
                break;
            case 'youth_parent_id':
                $sms->parents()->updateExistingPivot($typeID, ['status' => $status]);
                break;
            case 'user_id':
                $sms->users()->updateExistingPivot($typeID, ['status' => $status]);
                break;
        }
	}


}

/*$youth = Youth::find($this->options['youth_id']);
            $to = $youth->telephone;
            $customID = 'youth_id|' . $youth->id;
        }elseif(isset($this->options['youth_parent_id'])){
            $parent = YouthParent::find($this->options['youth_parent_id']);
            $to = $parent->telephone;
            $customID = 'youth_parent_id|' . $parent->id;
        }elseif(isset($this->options['user_id'])){
            $user = User::find($this->options['user_id']);
            $to = $user->telephone;