<div class="row">
    <div class="col-md-6">
        <div class="form-group required @if ($errors->has('section_id')) has-error @endif">
            {!! Form::label('section_id', 'Section') !!}
            {!! Form::select('section_id', $sectionList, null, ['class' => 'form-control']) !!}
            @if ($errors->has('section_id')) <p class="help-block">{{ $errors->first('section_id') }}</p> @endif
        </div>

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

        <div class="form-group @if ($errors->has('middle_names')) has-error @endif">
            {!! Form::label('middle_names', 'Middle Names') !!}
            {!! Form::text('middle_names', null, ['class' => 'form-control']) !!}
            @if ($errors->has('middle_names')) <p class="help-block">{{ $errors->first('middle_names') }}</p> @endif
        </div>

        <div class="form-group required @if ($errors->has('last_name')) has-error @endif">
            {!! Form::label('last_name', 'Last Name') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
            @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
        </div>

        <div class="form-group required @if ($errors->has('dob')) has-error @endif">
            {!! Form::label('dob', 'Date Of Birth') !!}
            {!! Form::input('date', 'dob', $youth->dob->format('Y-m-d'), ['class' => 'form-control']) !!}
            @if ($errors->has('dob')) <p class="help-block">{{ $errors->first('dob') }}</p> @endif
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

        <div class="form-group @if ($errors->has('patrol_name')) has-error @endif">
            {!! Form::label('patrol_name', 'Patrol/Sixth/Lodge Name') !!}
            {!! Form::text('patrol_name', null, ['class' => 'form-control']) !!}
            @if ($errors->has('patrol_name')) <p class="help-block">{{ $errors->first('patrol_name') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('nationality_id')) has-error @endif">
            {!! Form::label('nationality_id', 'Nationality') !!}
            {!! Form::select('nationality_id', $nationalityList, null, ['class' => 'form-control js-long-select']) !!}
            @if ($errors->has('nationality_id')) <p class="help-block">{{ $errors->first('nationality_id') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('faith_id')) has-error @endif">
            {!! Form::label('faith_id', 'Faith') !!}
            {!! Form::select('faith_id', $faithList, null, ['class' => 'form-control']) !!}
            @if ($errors->has('faith_id')) <p class="help-block">{{ $errors->first('faith_id') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('ethnicity_id')) has-error @endif">
            {!! Form::label('ethnicity_id', 'Ethnicity') !!}
            {!! Form::select('ethnicity_id', $ethnicityList, null, ['class' => 'form-control']) !!}
            @if ($errors->has('ethnicity_id')) <p class="help-block">{{ $errors->first('ethnicity_id') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('parents[]')) has-error @endif">
            {!! Form::label('parents[]', 'Parents') !!}
            {!! Form::select('parents[]', $parentList, $youth->parents->lists('id'), ['multiple', 'class' => 'form-control js-multi-select-search-tags']) !!}
            @if ($errors->has('parents[]')) <p class="help-block">{{ $errors->first('parents[]') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('emergency_contacts[]')) has-error @endif">
            {!! Form::label('emergency_contacts[]', 'Emergency Contacts') !!}
            {!! Form::select('emergency_contacts[]', $parentList, $youth->emergency_contacts->lists('id'), ['multiple', 'class' => 'form-control js-multi-select-search-tags']) !!}
            @if ($errors->has('emergency_contacts[]')) <p class="help-block">{{ $errors->first('emergency_contacts[]') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('swim')) has-error @endif">
            {!! Form::label('swim', 'Can swim 100m?') !!}
            {!! Form::select('swim', ['No', 'Yes'], null, ['class' => 'form-control']) !!}
            @if ($errors->has('swim')) <p class="help-block">{{ $errors->first('swim') }}</p> @endif
        </div>

        <div class="form-group @if ($errors->has('bannedFirearms')) has-error @endif">
            {!! Form::label('bannedFirearms', 'Banned from using Firearms?') !!}
            {!! Form::select('bannedFirearms', ['No', 'Yes'], null, ['class' => 'form-control']) !!}
            @if ($errors->has('bannedFirearms')) <p class="help-block">{{ $errors->first('bannedFirearms') }}</p> @endif
        </div>

    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Address</h3>
            </div>
            <div class="panel-body">

                <div class="form-group required @if ($errors->has('address_line1')) has-error @endif">
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

                <div class="form-group required @if ($errors->has('postal_town')) has-error @endif">
                    {!! Form::label('postal_town', 'Town') !!}
                    {!! Form::text('postal_town', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_town')) <p class="help-block">{{ $errors->first('postal_town') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('postal_county')) has-error @endif">
                    {!! Form::label('postal_county', 'County') !!}
                    {!! Form::text('postal_county', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_county')) <p class="help-block">{{ $errors->first('postal_county') }}</p> @endif
                </div>

                <div class="form-group required @if ($errors->has('postal_code')) has-error @endif">
                    {!! Form::label('postal_code', 'Postcode') !!}
                    {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_code')) <p class="help-block">{{ $errors->first('postal_code') }}</p> @endif
                </div>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Health</h3>
            </div>
            <div class="panel-body">

                <div class="form-group @if ($errors->has('doctor_name')) has-error @endif">
                    {!! Form::label('doctor_name', 'Doctor Name') !!}
                    {!! Form::text('doctor_name', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('doctor_name')) <p class="help-block">{{ $errors->first('doctor_name') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('surgery_id')) has-error @endif">
                    {!! Form::label('surgery_id', 'Surgery') !!}
                    {!! Form::select('surgery_id', $surgeryList, null, ['class' => 'form-control js-long-select']) !!}
                    @if ($errors->has('surgery_id')) <p class="help-block">{{ $errors->first('surgery_id') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('nhs_number')) has-error @endif">
                    {!! Form::label('nhs_number', 'NHS Number') !!}
                    {!! Form::text('nhs_number', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('nhs_number')) <p class="help-block">{{ $errors->first('nhs_number') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('dietary_needs')) has-error @endif">
                    {!! Form::label('dietary_needs', 'Dietary Needs') !!}
                    {!! Form::textarea('dietary_needs', null, ['class' => 'form-control', 'rows' => 4]) !!}
                    @if ($errors->has('dietary_needs')) <p class="help-block">{{ $errors->first('dietary_needs') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('medical_info')) has-error @endif">
                    {!! Form::label('medical_info', 'Medical Info') !!}
                    {!! Form::textarea('medical_info', null, ['class' => 'form-control', 'rows' => 4]) !!}
                    @if ($errors->has('medical_info')) <p class="help-block">{{ $errors->first('medical_info') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('disabilities[]')) has-error @endif">
                    {!! Form::label('disabilities[]', 'Disabilities') !!}
                    {!! Form::select('disabilities[]', $disabilityList, $youth->disabilities->lists('id'), ['multiple', 'class' => 'form-control js-multi-select-search']) !!}
                    @if ($errors->has('disabilities[]')) <p class="help-block">{{ $errors->first('disabilities[]') }}</p> @endif
                </div>

                <div class="form-group @if ($errors->has('disabilities')) has-error @endif">
                    {!! Form::label('disability_notes', 'Disability Notes') !!}
                    {!! Form::textarea('disability_notes', null, ['class' => 'form-control', 'rows' => 4]) !!}
                    @if ($errors->has('disability_notes')) <p class="help-block">{{ $errors->first('disability_notes') }}</p> @endif
                </div>

            </div>
        </div>


    </div>
</div>

<button type="submit" class="btn btn-primary form-control">Create/Save</button>

@section('javascript')
    <script>
        $('.js-multi-select-search-tags').select2({tags: true});
        $('.js-multi-select-search').select2();
        $('.js-long-select').select2();
    </script>
@endsection