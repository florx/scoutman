@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Edit my filter</div>


                    <div class="panel-body">

                        {!! Form::model(Auth::user(), ['method' => 'PATCH', 'url' => 'me/filter']) !!}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group required @if ($errors->has('section_id')) has-error @endif">
                                    {!! Form::label('filter_section_id', 'Section') !!}
                                    {!! Form::select('filter_section_id', $sectionList, null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('section_id')) <p class="help-block">{{ $errors->first('section_id') }}</p> @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                        {!! Form::close() !!}
                        <br /> or <br /><br />
                        {!! Form::model(Auth::user(), ['method' => 'DELETE', 'url' => 'me/filter']) !!}
                        <button type="submit" class="btn btn-danger">Remove Filter</button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
