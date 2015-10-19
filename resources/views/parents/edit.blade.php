@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Editing {{ $parent->name }}</div>


                    <div class="panel-body">

                        {!! Form::model($parent, ['method' => 'PATCH', 'url' => 'parents/'.$parent->id]) !!}
                            @include('parents.form')
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
