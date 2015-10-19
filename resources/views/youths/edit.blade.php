@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Editing {{ $youth->name }}</div>


                    <div class="panel-body">

                        {!! Form::model($youth, ['method' => 'PATCH', 'url' => 'youths/'.$youth->id]) !!}
                            @include('youths.form')
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
