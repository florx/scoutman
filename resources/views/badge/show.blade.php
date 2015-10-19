@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Assign Badge Requirements</div>

                    <div class="panel-body">

                        {!! Form::open(['url' => 'badges/'.$badge->id]) !!}

                        @if($errors->has())
                            <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        @endif

                        <div class="row">

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Badge Information</h3>
                                    </div>
                                    <div class="panel-body">
                                        <img src="/images/badges/{{$badge->image}}" height="100" width="100" class="pull-right" />
                                        <h2>{{$badge->name}}</h2>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Youths</h3>
                                    </div>
                                    <div class="panel-body js-youth-panel">

                                        <p><a href="#" class="js-youth-select-all">Select All</a> /
                                        <a href="#" class="js-youth-deselect-all">Deselect All</a></p>

                                        <table class="table table-striped table-hover">
                                            <!--<thead>
                                                <tr>
                                                    <th>Youth</th>
                                                    <th></th>
                                                </tr>
                                            </thead>-->
                                            <tbody>
                                                @foreach($youthList as $youth)
                                                <tr>
                                                    <td><label for="youth[{{ $youth->id }}]"> {{ $youth->name }}
                                                        @if(is_null($badge->category->section))
                                                            <small>({{ $youth->section->name }})</small>
                                                        @endif
                                                        </label></td>
                                                    <td>{!! Form::checkbox('youth['.$youth->id.']', 'Y') !!}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                            </div>


                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Requirements</h3>
                                    </div>
                                    <div class="panel-body">

                                        <ul>

                                        @foreach($badge->requirements as $requirement)
                                            <li>{{ $requirement->content }}

                                                @if(count($requirement->requirements) > 0)
                                                    <ol>
                                                    @foreach($requirement->requirements as $subReq)
                                                        <li class="badge-sub-requirement"><label>
                                                            @if($subReq->text_entry == 1)
                                                                {!! Form::text('req['.$subReq->id.']') !!}
                                                            @else
                                                                {!! Form::checkbox('req['.$subReq->id.']', 'Y') !!}
                                                            @endif
                                                                {{$subReq->content}}
                                                            </label></li>
                                                    @endforeach
                                                    </ol>
                                                @endif
                                            </li>
                                        @endforeach

                                        </ul>

                                        <button type="submit" class="btn btn-primary form-control">Assign</button>

                                    </div>
                                </div>






                            </div>

                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $('.js-youth-select-all').click(function(){
                console.log('check');
                $('.js-youth-panel input[type=checkbox]').prop('checked', true);
                return false;
            });

            $('.js-youth-deselect-all').click(function(){
                $('.js-youth-panel input[type=checkbox]').prop('checked', false);
                return false;
            });

        });
    </script>
@endsection