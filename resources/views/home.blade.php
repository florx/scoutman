@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					You are logged in!
				</div>
			</div>
		</div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Completed badges</div>

                <div class="panel-body">
                    <p>This is a list of badges that are complete, but haven't been awarded.</p>

                    @foreach($badges as $badge)

                        @if(count($badge->youthsComplete) > 0)
                            <img src="/images/badges/{{ $badge->image }}" height="50" width="50" align="left" />
                            <strong>{{ $badge->name }}</strong>:

                            @foreach($badge->youthsComplete as $youth)

                                    {{ $youth->name }},
                            @endforeach

                            <hr />
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
