<x-admin-layout>
    <form class="ajax-form" action="{{ route('units.update', $unit->id) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('admin.unit.form')
    </form>
</x-admin-layout>
