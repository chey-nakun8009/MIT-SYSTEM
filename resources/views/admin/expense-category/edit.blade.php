@extends('layouts.settings')

@section('settings_content')
    <div class="container-fluid">
        <form action="{{ route('expense-categories.update', $expenseCategory->id) }}" method="POST" class="ajax-form">
            @csrf
            @method('PUT')
            @include('admin.expense-category.form')
        </form>
    </div>
@endsection
