@extends('layouts.app')

@section('content')

    <expensecat-component
        fetch-url='{{route('read.expensecat')}}'>
    </expensecat-component>
    
@endsection