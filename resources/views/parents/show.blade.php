@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Showing {{ $parent->name }}</div>


                    <div class="panel-body">

                        {!! Form::model($parent) !!}
                        @include('parents.form')
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('.js-multi-select-search').select2();
        $(document).find('input, textarea, button, select').attr('disabled','disabled');
    </script>
@overwrite
