<x-admin-layout>
    <form class="ajax-form" action="{{ route('units.store') }}" method="POST">
        @csrf
        @include('admin.unit.form')
    </form>
</x-admin-layout>
