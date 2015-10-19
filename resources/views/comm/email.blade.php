@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">View Email</div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr><td><strong>From</strong>:</td><td>{{ $email->sender->descriptor }}</td></tr>
                                        <tr><td><strong>Subject</strong>:</td><td>{{ $email->subject }}</td></tr>
                                        <tr><td><strong>Attachments</strong>:</td><td>
                                            @if(count(unserialize($email->attachments)) == 0)
                                                None
                                            @else
                                                @foreach(unserialize($email->attachments) as $attachment)
                                                    {{ $attachment }} <br />
                                                @endforeach
                                            @endif
                                        </td></tr>
                                        <tr><td><strong>Content</strong>:</td><td>{{ nl2br($email->content) }}</td></tr>
                                    </tbody>
                                </table>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Youth Recipients</h3>
                                    </div>
                                    <div class="panel-body">
                                        @if(count($email->youths) == 0)
                                            None
                                        @else
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Who</th>
                                                <th>Status</th>
                                                <th>Last Update</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($email->youths as $youth)
                                                <tr>
                                                    <td>{{ $youth->name }}</td>
                                                    <td>{{ $youth->pivot->status }}</td>
                                                    <td><abbr title="{{ $youth->pivot->updated_at }}">{{ $youth->pivot->updated_at->diffForHumans() }}</abbr></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Leader Recipients</h3>
                                    </div>
                                    <div class="panel-body">
                                        @if(count($email->users) == 0)
                                            None
                                        @else
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Who</th>
                                                <th>Status</th>
                                                <th>Last Update</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($email->users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->pivot->status }}</td>
                                                    <td><abbr title="{{ $user->pivot->updated_at }}">{{ $user->pivot->updated_at->diffForHumans() }}</abbr></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Parent Recipients</h3>
                                    </div>
                                    <div class="panel-body">
                                        @if(count($email->parents) == 0)
                                            None
                                        @else
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Who</th>
                                                <th>Status</th>
                                                <th>Last Update</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($email->parents as $parent)
                                                <tr>
                                                    <td>{{ $parent->name }}</td>
                                                    <td>{{ $parent->pivot->status }}</td>
                                                    <td><abbr title="{{ $parent->pivot->updated_at }}">{{ $parent->pivot->updated_at->diffForHumans() }}</abbr></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>




                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection