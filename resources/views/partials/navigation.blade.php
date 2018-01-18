 
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