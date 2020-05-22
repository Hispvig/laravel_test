@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel-body">
        <router-view name="newsIndex"></router-view>
        <router-view></router-view>
    </div>
</div>
@endsection
