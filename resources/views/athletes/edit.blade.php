@extends('layouts.master')
@section('heading')
    Edit Athlete ({{$athlete->name}})
@stop

@section('content')
    {!! Form::model($athlete, [
            'method' => 'PATCH',
            'route' => ['athletes.update', $athlete->id],
            ]) !!}
    @include('athletes.form', ['submitButtonText' => __('Update athlete')])

    {!! Form::close() !!}

@stop