@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading ">Badge Requirements for {{$youth->name}}</div>

                    <div class="panel-body">

                        {!! Form::model($modelData, ['url' => 'youths/'.$youth->id.'/badges/'.$badge->id]) !!}

                        <div class="row">

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Badge Information</h3>
                                    </div>
                                    <div class="panel-body">
                                        <img src="/images/badges/{{$badge->image}}" height="100" width="100" class="pull-right" />
                                        <h2>{{$badge->name}}

                                        @if($upgrade == 'plus')
                                            <span class="label label-info">Plus</span>
                                        @elseif($upgrade == 'instructor')
                                            <span class="label label-info">Instructor</span>
                                        @endif
                                        </h2> for
                                        <h2>{{$youth->name}}</h2>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Badge Status</h3>
                                    </div>
                                    <div class="panel-body">

                                        @if(!in_array($currentStatus, ['Complete', 'Sewn', 'Awarded']))

                                            <p><span class="label label-danger">INCOMPLETE</span></p>

                                            <p>Please check the requirements on the right,
                                                and ensure that all of the requirements are met for this badge to be complete.</p>

                                        @else

                                            <p><span class="label label-success">{{ strtoupper($currentStatus) }}</span> <small>({{$statusTime}})</small></p>

                                            {!! Form::label('status', 'Update Status:') !!}
                                            {!! Form::select('status', ['Remove' => 'Remove', 'Complete' => 'Complete','Awarded' => 'Awarded', 'Sewn' => 'Sewn'], $currentStatus, ['class' => 'form-control']) !!}
                                            <br />
                                            {!! Form::label('radios', 'Upgrade:') !!}
                                            <div class="radio">
                                                <label>
                                                    {!! Form::radio('upgrade', 'none', ($upgrade == 'none') ? true : false) !!}
                                                    Normal
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    {!! Form::radio('upgrade', 'plus', ($upgrade == 'plus') ? true : false) !!}
                                                    {{$badge->name}} Plus
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    {!! Form::radio('upgrade', 'instructor',  ($upgrade == 'instructor') ? true : false) !!}
                                                    {{$badge->name}} Instructor
                                                </label>
                                            </div>

                                        @endif

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
                                                                <li class="badge-sub-requirement @if(!empty($modelData['req'][$subReq->id])) badge-sub-requirement-complete @endif"><label>
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

                                        <button type="submit" class="btn btn-primary form-control">Update</button>

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