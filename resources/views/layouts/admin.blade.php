@extends('layouts.app')

@section('styles')
    <style>
        .sidebar .nav-item.active .nav-link {
            background-color: #e91e63;
            box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);
        }
    </style>
@endsection

@section('title', 'Admin')
