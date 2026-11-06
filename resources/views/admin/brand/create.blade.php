<x-admin-layout>
    <form class="ajax-form" action="{{ route('brands.store') }}" method="POST">
        @csrf
        @include('admin.brand.form')
    </form>
</x-admin-layout>
