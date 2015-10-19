@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Enable Two Factor Authentication</div>


                    <div class="panel-body">

                        <p>Please scan this QR code in Google Authenticator.</p>

                        <img src="{{ $google2fa_url }}" />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
