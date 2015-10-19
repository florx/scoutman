@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading ">Mass Assign Badges for {{$youth->name}}</div>


                    <div class="panel-body">

                        {!! Form::open(['url' => '/youths/'.$youth->id.'/badges/massAssign']) !!}

                            <div class="form-group @if ($errors->has('parents[]')) has-error @endif">
                                {!! Form::label('badges[]', 'Badges') !!}
                                {!! Form::select('badges[]', $badgeList, null, ['multiple', 'class' => 'form-control js-multi-select-search-tags']) !!}
                                @if ($errors->has('parents[]')) <p class="help-block">{{ $errors->first('parents[]') }}</p> @endif
                            </div>

                            <button type="submit" class="btn btn-primary form-control">Assign</button>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('javascript')
    <script>
        $('.js-multi-select-search-tags').select2();
    </script>
@endsection
