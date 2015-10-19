@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading ">Badge List for {{$youth->name}}</div>


                    <div class="panel-body">

                        <a href="{{ url('/youths/'. $youth->id .'/badges/massAssign') }}" class="btn btn-primary pull-right">Mass Assign</a>

                        <div class="row">

                            @foreach($categoryList as $category)

                                <div class="col-md-6">


                                    <div class="panel panel-default">
                                        <div class="panel-heading ">{{ $category->name }}
                                            @unless(is_null($category->section)) ({{ $category->section->name }}) @endunless
                                        </div>


                                        <div class="panel-body">

                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Badge</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($category->badges as $badge)
                                                    <tr>
                                                        <td><img src="/images/badges/{{ $badge->image }}" height="50" width="50" /></td>
                                                        <td><a href="/youths/{{$youth->id}}/badges/{{ $badge->id }}">{{ $badge->name }}</a>

                                                            @if(isset($badgeStatusMap[$badge->id]))
                                                                <span class="label label-success pull-right">{{$badgeStatusMap[$badge->id]->status}}</span>

                                                                @if($badgeStatusMap[$badge->id]->instructor == 1)
                                                                    <span class="label label-info">Instructor</span>
                                                                @elseif($badgeStatusMap[$badge->id]->plus == 1)
                                                                    <span class="label label-info">Plus</span>
                                                                @endif

                                                            @endif

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
@endsection
