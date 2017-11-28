@extends('layouts.master')

@section('heading')

@stop

@section('content')
@push('scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
    <div class="row">
        @include('partials.athleteheader')
         <div class="col-lg-2">
         @if($recruit->status_id == 1)
            {!! Form::model($recruit, [
           'method' => 'PATCH',
            'url' => ['recruits/updateassign', $recruit->id],
            ]) !!}
            {!! Form::select('user_assigned_id', $users, null, ['class' => 'form-control ui search selection top right pointing search-select', 'id' => 'search-select']) !!}
            {!! Form::submit(__('Assign new owner'), ['class' => 'btn btn-primary form-control closebtn']) !!}
            {!! Form::close() !!}
            <div class="recruit-status movedown"><strong>
                {{ __('Status') }}: {{$recruit->status->name }}
            </strong></div>
            {!! Form::model($recruit, [
           'method' => 'PATCH',
           'url' => ['recruits/updatestatus', $recruit->id],
           ]) !!}
            {!! Form::submit('Accepted', ['class' => 'btn btn-success form-control closebtn']) !!}
            {!! Form::close() !!}
            {!! Form::model($recruit, [
           'method' => 'PATCH',
           'url' => ['recruits/updatestatus', $recruit->id],
           ]) !!}

            {!! Form::submit('Rejected', ['class' => 'btn btn-danger form-control closebtn']) !!}
            {!! Form::close() !!}
        @endif
        </div>
        @include('partials.userheader')
       
    </div>

    <div class="row">
        <div class="col-md-9">
            @include('partials.comments', ['subject' => $recruit])
        </div>
        <div class="col-md-3">
            <div class="sidebarheader">
                <p> {{ __('Recruit') }}</p>
            </div>
            <div class="sidebarbox">
                <p>{{ __('Assigned to') }}:
                    <a href="{{route('recruits.show', $recruit->user->id)}}">
                        {{$recruit->user->name}}</a></p>
                <p>{{ __('Created at') }}: {{ date('d F, Y, H:i', strtotime($recruit->created_at))}} </p>
                @if($recruit->days_until_contact < 2)
                    <p>{{ __('Follow up') }}: <span style="color:red;">{{date('d, F Y, H:i', strTotime($recruit->contact_date))}}

                            @if($recruit->status_id == 1) ({!! $recruit->days_until_contact !!}) @endif</span> <i
                                class="glyphicon glyphicon-calendar" data-toggle="modal"
                                data-target="#ModalFollowUp"></i></p> <!--Remove days left if recruit is completed-->

                @else
                    <p>{{ __('Follow up') }}: <span style="color:green;">{{date('d, F Y, H:i', strTotime($recruit->contact_date))}}

                            @if($recruit->status_id == 1) ({!! $recruit->days_until_contact !!})<i
                                    class="glyphicon glyphicon-calendar" data-toggle="modal"
                                    data-target="#ModalFollowUp"></i>@endif</span></p>
                    <!--Remove days left if recruit is completed-->
                @endif
        </div>
        <div class="activity-feed movedown">
            @foreach($recruit->activity as $activity)

                <div class="feed-item">
                    <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{{$activity->text}}</div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>


    <div class="modal fade" id="ModalFollowUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Change deadline') }}</h4>
                </div>

                <div class="modal-body">

                    {!! Form::model($recruit, [
                      'method' => 'PATCH',
                      'route' => ['recruits.followup', $recruit->id],
                      ]) !!}
                    {!! Form::label('contact_date', __('Next follow up'), ['class' => 'control-label']) !!}
                    {!! Form::date('contact_date', \Carbon\Carbon::now()->addDays(7), ['class' => 'form-control']) !!}
                    {!! Form::time('contact_time', '11:00', ['class' => 'form-control']) !!}


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default col-lg-6"
                                data-dismiss="modal">{{ __('Close') }}</button>
                        <div class="col-lg-6">
                            {!! Form::submit( __('Update follow up'), ['class' => 'btn btn-success form-control closebtn']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
       

   