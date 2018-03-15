@extends('stats::layouts.admin')

@section('title', 'Stats')
@section('actions')
    <li>
        <a href="{!! url('/stats/admin/create') !!}">
            <i class="ti-plus"></i>
            Add New</a>
    </li>
@endsection
@section('content')
    <div class="card border-blue-bottom">
        <div class="content">
        <div class="header"><h4 class="title">Statistics</h4></div>
            <p>Copyright 2018 - Powered by Zumeweb.com</p>
            <p>There are no options for this module.</p>
        </div>
    </div>
@endsection
