<x-admin-layout>
    <form class="ajax-form" action="{{ route('brands.update', $brand->id) }}" method="POST"enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('admin.brand.form')
    </form>
</x-admin-layout>
