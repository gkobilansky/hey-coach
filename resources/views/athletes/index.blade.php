@extends('layouts.master')
@section('heading')

@stop

@section('content')

    <table class="table table-hover " id="athletes-table">
        <thead>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Organization') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Phone Number') }}</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
    </table>

@stop

@push('scripts')
<script>
    $(function () {
        $('#athletes-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('athletes.data') !!}',
            columns: [

                {data: 'namelink', name: 'name'},
                {data: 'company_name', name: 'company_name'},
                {data: 'email', name: 'email'},
                {data: 'primary_number', name: 'primary_number'},
                @if(Entrust::can('athlete-update'))
                { data: 'edit', name: 'edit', orderable: false, searchable: false},
                @endif
                @if(Entrust::can('athlete-delete'))
                { data: 'delete', name: 'delete', orderable: false, searchable: false},
                @endif

            ]
        });
    });
</script>
@endpush
