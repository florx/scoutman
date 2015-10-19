<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ScoutMan</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">ScoutMan</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/home') }}">Home</a></li>
                    @unless (Auth::guest())

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Data Management <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/youths') }}">Youths</a></li>
                                <li><a href="{{ url('/parents') }}">Parents/Guardians</a></li>
                                <li><a href="{{ url('/surgeries') }}">Surgeries</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Communicate <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/comm') }}">Create</a></li>
                                <li><a href="{{ url('/comm/sms') }}">View Past SMS</a></li>
                                <li><a href="{{ url('/comm/emails') }}">View Past Email</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Achievements <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/badges') }}">Badges</a></li>
                                <li><a href="{{ url('/badges/youthReport') }}">Almost Report</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reports <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/reports/verifyDetails') }}">Verify Details</a></li>
                            </ul>
                        </li>

                        <!--<li><a href="{{ url('/') }}">Events</a></li>-->
                        
                    @endunless
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
					@else
                        <li><a href="{{ url('/me/filter') }}">
                            @if(is_null(Auth::user()->filterSection))
                                No Filter Set
                            @else
                                Filtering on: <strong>{{ Auth::user()->filterSection->name }}</strong>
                            @endif
                        </a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/me/tfa') }}">Two Factor</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if (Session::has('flash_notification.message'))
                    <div class="alert alert-{{ Session::get('flash_notification.level') }} fade in">
                        {{ Session::get('flash_notification.message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

	@yield('content')

    <footer>
        <?php
            exec('git rev-parse --verify HEAD 2> /dev/null', $output);
            $hash = $output[0];
            $shortHash = substr($hash, 0, 7);

            exec('git show ' . $hash, $output);

            foreach($output as $line){
                if(substr($line, 0, 5) == 'Date:'){
                    $timestamp = date('Y-m-d H:i:s', strtotime(trim(substr($line, 5))));
                    break;
                }
            }

        ?>

        Scoutman &copy; {{ date('Y') }}
        <div class="debug">Commit: {{ $shortHash }}. On: {{ $timestamp }}. Server: {{gethostname()}}.</div>
    </footer>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>

    @yield('javascript')
</body>
</html>
