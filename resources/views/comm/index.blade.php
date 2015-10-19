@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Communicate</div>


                    <div class="panel-body">

                        {!! Form::model($modelData, ['url' => 'comm', 'files'=>true]) !!}
                            @include('comm.form')
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection