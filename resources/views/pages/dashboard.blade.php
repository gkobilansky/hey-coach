@extends('layouts.master')

@section('content')
@push('scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip(); //Tooltip on icons top

            $('.popoverOption').each(function () {
                var $this = $(this);
                $this.popover({
                    trigger: 'hover',
                    placement: 'left',
                    container: $this,
                    html: true,

                });
            });
        });
    </script>
@endpush
    <!-- Small boxes (Stat box) -->
      <div class="row">
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            @foreach($taskCompletedThisMonth as $thisMonth)
                                {{$thisMonth->total}}
                            @endforeach
                        </h3>

                        <p>{{ __('Tasks completed this month') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book-outline"></i>
                    </div>
                    <a href="{{route('tasks.index')}}" class="small-box-footer">{{ __('All Tasks') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            @foreach($recruitCompletedThisMonth as $thisMonth)
                                {{$thisMonth->total}}
                            @endforeach
                        </h3>

                        <p>{{ __('Recruits accepted this month') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('recruits.index')}}" class="small-box-footer">{{ __('All Recruits') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$totalAthletes}}</h3>

                        <p>{{ __('All Athletes') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{route('athletes.index')}}" class="small-box-footer">{{ __('All athletes') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            {{--  <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            @foreach($totalTimeSpent[0] as $sum => $value)

                                {{$value}}
                            @endforeach
                            @if($value == "")
                                0
                            @endif</h3>

                        <p>{{ __('Total hours registered') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer"> {{ __('More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->  --}}
        </div>
        <!-- /.row -->
        <div class="row">
          <pipeline :stages="{{$allStatuses}}" :blocks="{{$recruitRecords}}" v-on:update-block="updateBlock"></pipeline>
        </div>
@endsection
