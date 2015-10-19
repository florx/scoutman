@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Communication - Sent SMS</div>


                    <div class="panel-body">
                        <a href="{{ url('/comm') }}" class="btn btn-primary pull-right">Create</a>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>SMS</th>
                                <th>Sent</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($smsList as $sms)
                                <tr>
                                    <td>{{ $sms->content }}</td>
                                    <td>{{ $sms->created_at }}</td>
                                    <td>
                                        <div class="btn-toolbar" role="toolbar">
                                            <div class="btn-group">
                                                <a href="{{ url('/comm/sms/' . $sms->id) }}" class="btn btn-default btn-xs" aria-label="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
