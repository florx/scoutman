@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Two Factor Authentication</div>


                    <div class="panel-body">

                        @if(is_null(Auth::user()->tfa_token))

                            <p>Two factor authentication is currently <span class="label label-danger">DISABLED</span></p>

                            {!! Form::open(['method' => 'POST', 'url' => 'me/tfa']) !!}
                                <button type="submit" class="btn btn-success">Enable Two Factor</button>
                            {!! Form::close() !!}

                        @else

                            <p>Two factor authentication is currently <span class="label label-success">ENABLED</span></p>


                            {!! Form::open(['method' => 'POST', 'url' => 'me/tfa']) !!}
                            <button type="submit" class="btn btn-danger">Disable Two Factor</button>
                            {!! Form::close() !!}
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
