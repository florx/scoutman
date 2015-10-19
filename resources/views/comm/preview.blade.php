@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Communicate</div>

                    {!! Form::open(['url' => 'comm/send']) !!}

                    <div class="panel-body">

                        <p>This is the preview screen, so you can review the message you are preparing to send out.
                            Feel free to use the back buttons to edit anything you see is wrong.
                            Email address or phone numbers will be highlighted in red if the system thinks they are invalid,
                            and it will not send to these recipients for that type of message.</p>

                        <div class="row">
                            <div class="col-md-6">

                                @if(isset($commOptions['type']['email']))

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Email Preview</h3>
                                        </div>
                                        <div class="panel-body">

                                            <strong>From:</strong> {{ $emailFrom->descriptor }}<br />
                                            <strong>To:</strong>
                                            @if(isset($commRecipients['recipient_youth']))
                                                @foreach($commRecipients['recipient_youth'] as $youth)
                                                    {{ $youth->name }} <small>({{ $youth->email }})</small> <br />
                                                @endforeach
                                            @endif

                                            @if(isset($commRecipients['recipient_adult']))
                                                <br />
                                                @foreach($commRecipients['recipient_adult'] as $user)
                                                    {{ $user->name }} <small>({{ $user->email }})</small> <br />
                                                @endforeach
                                            @endif
                                            <br />
                                            <strong>Subject:</strong> {{ $commOptions['email_subject'] }}<br />
                                            <strong>Attachments:</strong>
                                            @if(count($attachments) > 0)
                                                <br/>
                                                @foreach($attachments as $attachment)
                                                    {{ $attachment }}<br/>
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                            <br />
                                            <strong>Message</strong><br /><br />
                                            {!! nl2br($commOptions['email_content']) !!}

                                        </div>
                                    </div>

                                    @if(env('MAIL_HOST') == 'mailtrap.io')
                                        <div class="alert alert-danger">
                                            <strong>Email test mode is enabled.</strong>
                                            <p>The emails will not get sent.<br/>Please inform a System Administrator.</p>
                                        </div>
                                    @endif

                                @endif


                            </div>


                            <div class="col-md-6">

                                @if(isset($commOptions['type']['sms']))

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Text Message Preview</h3>
                                        </div>
                                        <div class="panel-body">

                                            <strong>From:</strong> {{ $smsFrom->descriptor }}<br />
                                            <strong>To:</strong>
                                            @if(isset($commRecipients['recipient_youth']))
                                                @foreach($commRecipients['recipient_youth'] as $youth)
                                                    @if($youth->validMobile)
                                                        {{ $youth->name }} <small>({{ $youth->telephone }})</small>
                                                    @else
                                                        <span style="color:red;">{{ $youth->name }} <small>({{ $youth->telephone }})</small></span>
                                                    @endif

                                                    <br />
                                                @endforeach
                                            @endif

                                            @if(isset($commRecipients['recipient_adult']))
                                                <br />
                                                @foreach($commRecipients['recipient_adult'] as $user)
                                                    {{ $user->name }} <small>({{ $user->telephone }})</small> <br />
                                                @endforeach
                                            @endif
                                            <br />
                                            <strong>Message</strong><br /><br />
                                            {{ $commOptions['sms_content'] }}

                                        </div>
                                    </div>

                                    @if(env('TEXTLOCAL_TEST', 'true') == 'true')
                                        <div class="alert alert-danger">
                                            <strong>TextLocal test mode is enabled.</strong>
                                            <p>These text messages will not get sent.<br/>Please inform a System Administrator.</p>
                                        </div>
                                    @endif

                                @endif

                                @if(isset($commOptions['schedule']) && $commOptions['schedule'] == 'Y')
                                    <div class="alert alert-warning">
                                        <strong>This message is scheduled!</strong>
                                        <p>It will be sent out at around {{ $scheduleDate }}</p>

                                    </div>
                                @endif





                                <button type="submit" class="btn btn-primary form-control">Send!</button>
                            </div>




                        </div>

                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection