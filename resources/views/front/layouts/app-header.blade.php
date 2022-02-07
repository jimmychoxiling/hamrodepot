<header class="site-header">
    <div class="header-inner">
        <div class="container">
            <div class="header-wrap">
                <div class="logo">
                    <a href="{{ url('/') }}" class="logo__icon">
                    <img src="{{asset('images/logo.svg')}}" alt="">
                        <!-- <div class="icon__inner"></div>
                        <div class="logo__text">LOGO</div> -->
                    </a>
                    <!-- <img src="{{ asset('images/logo.svg') }}" alt="" /> -->
                </div>
                <div class="header-search">
                    <form id="searchbox" class="mz-searchbox" action="{{route('search')}}" method="get" data-parsley-validate="">
                        <div class="mz-searchbox-field">
                            <div class="search-left hidden-xs hidden-sm">
                                <div class="search-dd-wrapper">
                                    <select id="scopeSelector" name="cat">
                                        <option value="">All&nbsp;&nbsp;&nbsp;</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (Request::get('cat') == $category->id ? "selected":"") }}>{{$category->name}}&nbsp;&nbsp;&nbsp;</option>
                                            @if($category->sub_category != '')
                                                @foreach($category->sub_category as $sub_category)
                                                <option value="{{ $sub_category->id }}"  {{ (Request::get('cat') == $sub_category->id ? "selected":"") }}>&nbsp;&nbsp;&nbsp;{{ $sub_category->name }}&nbsp;&nbsp;&nbsp;
                                                </option>
                                                @if($sub_category->level != '')
                                                @foreach($sub_category->level as $level)
                                                <option value="{{ $level->id }}"  {{ (Request::get('cat') == $level->id ? "selected":"") }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $level->name }}&nbsp;&nbsp;&nbsp;
                                                </option>
                                                @endforeach
                                            @endif
                                                @endforeach
                                            @endif
                                        @endforeach


                                    </select>
                                    <div class="scope-text">
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="search-center">
                                <span class="suggestedSearch hidden"></span>
                                <input title="Search Box" placeholder="What can we help you find?" value="{{ Request::get('search') }}"
                                       type="search" class="mz-searchbox-input show-placeholder" autocomplete="off"
                                       name="search" data-mz-role="searchquery" data-mz-original-value=""
                                       data-mz-save-value="false" required>
                                <div class="search-right">
                                    <button class="mz-animated-btn mz-searchbox-button fa fa-search"
                                            type="submit"></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="header-right">
                    <ul>
                        <li class="user-npa-details">
                            @guest
                                <div class="user_auth user_no_login">
                                    <div class="icon">
                                        <a href="javascript:;">
                                            <svg viewBox="64 64 896 896" class="" data-icon="user" width="1em"
                                                 height="1em"
                                                 fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="icon-title"><a href="{{ route('login') }}">Sign in</a>
                                            <span>|</span> <a
                                                href="{{ route('register') }}">New Account</a></div>
                                    </div>
                                </div>
                            @else
                                <div class="user_auth user_with_login">
                                    <div class="icon">
                                        <a href="javascript:;">
                                            <svg viewBox="64 64 896 896" class="" data-icon="user" width="1em"
                                                 height="1em"
                                                 fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="header_my_acc_list">
                                        <a href="javascript:;">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</a>
                                        <ul>
                                            @hasrole('Admin|Seller')
                                            <li><a href="{{ url('/manage') }}"><i class="fa fa-user-o" aria-hidden="true"></i> My Account</a></li>
                                            @else
                                                <li><a href="{{ route('my-account') }}"><i class="fa fa-user-o" aria-hidden="true"></i>My Account</a></li>
                                            @endif
                                            <li>
                                                <a href="{{ route('logout') }}" ><i class="fa fa-sign-out" aria-hidden="true"></i>
                                                    {{ __('Logout') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </li>
                        <li class="cart">
                            <div class="icon">
                                <a href="{{route('cart')}}">
                                    <span class="cart_counter">{{ Cart::instance('cart')->count() }}</span>
                                    <svg viewBox="0 0 1024 1024" class="" data-icon="shopping-cart" width="1em"
                                         height="1em" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M922.9 701.9H327.4l29.9-60.9 496.8-.9c16.8 0 31.2-12 34.2-28.6l68.8-385.1c1.8-10.1-.9-20.5-7.5-28.4a34.99 34.99 0 0 0-26.6-12.5l-632-2.1-5.4-25.4c-3.4-16.2-18-28-34.6-28H96.5a35.3 35.3 0 1 0 0 70.6h125.9L246 312.8l58.1 281.3-74.8 122.1a34.96 34.96 0 0 0-3 36.8c6 11.9 18.1 19.4 31.5 19.4h62.8a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7h161.1a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7H923c19.4 0 35.3-15.8 35.3-35.3a35.42 35.42 0 0 0-35.4-35.2zM305.7 253l575.8 1.9-56.4 315.8-452.3.8L305.7 253zm96.9 612.7c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6zm325.1 0c-17.4 0-31.6-14.2-31.6-31.6 0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6z"></path>
                                    </svg>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-menu">
        <div class="container">
            <div class="mainmenu">
                <ul>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item item-children">
                        <a class="nav-link" href="javascript:;">Hardware</a>
                        <ul>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('hardware', array('slug2' => $category->slug)) }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('brands') }}">Brands</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blogs') }}">DIY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('service') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paint') }}">Paint Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rental') }}">Rental</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
