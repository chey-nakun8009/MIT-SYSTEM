<x-admin-layout>
    <form class="ajax-form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.user.form')
    </form>
</x-admin-layout>
