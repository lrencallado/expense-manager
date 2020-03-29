@extends('layouts.app')

@section('content')
    
    <dashboard-component
    :chart-data="{{ json_encode($result->data) }}"
    :record="{{ json_encode([])}}">
    </dashboard-component>
    
@endsection