@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Communicate</div>

                    {!! Form::model($modelData, ['url' => 'comm/recipients']) !!}


                    <div class="panel-body">

                        @if($errors->has())
                            <div class="alert alert-danger">
                                <p><strong>There are some problems with the given form values:</strong></p>
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Youth Recipients
                                            </h3>
                                    </div>
                                    <div class="panel-body js-youth-panel">

                                        <a href="#" class="js-youth-select-all">Select All</a> /
                                        <a href="#" class="js-youth-deselect-all">Deselect All</a>

                                        @foreach($youths as $youth)
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('recipient_youth[' . $youth->id . ']', 'Y', null, ['class' => '']) !!}
                                                    {{ $youth->name }} <small>({{ $youth->section->name }})</small>
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>


                            </div>


                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Adult Recipients</h3>
                                    </div>
                                    <div class="panel-body js-adult-panel">

                                        <a href="#" class="js-adult-select-all">Select All</a> /
                                        <a href="#" class="js-adult-deselect-all">Deselect All</a>

                                        @foreach($adults as $adult)
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('recipient_adult[' . $adult->id . ']', 'Y', null, ['class' => '']) !!}
                                                    {{ $adult->name }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary form-control">Next &raquo;</button>
                            </div>




                        </div>

                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $('.js-youth-select-all').click(function(){
                console.log('check');
                $('.js-youth-panel input[type=checkbox]').prop('checked', true);
            });

            $('.js-youth-deselect-all').click(function(){
                $('.js-youth-panel input[type=checkbox]').prop('checked', false);
            });

            $('.js-adult-select-all').click(function(){
                console.log('check');
                $('.js-adult-panel input[type=checkbox]').prop('checked', true);
            });

            $('.js-adult-deselect-all').click(function(){
                $('.js-adult-panel input[type=checkbox]').prop('checked', false);
            });
        });
    </script>
@endsection