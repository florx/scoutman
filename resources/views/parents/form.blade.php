<div class="row">
    <div class="col-md-6">

        <div class="form-group @if ($errors->has('title')) has-error @endif">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
            @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
        </div>

        <div class="form-group required @if ($errors->has('first_name')) has-error @endif">
            {!! Form::label('first_name', 'First Name') !!}
            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
            @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
        </div>

        <div class="form-group required @if ($errors->has('last_name')) has-error @endif">
            {!! Form::label('last_name', 'Last Name') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
            @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('dob')) has-error @endif">
            {!! Form::label('dob', 'Date Of Birth') !!}
            {!! Form::input('date', 'dob', (is_null($parent->dob) ? null : $parent->dob->format('Y-m-d')), ['class' => 'form-control']) !!}
            @if ($errors->has('dob')) <p class="help-block">{{ $errors->first('dob') }}</p> @endif
        </div>

        <div class="form-group required @if ($errors->has('relationship')) has-error @endif">
            {!! Form::label('relationship', 'Relationship') !!}
            {!! Form::text('relationship', null, ['class' => 'form-control']) !!}
            @if ($errors->has('relationship')) <p class="help-block">{{ $errors->first('relationship') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('telephone')) has-error @endif">
            {!! Form::label('telephone', 'Mobile Number') !!}
            {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
            @if ($errors->has('telephone')) <p class="help-block">{{ $errors->first('telephone') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('email')) has-error @endif">
            {!! Form::label('email', 'Email Address') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
            @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('gender')) has-error @endif">
            {!! Form::label('gender', 'Gender') !!}
            {!! Form::select('gender', ['M' => 'Male','F' => 'Female'], null, ['class' => 'form-control']) !!}
            @if ($errors->has('gender')) <p class="help-block">{{ $errors->first('gender') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('occupation')) has-error @endif">
            {!! Form::label('occupation', 'Occupation') !!}
            {!! Form::textarea('occupation', null, ['class' => 'form-control', 'rows' => 4]) !!}
            @if ($errors->has('occupation')) <p class="help-block">{{ $errors->first('occupation') }}</p> @endif
        </div>

    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Address</h3>
            </div>
            <div class="panel-body">

                <p class="alert alert-info">Just leave this section blank if they have the same address as their child.</p>

                <div class="form-group @if ($errors->has('address_line1')) has-error @endif">
                    {!! Form::label('address_line1', 'Line 1') !!}
                    {!! Form::text('address_line1', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('address_line1')) <p class="help-block">{{ $errors->first('address_line1') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('address_line2')) has-error @endif">
                    {!! Form::label('address_line2', 'Line 2') !!}
                    {!! Form::text('address_line2', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('address_line2')) <p class="help-block">{{ $errors->first('address_line2') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('address_line3')) has-error @endif">
                    {!! Form::label('address_line3', 'Line 3') !!}
                    {!! Form::text('address_line3', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('address_line3')) <p class="help-block">{{ $errors->first('address_line3') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('address_line4')) has-error @endif">
                    {!! Form::label('address_line4', 'Line 4') !!}
                    {!! Form::text('address_line4', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('address_line4')) <p class="help-block">{{ $errors->first('address_line4') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('postal_town')) has-error @endif">
                    {!! Form::label('postal_town', 'Town') !!}
                    {!! Form::text('postal_town', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_town')) <p class="help-block">{{ $errors->first('postal_town') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('postal_county')) has-error @endif">
                    {!! Form::label('postal_county', 'County') !!}
                    {!! Form::text('postal_county', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_county')) <p class="help-block">{{ $errors->first('postal_county') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('postal_code')) has-error @endif">
                    {!! Form::label('postal_code', 'Postcode') !!}
                    {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_code')) <p class="help-block">{{ $errors->first('postal_code') }}</p> @endif
                </div>

            </div>
        </div>


    </div>
</div>

<button type="submit" class="btn btn-primary form-control">Create/Save</button>

@section('javascript')
    <script>
        $('.js-multi-select-search').select2();
        $('.js-long-select').select2();
    </script>
@endsection