@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default">
                    <div class="panel-heading ">Badge List</div>


                    <div class="panel-body">

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
                                                <td><a href="/badges/{{ $badge->id }}">{{ $badge->name }}</a></td>
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
