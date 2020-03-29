@extends('layouts.app')

@section('content')
    <expenses-component
        fetch-url="{{route('read.expense')}}"
        :expensecategory="{{$data}}"
    ></expenses-component>   
@endsection


