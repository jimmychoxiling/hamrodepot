<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{asset('images/logo.svg')}}" alt="">
            {{-- <img src="{{ asset('image/logo.png') }}" class="navbar-brand-img" >--}}
            <!-- {{ config('app.name') }} -->
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        @if(!empty(auth()->user()->image) && \Illuminate\Support\Facades\Storage::exists(auth()->user()->image))
                                <img src="{{ url('storage') . '/' .  auth()->user()->image}}">
                            @else
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/usericon.png">
                            @endif
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                @role('Admin|Seller')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/order') || request()->is('manage/orders-detail*')) ? 'active' : '' }}" href="{{ route('order') }}">
                        <i class="fa fa-shopping-cart text-default"></i>
                        <span class="nav-link-text">Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/products') || request()->is('manage/products-create') || request()->is('manage/products-edit*') || request()->is('manage/products-show*')) ? 'active' : '' }}" href="{{ route('products') }}">
                        <i class="fa fa-shopping-cart text-default"></i>
                        <span class="nav-link-text">Products</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/service/category') || request()->is('manage/service/category/create') ) ? 'active' : '' }}"
                       href="#services" data-toggle="collapse" role="button"
                       aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-user text-default"></i>
                        <span class="nav-link-text">Services</span>
                    </a>

                    <div
                        class="collapse {{ (request()->is('manage/service/category') || request()->is('manage/service/category/create') ) ? 'show' : '' }}"
                        id="services">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('manage/service/category') || request()->is('manage/service/category/create')) ? 'active' : '' }}"
                                   href="{{ route('service.category') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">Service Category</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('manage/service') || request()->is('manage/service/create')) ? 'active' : '' }}"
                                   href="{{ route('services') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">Service </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('manage/service-request')) ? 'active' : '' }}"
                                   href="{{ route('service-request') }}">
                                    <i class="fa fa-tasks text-default"></i>
                                    <span class="nav-link-text">Service Request</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/brand')  || request()->is('manage/brand-create') || request()->is('manage/brand-edit*') || request()->is('manage/brand-show*')) ? 'active' : '' }}" href="{{ route('brand') }}">
                        <i class="fa fa-th-large text-default"></i>
                        <span class="nav-link-text">Brand</span>
                    </a>
                </li>
                @endrole
                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/voucher')  || request()->is('manage/voucher-create') || request()->is('manage/voucher-edit*') || request()->is('manage/voucher-show*')) ? 'active' : '' }}" href="{{ route('voucher') }}">
                        <i class="fa fa-gift text-default"></i>
                        <span class="nav-link-text">Discount Coupons</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/category')  || request()->is('manage/category-create') || request()->is('manage/category-edit*') || request()->is('manage/category-show*')) ? 'active' : '' }}" href="{{ route('category') }}">
                        <i class="fa fa-list-alt text-default"></i>
                        <span class="nav-link-text">Category</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/sub-category')  || request()->is('manage/sub-category-create') || request()->is('manage/sub-category-edit*') || request()->is('manage/sub-category-show*')) ? 'active' : '' }}" href="{{ route('sub-category') }}">
                        <i class="fa fa-th text-default"></i>
                        <span class="nav-link-text">Sub-Category</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/type')  || request()->is('manage/type-create') || request()->is('manage/type-edit*') || request()->is('manage/type-show*')) ? 'active' : '' }}" href="{{ route('type') }}">
                        <i class="fa fa-th text-default"></i>
                        <span class="nav-link-text">Types</span>
                    </a>
                </li>
                @endrole
                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/seller') || request()->is('manage/seller-create') || request()->is('manage/seller-edit*') || request()->is('manage/seller-show*') || request()->is('manage/user') || request()->is('manage/user-create') || request()->is('manage/user-edit*') || request()->is('manage/user-show*')) ? 'show' : '' }}" href="#users" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-user text-default"></i>
                        <span class="nav-link-text">Users</span>
                    </a>

                    <div class="collapse {{ (request()->is('manage/seller') || request()->is('manage/seller-create') || request()->is('manage/seller-edit*') || request()->is('manage/seller-show*') || request()->is('manage/user') || request()->is('manage/user-create') || request()->is('manage/user-edit*') || request()->is('manage/user-show*')) ? 'show' : '' }}" id="users">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('seller') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">Sellers</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('user') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">Users</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/blog') || request()->is('manage/blog-create') || request()->is('manage/blog-edit*') || request()->is('manage/blog-show*') || request()->is('manage/blog-category') || request()->is('manage/blog-category-create') || request()->is('manage/blog-category-edit*') || request()->is('manage/blog-category-show*')) ? 'show' : '' }}" href="#blog" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-id-card text-default"></i>
                        <span class="nav-link-text">DIY & Articles</span>
                    </a>

                    <div class="collapse {{ (request()->is('manage/blog') || request()->is('manage/blog-create') || request()->is('manage/blog-edit*') || request()->is('manage/blog-show*') || request()->is('manage/blog-category') || request()->is('manage/blog-category-create') || request()->is('manage/blog-category-edit*') || request()->is('manage/blog-category-show*')) ? 'show' : '' }}" id="blog">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('blog') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">DIY & Articles</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('blog-category') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">DIY & Articles Category</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/setting') || request()->is('manage/setting-edit*')) ? 'active' : '' }}" href="#setting" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-cog text-default"></i>
                        <span class="nav-link-text">Setting</span>
                    </a>

                    <div class="collapse {{ (request()->is('manage/setting') || request()->is('manage/setting-edit*')) ? 'show' : '' }}" id="setting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('setting') }}">
                                    <i class="fa fa-list text-default"></i>
                                    <span class="nav-link-text">Setting</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manage/contacts') ? 'active' : '' }}" href="{{route('contacts')}}">
                        <i class="fa fa-address-book text-default"></i>
                        <span class="nav-link-text">Contact Us</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('manage/faq-question') || request()->is('manage/faq-create') || request()->is('manage/faq-edit')) ? 'active' : '' }}" href="{{route('faq-question')}}">
                        <i class="fa fa-question-circle text-default"></i>
                        <span class="nav-link-text">FAQ</span>
                    </a>
                </li>
                @endrole
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manage/reports') ? 'active' : '' }}" href="{{ route('reports') }}">
                        <i class="fa fa-list-ul text-default"></i>
                        <span class="nav-link-text">Reports</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
