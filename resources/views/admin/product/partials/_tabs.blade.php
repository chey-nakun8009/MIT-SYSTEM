<div class="card border-0 shadow-sm mb-3">
    <div class="card-body p-0">
        <div class="product-nav">
            <a href="{{ route('products.index') }}" data-url="{{ route('products.index') }}"
                class="product-nav-item {{ request()->routeIs('products.index', 'products.create', 'products.show', 'products.edit') ? 'active' : '' }}">

                <x-svg.product />

                <span>Products</span>

            </a>

            {{-- Attributes --}}
            <a href="{{ route('attributes.index') }}" data-url="{{ route('attributes.index') }}"
                class="product-nav-item {{ request()->routeIs('attributes.*') ? 'active' : '' }}">

                <x-svg.attribute />

                <span>Attributes</span>

            </a>

            {{-- Variants --}}
            <a href="{{ route('product-variants.index') }}" data-url="{{ route('product-variants.index') }}"
                class="product-nav-item {{ request()->routeIs('product-variants.*') ? 'active' : '' }}">

                <x-svg.variant />

                <span>Variants</span>

            </a>

            {{-- Settings --}}
            <a href="{{ route('products.settings') }}" data-url="{{ route('products.settings') }}"
                class="product-nav-item {{ request()->routeIs('products.settings') ? 'active' : '' }}">

                <x-svg.setting />

                <span>Settings</span>

            </a>

        </div>

    </div>
</div>

<style>
    .product-nav {
        display: flex;
        align-items: stretch;
        overflow-x: auto;
        border-bottom: 1px solid #e9ecef;
        scrollbar-width: thin;
    }

    .product-nav::-webkit-scrollbar {
        height: 4px;
    }

    .product-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .product-nav::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 10px;
    }

    .product-nav-item {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 52px;
        padding: 14px 20px;
        color: #6c757d;
        background: transparent;
        text-decoration: none;
        white-space: nowrap;
        font-size: 14px;
        font-weight: 500;
        border: 0;
        transition:
            color 0.2s ease,
            background-color 0.2s ease;
    }

    .product-nav-item:hover {
        color: #6f4e37;
        background-color: #faf8f6;
        text-decoration: none;
    }

    .product-nav-item.active {
        color: #6f4e37;
        background-color: #fff;
        font-weight: 600;
    }

    .product-nav-item.active::after {
        content: "";
        position: absolute;
        left: 15px;
        right: 15px;
        bottom: -1px;
        height: 3px;
        background-color: #6f4e37;
        border-radius: 3px 3px 0 0;
    }

    .product-nav-item svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .product-nav-item.active svg {
        color: #6f4e37;
    }

    @media (max-width: 767.98px) {

        .product-nav-item {
            min-height: 48px;
            padding: 12px 15px;
            font-size: 13px;
        }

        .product-nav-item svg {
            width: 16px;
            height: 16px;
        }

        .product-nav-item.active::after {
            left: 10px;
            right: 10px;
        }

    }
