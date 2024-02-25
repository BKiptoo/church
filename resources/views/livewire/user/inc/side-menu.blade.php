<div>
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo ">
            <a href="{{ route('home') }}" class="app-brand-link">
              <span class="app-brand-logo demo">
                                <img src="{{ asset('assets/img/logo_horizontal.png') }}" alt="logo" width="200">
                            </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>


        <ul class="menu-inner py-1">

            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Account -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Account Settings">Account Settings</div>
                </a>

                <ul class="menu-sub">

                    <li class="menu-item">
                        <a href="{{ route('profile') }}" class="menu-link">
                            <div data-i18n="Without menu">Profile</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('credentials') }}" class="menu-link">
                            <div data-i18n="Without navbar">Password</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{--System operations--}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Sys Ops</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-shield"></i>
                    <div data-i18n="Account Settings">Admins</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.user') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.users') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                    <div data-i18n="Account Settings">Subscribers</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-calendar-event"></i>
                    <div data-i18n="Account Settings">Events</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.event') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.events') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Account Settings">Category</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.category') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.categories') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-category-alt"></i>
                    <div data-i18n="Account Settings">Sub-Category </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.sub.category') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.sub.categories') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-shopping-bag"></i>
                    <div data-i18n="Account Settings">Shop Products</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.product') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.products') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Account Settings">Shop Orders</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('list.orders') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxl-blogger"></i>
                    <div data-i18n="Account Settings">Blogs</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.post') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.posts') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-slider-alt"></i>
                    <div data-i18n="Account Settings">Slides</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.slide') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.slides') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-question-mark"></i>
                    <div data-i18n="Account Settings">Faq's</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.faq') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.faqs') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Support -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text"></span>Quick Links</li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-map-alt"></i>
                    <div data-i18n="Account Settings">Coverages</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('add.coverage') }}" class="menu-link">
                            <div data-i18n="Account">Add</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('list.coverages') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-message"></i>
                    <div data-i18n="Account Settings">Contacts</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('list.contacts') }}" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="#" target="_blank"
                   class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Support">Support</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link" wire:click="logout">
                    <i class="menu-icon tf-icons bx bxs-log-out"></i>
                    Logout
                </a>
            </li>
        </ul>

    </aside>
</div>
