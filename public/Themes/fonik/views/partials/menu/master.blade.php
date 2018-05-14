@php
    $menu_order = collect($dashboard->menu());
    $menu_order = $menu_order->sortBy('order');
@endphp


<!-- MENU Start -->
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu" id="main-nav">
                @each('partials.menu.item', $menu_order, 'item')
            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->