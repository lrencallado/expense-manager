@extends('layouts.app')

@section('content')
    <user-component
        fetch-url="{{route('read.user')}}"
        :roles="{{$data}}"
    ></user-component>   
@endsection


