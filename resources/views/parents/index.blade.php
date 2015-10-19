@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Scout Parents/Guardians List</div>


                    <div class="panel-body">
                        <a href="{{ url('/parents/create') }}" class="btn btn-primary pull-right">Create</a>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Children</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parents as $parent)
                                    <tr>
                                        <td>{{ $parent->name }}</td>
                                        <td>

                                            {{ join(', ', $parent->allAssociatedYouths->lists('name')) }}

                                        </td>
                                        <td>
                                            <div class="btn-toolbar" role="toolbar">
                                                <div class="btn-group">
                                                    <a href="{{ url('/parents/' . $parent->id) }}" class="btn btn-default btn-xs" aria-label="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                                    <a href="{{ url('/parents/' . $parent->id . '/edit') }}" class="btn btn-default btn-xs" aria-label="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                    <a href="{{ url('/parents/' . $parent->id . '/delete') }}" class="btn btn-default btn-xs" aria-label="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
