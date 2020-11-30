@extends('layouts.app')

@section('content')
    @if(auth()->user())
        <App :user="{{ auth()->user() }}"></App>
    @else
        <App></App>
    @endif

    
@endsection
