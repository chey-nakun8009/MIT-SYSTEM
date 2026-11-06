<x-admin-layout>
    <div class="container-fluid">
        @include('admin.product.partials._tabs')
        <div id="product-content">
            <form class="ajax-form"
                action="{{ route('attributes.values.store', [
                    'attribute' => $attribute->id,
                ]) }}"
                method="POST">
                @csrf
                @include('admin.attribute-value.form')
            </form>
        </div>
    </div>
</x-admin-layout>
