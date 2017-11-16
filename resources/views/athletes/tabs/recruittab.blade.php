<div id="recruit" class="tab-pane fade">
    <div class="boxspace">
        <table class="table table-hover">
            <h4>{{ __('All Recruits') }}</h4>
            <thead>
            <thead>
            <tr>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Assigned user') }}</th>
                <th>{{ __('Created at') }}</th>
                <th>{{ __('Deadline') }}</th>

                <th><a href="{{ route('recruits.create', ['athlete' => $athlete->id])}}">
                        <button class="btn btn-success">{{ __('New Recruit') }}</button>
                    </a></th>

            </tr>
            </thead>
            <tbody>
            <?php  $tr = ""; ?>
          
            @foreach($athlete->recruits as $recruit)
                @if($recruit->status_id == 1)
                    <?php  $tr = '#adebad'; ?>
                @elseif($recruit->status_id == 2)
                    <?php $tr = '#ff6666'; ?>
                @endif
                <tr style="background-color:<?php echo $tr;?>">

                    <td><a href="{{ route('recruits.show', $recruit->id) }}">{{$recruit->title}} </a></td>
                    <td>
                        <div class="popoverOption"
                             rel="popover"
                             data-placement="left"
                             data-html="true"
                             data-original-title="<span class='glyphicon glyphicon-user' aria-hidden='true'> </span> {{$recruit->user->name}}">
                            <div id="popover_content_wrapper" style="display:none; width:250px;">
                                <img src='http://placehold.it/350x150' height='80px' width='80px'
                                     style="float:left; margin-bottom:5px;"/>
                                <p class="popovertext">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"> </span>
                                    <a href="mailto:{{$recruit->user->email}}">
                                        {{$recruit->user->email}}<br/>
                                    </a>
                                    <span class="glyphicon glyphicon-headphones" aria-hidden="true"> </span>
                                    <a href="mailto:{{$recruit->user->work_number}}">
                                    {{$recruit->user->work_number}}</p>
                                </a>

                            </div>
                            <a href="{{route('users.show', $recruit->user->id)}}"> {{$recruit->user->name}}</a>

                        </div> <!--Shows users assigned to recruit -->
                    </td>
                    <td>{{date('d, M Y, H:i', strTotime($recruit->contact_date))}} </td>
                    <td>{{date('d, M Y', strTotime($recruit->contact_date))}}
                        @if($recruit->status_id == 1)({{ $recruit->days_until_contact }})@endif </td>
                    <td></td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
</div>