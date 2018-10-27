@extends('layouts.master')
@section('heading')
    <h1>{{ __('All users') }}</h1>
@stop

@section('content')
    <table class="table table-hover" id="users-table">
        <thead>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Mail') }}</th>
            <th>{{ __('Work number') }}</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
    </table>


        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Handle deletion of user</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form">

           <!--HANDLE TASKS-->
            <div class="form-group">
          <label for="tasks"><span class=""></span> {{ __('How to handle the user tasks?') }}</label>
        <select name="handle_tasks" id="handle_tasks" class="form-control">
            <option value="delete_all_tasks">{{ __('Delete all tasks') }}</option>
            <option value="move_all_tasks"> {{ __('Move all tasks') }}</option>
        </select>   
     </div>
            <div class="form-group" id="assign_tasks" style="display:none">
          <label for="user_tasks"><span class="glyphicon glyphicon-user"></span> {{ __('Choose a new user to assign the tasks') }}</label>
        <select name="user_tasks" id="user_tasks" class="form-control">
            <option value="null" disabled selected> {{ __('Select a user') }} </option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>   
            </div>

             <!--HANDLE RECRUITS-->
            <div class="form-group">
          <label for="handle_recruits"><span class=""></span> {{ __('How to handle the user recruits?') }}</label>
        <select name="recruits" id="handle_recruits" class="form-control">
            <option value="delete_all_recruits">{{ __('Delete all recruits') }}</option>
            <option value="move_all_recruits"> {{ __('Move all recruits') }}</option>
        </select>   
        </div>
            <div class="form-group" id="assign_recruits" style="display:none">
          <label for="user_recruits"><span class="glyphicon glyphicon-user"></span> {{ __('Choose a new user to assign the recruits') }}</label>
        <select name="user_recruits" id="user_recruits" class="form-control">
            <option value="null" disabled selected> {{ __('Select a user') }} </option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>   
            </div>

            <!--HANDLE ATHLETES-->
        <div class="form-group">
          <label for="handle_athletes"><span class=""></span> {{ __('How to handle the user athletes?') }}</label>
        <select name="athletes" id="handle_athletes" class="form-control">
            <option value="delete_all_athletes">{{ __('athletes') }}</option>
            <option value="move_all_athletes"> {{ __('Move all athletes') }}</option>
        </select>   
        </div>
            <div class="form-group" id="assign_athletes" style="display:none">
          <label for="user_athletes"><span class="glyphicon glyphicon-user"></span> {{ __('Choose a new user to assign the athletes') }}</label>
        <select name="user_athletes" id="user_athletes" class="form-control">
            <option value="null" disabled selected> {{ __('Select a user') }} </option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>   
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
          <button type="submit" id="confirm_delete" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Login</button>
        </div>
      </div>
      
    </div>
  </div> 

@stop

@push('scripts')
<script>
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('users.data') !!}',
            columns: [

                {data: 'namelink', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'work_number', name: 'work_number'},
                    @if(Entrust::can('user-update'))
                {
                    data: 'edit', name: 'edit', orderable: false, searchable: false
                },
                    @endif
                    @if(Entrust::can('user-delete'))
                {
                    data: 'delete', name: 'delete', orderable: false, searchable: false
                },
                @endif
            ]
        });
    });

     function openModal(athlete_id) {
        $("#confirm_delete").attr('delete-id', athlete_id);
        $("#myModal").modal();
    }
    
    $("#handle_tasks").click(function () {
    
    if($("#handle_tasks").val() == "move_all_tasks") {
        $("#assign_tasks").css('display', 'block');
    } else 
    {
        $("#assign_tasks").css('display', 'none');
    }

    });


    $("#handle_athletes").click(function () {

   if($("#handle_athletes").val() == "move_all_athletes") {
            $("#assign_athletes").css('display', 'block');
    } else {
        $("#assign_athletes").css('display', 'none');
    }
    });
    
    $("#handle_recruits").click(function () {

   if($("#handle_recruits").val() == "move_all_recruits") {
            $("#assign_recruits").css('display', 'block');
    } else {
        $("#assign_recruits").css('display', 'none');
    }
    });

    $("#confirm_delete").click(function () {
        id = $(this).attr("delete-id"); 
       handle_recruits = $("#handle_recruits").val();
       handle_tasks =  $("#handle_tasks").val();
       handle_athletes =  $("#handle_athletes").val()
       recruits_user = $("#user_recruits").val();
       tasks_user = $("#user_tasks").val();
       athletes_user = $("#user_athletes").val();
        $.ajax({
            url: "/users/" + id,
            type: 'DELETE',
                headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
        data: {
        tasks: handle_tasks,
        recruits: handle_recruits,
        athletes: handle_athletes,
        task_user: tasks_user,
        recruit_user: recruits_user,
        athlete_user: athletes_user,
       },   
        complete: function (jqXHR, textStatus) {
                // callback
            },
            success: function (data, textStatus, jqXHR) {
                // success callback
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // error callback
            }
        });
    });
</script>
@endpush
