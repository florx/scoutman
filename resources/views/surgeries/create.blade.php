@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Creating a Surgery</div>


                    <div class="panel-body">

                        {!! Form::model($surgery = new \App\Surgery(), ['url' => 'surgeries']) !!}
                        @include('surgeries.form')
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
