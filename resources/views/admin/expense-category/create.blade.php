@extends('layouts.settings')

@section('settings_content')
    <div class="container-fluid">
        <form action="{{ route('expense-categories.store') }}" method="POST" class="ajax-form">
            @csrf
            @include('admin.expense-category.form')
        </form>
    </div>
@endsection
