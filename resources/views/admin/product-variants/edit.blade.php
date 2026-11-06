<x-admin-layout>
    <div class="container-fluid">
        @include('admin.product.partials._tabs')
        <div class="mb-3">
            <h4 class="mb-1">
                <i class="bi bi-diagram-3 me-2 text-danger"></i>
                {{ __('variant.create') }}
            </h4>
            <p class="text-muted mb-0">
                {{ __('variant.enter_information') }}
            </p>
        </div>
        <form action="{{ route('product-variants.update', $variant->id) }}" method="POST" class="ajax-form">
            @csrf
            @method('PATCH')
            @include('admin.product-variants.form')
        </form>
    </div>
</x-admin-layout>
