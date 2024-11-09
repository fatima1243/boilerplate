@extends('user.main')
@section('cononical-tag', 'https://mooveto.co.uk/')
@section('title', 'Mooveto')
@section('description',
    'Test')
@section('main-section')
    <div class="">
        @include('user.layouts.response')
    </div>
    <job-listing-component :jobs="{{ json_encode($jobs) }}" :role="{{ json_encode($roleId) }}" :dynamic-component="'job-listing-component'"></job-listing-component>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"
        integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            feather.replace();
        });
    </script>
@endpush
