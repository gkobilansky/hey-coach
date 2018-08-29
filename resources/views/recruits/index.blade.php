@extends('layouts.master')
@section('heading')
    <h1>{{__('All recruits')}}</h1>
@stop

@section('content')
    <table class="table table-hover" id="recruits-table">
        <thead>
        <tr>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Athlete') }}</th>
            <th>{{ __('Created by') }}</th>
            <th>{{ __('Deadline') }}</th>
            <th>{{ __('Assigned') }}</th>

        </tr>
        </thead>
    </table>
@stop

@push('scripts')
<script>
    $(function () {
        $('#recruits-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('recruits.databycollege') !!}',
            columns: [
                {data: 'status_id', name: 'status_id'},
                {data: 'titlelink', name: 'title'},
                {data: 'athlete_id', name: 'athlete_id'},
                {data: 'user_created_id', name: 'user_created_id'},
                {data: 'contact_date', name: 'contact_date',},
                {data: 'user_assigned_id', name: 'user_assigned_id'},


            ]
        });
    });
</script>
@endpush