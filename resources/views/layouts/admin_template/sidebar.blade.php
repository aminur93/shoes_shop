<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li class="nav-item has-treeview {{ Request::routeIs('category','category.create','category.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('category','category.create','category.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('category') }}" class="nav-link {{ Request::routeIs('category','category.create','category.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ Request::routeIs('products','products.create','products.edit','product_gallery','gallery_image_create','gallery_image_edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('products','products.create','products.edit','product_gallery','gallery_image_create','gallery_image_edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('products') }}" class="nav-link {{ Request::routeIs('products','products.create','products.edit','product_gallery','gallery_image_create','gallery_image_edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview {{ Request::routeIs('product_stock','product_stock.create','product_stock.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('product_stock','product_stock.create','product_stock.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Products Stock
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('product_stock') }}" class="nav-link {{ Request::routeIs('product_stock','product_stock.create','product_stock.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ Request::routeIs('order','order.invoice','order.details') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('order','order.invoice','order.details') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Orders
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('order') }}" class="nav-link {{ Request::routeIs('order','order.invoice','order.details') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ Request::routeIs('slider','slider.create','slider.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('slider','slider.create','slider.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Products Slider
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('slider') }}" class="nav-link {{ Request::routeIs('slider','slider.create','slider.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slider</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview {{ Request::routeIs('user','user.create','user.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('user','user.create','user.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user') }}" class="nav-link {{ Request::routeIs('user','user.create','user.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview {{ Request::routeIs('logo','logo.create','logo.edit','banner','banner.create','banner.edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('logo','logo.create','logo.edit','banner','banner.create','banner.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('logo') }}" class="nav-link {{ Request::routeIs('logo','logo.create','logo.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logo</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('banner') }}" class="nav-link {{ Request::routeIs('banner','banner.create','banner.edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Banner</p>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>