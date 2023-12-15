<div class="col-xl-3 col-md-4">
    <aside class="axil-dashboard-aside">
        <nav class="axil-dashboard-nav">
            <div class="nav nav-tabs" role="tablist">
                <a class="nav-item nav-link {{ Request::is('my-orders')?'active':'' }}" href="{{route('my_orders')}}" role="tab"
                    aria-selected="false" tabindex="-1"><i class="fas fa-shopping-basket"></i>&nbsp;&nbsp;My
                    Orders</a>
                <a class="nav-item nav-link {{ Request::is('loyality-points')?'active':'' }}" href="{{route('loyality_points')}}" role="tab"
                    aria-selected="true"><i class="fa-solid fa-coins"></i>&nbsp;&nbsp;My loyality points</a>
                <a class="nav-item nav-link {{ Request::is('track-order')?'active':'' }}" href="{{route('track_order')}}" role="tab"
                    aria-selected="true"><i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;Track your
                    order</a>
                <a class="nav-item nav-link {{ Request::is('wishlist1')?'active':'' }}" href="{{route('wishlist1')}}" role="tab"
                    aria-selected="true"><i class="fa-regular fa-heart"></i>&nbsp;&nbsp;Wishlist</a>
                <a class="nav-item nav-link {{ Request::is('account-details')?'active':'' }}" href="{{route('account_details')}}" role="tab"
                    aria-selected="false" tabindex="-1"><i class="fas fa-user"></i>&nbsp;&nbsp;Account
                    Details</a>
                <a class="nav-item nav-link {{ Request::is('addresses')?'active':'' }}" href="{{route('addresses')}}" role="tab"
                    aria-selected="false" tabindex="-1"><i class="fas fa-home"></i>&nbsp;&nbsp;Addresses</a>
                <a class="nav-item nav-link {{ Request::is('support-ticket')?'active':'' }}" href="{{route('support_ticket')}}" role="tab"
                    aria-selected="false" tabindex="-1"><i class="fa-solid fa-ticket"></i>&nbsp;&nbsp;Support
                    ticket</a>
                <a class="nav-item nav-link {{ Request::is('change-password')?'active':'' }}" href="{{route('change_password')}}" role="tab"
                    aria-selected="false" tabindex="-1"><i class="fa-solid fa-lock"></i>&nbsp;&nbsp;Change
                    password</a>
                <a class="nav-item nav-link" href="#"
                    aria-selected="false" tabindex="-1" role="tab"><i
                        class="fal fa-sign-out"></i>&nbsp;&nbsp;Logout</a>
            </div>
        </nav>
    </aside>
</div>