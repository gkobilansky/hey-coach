 
    {{--  <button type="button" class="navbar-toggle menu-txt-toggle" style=""><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>  --}}

        <!--NOTIFICATIONS START-->
        <div class="menu">
                <div class="notifications-header"><p>Notifications</p></div>
                    <!-- Menu -->
                    <ul>
                        <?php $notifications = auth()->user()->unreadNotifications; ?>
                        @foreach($notifications as $notification)
                            <a href="{{ route('notification.read', ['id' => $notification->id])  }}" onClick="postRead({{ $notification->id }})">
                                <li> 
                                    <img src="/{{ auth()->user()->avatar }}" class="notification-profile-image">
                                    <p>{{ $notification->data['message']}}</p>
                                </li>
                            </a>
                        @endforeach 
                    </ul>
                </div> 
 {{--  <nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas-sm" role="navigation">
        <div class="list-group panel">
            <a href="{{route('dashboard', \Auth::id())}}" class=" list-group-item" data-parent="#MainMenu"><i
                        class="glyphicon sidebar-icon glyphicon-dashboard"></i><span id="menu-txt">{{ __('Dashboard') }}</span> </a>
            <a href="{{route('users.show', \Auth::id())}}" class=" list-group-item" data-parent="#MainMenu"><i
                        class="glyphicon sidebar-icon glyphicon-user"></i><span id="menu-txt">{{ __('Profile') }}</span> </a>


            <a href="#athletes" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="glyphicon sidebar-icon glyphicon-tag"></i><span id="menu-txt">{{ __('Athletes') }}</span>
            <i class="ion-chevron-up  arrow-up sidebar-arrow"></i></a>
            <div class="collapse" id="athletes">

                <a href="{{ route('athletes.index')}}" class="list-group-item childlist">{{ __('All Athletes') }}</a>
                @if(Entrust::can('athlete-create'))
                    <a href="{{ route('athletes.create')}}"
                       class="list-group-item childlist">{{ __('New Athlete') }}</a>
                @endif
            </div>

            <a href="#tasks" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="glyphicon sidebar-icon glyphicon-tasks"></i><span id="menu-txt">{{ __('Tasks') }}</span>
            <i class="ion-chevron-up  arrow-up sidebar-arrow"></i></a>
            <div class="collapse" id="tasks">
                <a href="{{ route('tasks.index')}}" class="list-group-item childlist">{{ __('All Tasks') }}</a>
                @if(Entrust::can('task-create'))
                    <a href="{{ route('tasks.create')}}" class="list-group-item childlist">{{ __('New Task') }}</a>
                @endif
            </div>

            <a href="#user" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="sidebar-icon fa fa-users"></i><span id="menu-txt">{{ __('Users') }}</span>
            <i class="ion-chevron-up  arrow-up sidebar-arrow"></i></a>
            <div class="collapse" id="user">
                <a href="{{ route('users.index')}}" class="list-group-item childlist">{{ __('Users All') }}</a>
                @if(Entrust::can('user-create'))
                    <a href="{{ route('users.create')}}"
                       class="list-group-item childlist">{{ __('New User') }}</a>
                @endif
            </div>

            <a href="#recruits" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="glyphicon sidebar-icon glyphicon-hourglass"></i><span id="menu-txt">{{ __('Recruits') }}</span>
            <i class="ion-chevron-up  arrow-up sidebar-arrow"></i></a>
            <div class="collapse" id="recruits">
                <a href="{{ route('recruits.index')}}" class="list-group-item childlist">{{ __('All Recruits') }}</a>
                @if(Entrust::can('recruit-create'))
                    <a href="{{ route('recruits.create')}}"
                       class="list-group-item childlist">{{ __('New Recruit') }}</a>
                @endif
            </div>
            <a href="#departments" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                        class="sidebar-icon glyphicon glyphicon-list-alt"></i><span id="menu-txt">{{ __('Departments') }}</span>
            <i class="ion-chevron-up  arrow-up sidebar-arrow"></i></a>
            <div class="collapse" id="departments">
                <a href="{{ route('departments.index')}}"
                   class="list-group-item childlist">{{ __('All Departments') }}</a>
                @if(Entrust::hasRole('administrator'))
                    <a href="{{ route('departments.create')}}"
                       class="list-group-item childlist">{{ __('New Department') }}</a>
                @endif
            </div>

            @if(Entrust::hasRole('administrator'))
                <a href="#settings" class=" list-group-item" data-toggle="collapse" data-parent="#MainMenu"><i
                            class="glyphicon sidebar-icon glyphicon-cog"></i><span id="menu-txt">{{ __('Settings') }}</span>
                <i class="ion-chevron-up  arrow-up sidebar-arrow"></i></a>
                <div class="collapse" id="settings">
                    <a href="{{ route('settings.index')}}"
                       class="list-group-item childlist">{{ __('Overall Settings') }}</a>

                    <a href="{{ route('roles.index')}}"
                       class="list-group-item childlist">{{ __('Role Management') }}</a>
                    <a href="{{ route('integrations.index')}}"
                       class="list-group-item childlist">{{ __('Integrations') }}</a>
                </div>

            @endif
            <a href="{{ url('/logout') }}" class=" list-group-item impmenu" data-parent="#MainMenu"><i
                        class="glyphicon sidebar-icon glyphicon-log-out"></i><span id="menu-txt">{{ __('Sign Out') }}</span> </a>

        </div>
    </nav>  --}}
                

 @push('scripts')
            <script>
                $('#notification-clock').click(function (e) {
                    e.stopPropagation();
                    $(".menu").toggleClass('bar')
                });
                $('body').click(function (e) {
                    if ($('.menu').hasClass('bar')) {
                        $(".menu").toggleClass('bar')
                    }
                })
                id = {};

                function postRead(id) {
                    $.ajax({
                        type: 'post',
                        url: '{{url(' / notifications / markread ')}}',
                        data: {
                            id: id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                }
            </script>
@endpush