@extends('user.main')
@section('cononical-tag', 'https://mooveto.co.uk/')
@section('title', 'Mooveto')
@section('description',
    'Test')
@section('main-section')
    <div class="">
        @include('user.layouts.response')
    </div>
    <header-component></header-component>
    <not_found-component></not_found-component>
@endsection