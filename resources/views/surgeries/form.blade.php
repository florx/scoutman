<div class="row">
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

                <div class="form-group required @if ($errors->has('postal_code')) has-error @endif">
                    {!! Form::label('postal_code', 'Postcode') !!}
                    {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('postal_code')) <p class="help-block">{{ $errors->first('postal_code') }}</p> @endif
                </div>

            </div>
        </div>

        <div class="form-group @if ($errors->has('telephone')) has-error @endif">
            {!! Form::label('telephone', 'Telephone') !!}
            {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
            @if ($errors->has('telephone')) <p class="help-block">{{ $errors->first('telephone') }}</p> @endif
        </div>


    </div>
</div>

<button type="submit" class="btn btn-primary form-control">Create/Save</button>

