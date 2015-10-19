@if($errors->has())
    <div class="alert alert-danger">
        <p><strong>There are some problems with the given form values:</strong></p>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Communication Types</h3>
            </div>
            <div class="panel-body">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('type[sms]', 'Y', null, ['class' => 'js-sms-checkbox']) !!}
                        Text Message
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('type[email]', 'Y', null, ['class' => 'js-email-checkbox']) !!}
                        Email
                    </label>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Recipients Groups</h3>
            </div>
            <div class="panel-body">

                @foreach($sectionList as $section)
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('recipient[' . $section->id . ']', 'Y', null, ['class' => '']) !!}
                        {{ $section->name }}
                    </label>
                </div>
                @endforeach

                @unless(is_null(Auth::user()->filterSection))
                <div class="alert alert-info">The filter will override this selection,
                    you currently have it set to: <strong>{{ Auth::user()->filterSection->name }}</strong></div>
                @endunless
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Schedule</h3>
            </div>
            <div class="panel-body">


                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('schedule', 'Y', null, ['class' => 'js-schedule-checkbox']) !!}
                        I want to schedule this message
                    </label>
                </div>

                <div class="form-group js-schedule-area">
                    {!! Form::label('schedule_time', 'Scheduled Time') !!}
                    {!! Form::input('datetime-local', 'schedule_time', null, ['class' => 'form-control']) !!}
                    {!! Form::select('schedule_timezone', $timezoneList, 'Europe/London', ['class' => 'form-control']) !!}
                    <span class="help-block">In the format: 24/05/2015 16:54, timezone</span>
                </div>


            </div>
        </div>

    </div>


    <div class="col-md-6">

        <div class="panel panel-default js-sms-area">
            <div class="panel-heading">
                <h3 class="panel-title">Text Message Content</h3>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    {!! Form::label('sms_from', 'From') !!}
                    {!! Form::select('sms_from', $smsFromList, null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('sms_content', 'Message') !!}
                    {!! Form::textarea('sms_content', null, ['class' => 'form-control js-sms-content', 'rows' => '3']) !!}
                    <div><span class="js-sms-chars-left">x</span> characters left.</div>
                </div>
            </div>
        </div>

        <div class="panel panel-default js-email-area">
            <div class="panel-heading">
                <h3 class="panel-title">Email Content</h3>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    {!! Form::label('email_from', 'From') !!}
                    {!! Form::select('email_from', $emailFromList, null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email_subject', 'Subject') !!}
                    {!! Form::text('email_subject', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email_content', 'Message') !!}
                    {!! Form::textarea('email_content', null, ['class' => 'form-control ', 'rows' => '10']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('files[]', 'Attachments') !!}
                    {!! Form::file('files[]', null, ['class' => 'form-control ']) !!}
                    {!! Form::file('files[]', null, ['class' => 'form-control ']) !!}
                    {!! Form::file('files[]', null, ['class' => 'form-control ']) !!}
                    {!! Form::file('files[]', null, ['class' => 'form-control ']) !!}
                    {!! Form::file('files[]', null, ['class' => 'form-control ']) !!}
                </div>

                @if(is_array($attachments) && count($attachments) > 0)
                    <div class="alert alert-info">
                        <strong>Files already attached:</strong>
                        @foreach($attachments as $attachment)
                            {{ $attachment }}<br/>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>

        <button type="submit" class="btn btn-primary form-control">Next &raquo;</button>
    </div>


</div>

@section('javascript')
    <script>
        var smsMaxLength = 459;
        var smsWarningLength = 160;

        $(document).ready(function(){
            manageSmsContent();

            manageCollapsible('.js-sms-checkbox', '.js-sms-area');
            manageCollapsible('.js-email-checkbox', '.js-email-area');
            manageCollapsible('.js-schedule-checkbox', '.js-schedule-area');

            $('.js-sms-checkbox').change(function(){
                manageCollapsible('.js-sms-checkbox', '.js-sms-area');
            });

            $('.js-email-checkbox').change(function(){
                manageCollapsible('.js-email-checkbox', '.js-email-area');
            });

            $('.js-schedule-checkbox').change(function(){
                manageCollapsible('.js-schedule-checkbox', '.js-schedule-area');
            });

            $('.js-sms-content').on('input', manageSmsContent);

            setInterval(manageSmsContent, 100);
        });

        function manageCollapsible(checkbox, collapsible){
            if($(checkbox).is(':checked')){
                $(collapsible).show();
            }else{
                $(collapsible).hide();
            }
        }

        function manageSmsContent(){
            var len = $('.js-sms-content').val().length;

            if(len > smsMaxLength){
                $('.js-sms-content').val($('.js-sms-content').val().substring(0, smsMaxLength));
                return;
            }

            if(len > smsWarningLength){
                $('.js-sms-chars-left').parent().css('color', 'red');
                $('.js-sms-chars-left').css('font-weight', 'bold');
            }else{
                $('.js-sms-chars-left').parent().css('color', '');
                $('.js-sms-chars-left').css('font-weight', '');
            }

            $('.js-sms-chars-left').html(smsMaxLength - len);

        }

    </script>
@endsection