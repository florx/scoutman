@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Creating a Parent/Guardian</div>


                    <div class="panel-body">

                        {!! Form::model($parent = new \App\YouthParent(), ['url' => 'parents']) !!}
                        @include('parents.form')
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
