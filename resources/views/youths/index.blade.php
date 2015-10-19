@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Scout Youth List</div>


                    <div class="panel-body">
                        <a href="{{ url('/youths/create') }}" class="btn btn-primary pull-right">Create</a>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Section</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($youths as $youth)
                                    <tr>
                                        <td>{{ $youth->first_name }} {{ $youth->last_name }}</td>
                                        <td>{{ $youth->section->name }}</td>
                                        <td>
                                            <div class="btn-toolbar" role="toolbar">
                                                <div class="btn-group">
                                                    <a href="{{ url('/youths/' . $youth->id) }}" class="btn btn-default btn-xs" aria-label="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                                    <a href="{{ url('/youths/' . $youth->id . '/badges') }}" class="btn btn-default btn-xs" aria-label="Badge Achivements"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></a>
                                                    <a href="{{ url('/youths/' . $youth->id . '/edit') }}" class="btn btn-default btn-xs" aria-label="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                    <a href="{{ url('/youths/' . $youth->id) }}" class="btn btn-default btn-xs" aria-label="Delete" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
