@extends('layouts.settings')
@section('settings_content')
    <div class="container-fluid">
        <form action="{{ route('revenue-categories.update', $revenueCategory->id) }}" method="POST" class="ajax-form">
            @csrf
            @method('PUT')
            @include('admin.revenue-category.form')
        </form>
    </div>
@endsection
