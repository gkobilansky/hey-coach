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
        {{--  <div class="row">
            <create></create>
        </div>  --}}
          <pipeline :stages="{{$allStatuses}}" :blocks="{{$recruitRecords}}" v-on:update-block="updateBlock"></pipeline>
    
@endsection
