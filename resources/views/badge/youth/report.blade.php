@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Youth "Almost" Badge Report</div>
                    <div class="panel-body">

                        <div class="js-report">

                            <p class="pull-right">Report Last Run: {{ $lastRunTime->diffForHumans() }} <a href="{{ url('/badges/youthReport/rerun') }}" class="btn btn-primary js-rerun-button">Re-run</a></p>

                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Badge</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($youths as $youth)
                                    @if(count($youth->almost_badges) > 0)
                                    <tr>
                                        <td>{{ $youth->first_name }} {{ $youth->last_name }}</td>
                                        <td>
                                            @foreach($youth->almost_badges as $badge)
                                                <a href="/youths/{{$youth->id}}/badges/{{$badge->id}}"><img src="/images/badges/{{ $badge->image }}" height="50" width="50" />
                                                {{ $badge->name }}</a><br />
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="js-rerun-loader big-ajax-load-notification">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

<script>

    $(document).ready(function(){

        $('.js-rerun-button').click(function(event){
            event.preventDefault();

            $('.js-report').hide();
            $('.js-rerun-loader').show();

            $.get($(this).attr('href'), null, function(){
                location.reload();
            });

            return false;
        })

    });

</script>

@endsection