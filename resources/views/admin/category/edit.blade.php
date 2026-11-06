<x-admin-layout>
    <form action="{{ route('categories.update', $category->id) }}" method="POST"
        enctype="multipart/form-data" id="categoryForm">
        @csrf
        @method('PATCH')
        @include('admin.category.form')
    </form>
</x-admin-layout>
