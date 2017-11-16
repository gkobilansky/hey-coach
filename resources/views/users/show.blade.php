@extends('layouts.master')
    @section('content')
    @include('partials.userheader')
<div class="col-sm-8">
  <el-tabs active-name="tasks" style="width:100%">
    <el-tab-pane label="Tasks" name="tasks">
        <table class="table table-hover" id="tasks-table">
        <h3>{{ __('Tasks assigned') }}</h3>
            <thead>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Athlete') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>
                        <select name="status" id="status-task">
                        <option value="" disabled selected>{{ __('Status') }}</option>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                            <option value="all">All</option>
                        </select>
                    </th>
                </tr>
            </thead>
        </table>
    </el-tab-pane>
    <el-tab-pane label="Recruits" name="recruits">
      <table class="table table-hover">
        <table class="table table-hover" id="recruits-table">
                <h3>{{ __('Recruits assigned') }}</h3>
                <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Athlete') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>
                        <select name="status_id" id="status-recruit">
                        <option value="" disabled selected>{{ __('Status') }}</option>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                            <option value="all">All</option>
                        </select>
                    </th>
                </tr>
                </thead>
            </table>
    </el-tab-pane>
    <el-tab-pane label="Athletes" name="athletes">
         <table class="table table-hover" id="athletes-table">
                <h3>{{ __('Athletes assigned') }}</h3>
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Company') }}</th>
                    <th>{{ __('Primary number') }}</th>
                </tr>
                </thead>
            </table>
    </el-tab-pane>
  </el-tabs>
  </div>
  <div class="col-sm-4">
  <h4>{{ __('Tasks') }}</h4>
<doughnut :statistics="{{$task_statistics}}"></doughnut>
<h4>{{ __('Recruits') }}</h4>
<doughnut :statistics="{{$recruit_statistics}}"></doughnut>
  </div>

   @stop 
@push('scripts')
        <script>
        $('#pagination a').on('click', function (e) {
            e.preventDefault();
            var url = $('#search').attr('action') + '?page=' + page;
            $.post(url, $('#search').serialize(), function (data) {
                $('#posts').html(data);
            });
        });

            $(function () {
              var table = $('#tasks-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.taskdata', ['id' => $user->id]) !!}',
                    columns: [

                        {data: 'titlelink', name: 'title'},
                        {data: 'athlete_id', name: 'Athlete', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'deadline', name: 'deadline'},
                        {data: 'status', name: 'status', orderable: false},
                    ]
                });

                $('#status-task').change(function() {
                selected = $("#status-task option:selected").val();
                    if(selected == 'open') {
                        table.columns(4).search(1).draw();
                    } else if(selected == 'closed') {
                        table.columns(4).search(2).draw();
                    } else {
                         table.columns(4).search( '' ).draw();
                    }
              });  

          });
            $(function () {
                $('#athletes-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.athletedata', ['id' => $user->id]) !!}',
                    columns: [

                        {data: 'athletelink', name: 'name'},
                        {data: 'company_name', name: 'company_name'},
                        {data: 'primary_number', name: 'primary_number'},

                    ]
                });
            });

            $(function () {
              var table = $('#recruits-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.recruitdata', ['id' => $user->id]) !!}',
                    columns: [

                        {data: 'titlelink', name: 'title'},
                        {data: 'athlete_id', name: 'Athlete', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'contact_date', name: 'contact_date'},
                        {data: 'status_id', name: 'status_id', orderable: false},
                    ]
                });

              $('#status-recruit').change(function() {
                selected = $("#status-recruit option:selected").val();
                    if(selected == 'open') {
                        table.columns(4).search(1).draw();
                    } else if(selected == 'closed') {
                        table.columns(4).search(2).draw();
                    } else {
                         table.columns(4).search( '' ).draw();
                    }
              });  
          });
        </script>
@endpush


