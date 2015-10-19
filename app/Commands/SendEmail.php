<?php namespace App\Commands;

use App\Commands\Command;

use App\Email;
use App\User;
use App\Youth;
use App\YouthParent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Config\Definition\Exception\Exception;

class SendEmail extends Command implements SelfHandling, ShouldBeQueued {

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
        $email = Email::find($this->options['id']);
        if(is_null($email)){
            $this->delete();
            throw new Exception('Cannot find Email row to send');
        }

        $messageContent = $email->content;
        $subject = $email->subject;
        $fromEmail = $email->sender->email;
        $fromName = $email->sender->name;
        $attachments = unserialize($email->attachments);

        if(isset($this->options['youth_id'])){
            $youth = Youth::find($this->options['youth_id']);
            $to = $youth->email;
        }elseif(isset($this->options['youth_parent_id'])){
            $parent = YouthParent::find($this->options['youth_parent_id']);
            $to = $parent->email;
        }elseif(isset($this->options['user_id'])){
            $user = User::find($this->options['user_id']);
            $to = $user->email;
        }else{
            throw new Exception('Unknown recipient!');
        }

        if(empty($to)){
            $this->updateStatus($email, 'Failed (Empty Email)');
            $this->delete();
            throw new Exception('Email is empty');
        }

        Mail::send(['html' => 'emails.raw'], ['messageContent' => $messageContent], function($message) use ($subject, $to, $fromEmail, $fromName, $attachments)
        {
            $message->from($fromEmail, $fromName);
            $message->subject($subject);
            $message->to($to);


            foreach($attachments as $attachment){
                $message->attach(public_path() .'/uploads/'.$attachment);
            }

        });

        $this->updateStatus($email, 'Sent');
    }

    private function updateStatus($email, $status){
        if(isset($this->options['youth_id'])){
            $email->youths()->updateExistingPivot($this->options['youth_id'], ['status' => $status]);
        }elseif(isset($this->options['youth_parent_id'])){
            $email->parents()->updateExistingPivot($this->options['youth_parent_id'], ['status' => $status]);
        }elseif(isset($this->options['user_id'])){
            $email->users()->updateExistingPivot($this->options['user_id'], ['status' => $status]);
        }
    }

}
