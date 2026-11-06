<x-admin-layout>
    <div class="container-fluid">
        @include('admin.product.partials._tabs')
        <div id="product-content">
            @include('admin.product-variants.partials._content')
        </div>
    </div>
</x-admin-layout>
