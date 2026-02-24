@extends('students::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('students.name') !!}</p>
@endsection
