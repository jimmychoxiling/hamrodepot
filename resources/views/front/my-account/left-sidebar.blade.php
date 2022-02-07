<div class="col col-3">
    <div class="card account_side_bar">
        <div class="card_title">
            <h2>My Account</h2>
        </div>
        <div class="account_side_bar_list_wrap">
            <ul>
                <li class="account_side_bar_item"> <a href="{{ route('my-account') }}" class="{{ (request()->is('my-account')) ? 'active' : '' }}"><i class="fa fa-user" aria-hidden="true"></i> Your Profile</a></li>
                <li class="account_side_bar_item"> <a href="{{ route('wishlist') }}" class="{{ (request()->is('wishlist')) ? 'active' : '' }}"><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</a></li>
                <li class="account_side_bar_item"> <a href="{{ route('orders') }}"  class="{{ (request()->is('orders')) ? 'active' : '' }}"><i class="fa fa-archive" aria-hidden="true"></i> Your Order</a></li>
                <li class="account_side_bar_item"> <a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
