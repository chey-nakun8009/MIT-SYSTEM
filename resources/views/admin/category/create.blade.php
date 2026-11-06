<x-admin-layout>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.category.form')
    </form>
</x-admin-layout>
