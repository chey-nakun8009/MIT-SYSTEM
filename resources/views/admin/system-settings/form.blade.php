<form method="POST" action="{{ route('system-settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    @include('admin.system-settings.partials._general')
    @include('admin.system-settings.partials._theme')
    <div class="mt-4">

        <button class="btn btn-sm btn-primary rounded-0">
            រក្សាទុក <x-svg.save />
        </button>

    </div>


</form>
