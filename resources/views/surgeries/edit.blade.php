@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Editing {{ $surgery->address_line1 }}</div>


                    <div class="panel-body">

                        {!! Form::model($surgery, ['method' => 'PATCH', 'url' => 'surgeries/'.$surgery->id]) !!}
                            @include('surgeries.form')
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
