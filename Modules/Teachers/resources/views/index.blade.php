@extends('teachers::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('teachers.name') !!}</p>
@endsection
