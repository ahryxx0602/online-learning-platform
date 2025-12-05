@extends('documents::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('documents.name') !!}</p>
@endsection
