<!DOCTYPE html>
<html lang="en">
@include('includes.head')

<body class="ecommerce">
    <div class="color-panel hidden-sm">
        <div class="color-mode-icons icon-color"></div>
        <div class="color-mode-icons icon-color-close"></div>
        <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
                <li class="color-red current color-default" data-style="red"></li>
                <li class="color-blue" data-style="blue"></li>
                <li class="color-green" data-style="green"></li>
                <li class="color-orange" data-style="orange"></li>
                <li class="color-gray" data-style="gray"></li>
                <li class="color-turquoise" data-style="turquoise"></li>
            </ul>
        </div>
    </div>
    @include('includes.top_bar')
    @include('includes.header')
    <div class="page-slider margin-bottom-35">
        @include('includes.slideshow')
    </div>
    <div class="main">
        <div class="container">
            <div class="row margin-bottom-40">
                <div class="col-md-12 sale-product">
                    <h2>New Arrivals</h2>
                    <div class="owl-carousel owl-carousel5">
                        @include('includes.product-card')
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-40 ">
                @include('includes.side_bar')
                @include('includes.content')
            </div>
            @include('includes.two-products')
        </div>
    </div>

    @include('includes.brand')
    @include('includes.delivery_step')
    @include('includes.pre-footer')
    @include('includes.footer')
    @include('includes.product-popup')
    @include('includes.anyjs')
</body>

</html>
