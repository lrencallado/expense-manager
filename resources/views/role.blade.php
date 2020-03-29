@extends('layouts.app')

@section('content')

    <role-component
        fetch-url='{{route('read.role')}}'>
    </role-component>
    
@endsection