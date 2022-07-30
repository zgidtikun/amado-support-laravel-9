@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<ol class="breadcrumb bg-white">
    <li class="breadcrumb-item">@yield('title')</li>
</ol>
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
