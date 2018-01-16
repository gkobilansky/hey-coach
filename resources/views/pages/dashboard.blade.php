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
        <div class="row">
            <el-button type="text" @click="dialogFormVisible = true">Add New Recruit</el-button>
        </div>
        <div class="row">
            <create></create>
        </div>
        <div class="row">
          <pipeline :stages="{{$allStatuses}}" :blocks="{{$recruitRecords}}" v-on:update-block="updateBlock"></pipeline>
        </div>
@endsection
