@extends('layouts.settings')

@section('settings_content')
    <div class="container-fluid">
        <form action="{{ route('revenue-categories.store') }}" method="POST" class="ajax-form">
            @csrf
            @include('admin.revenue-category.form')
        </form>
    </div>
@endsection
