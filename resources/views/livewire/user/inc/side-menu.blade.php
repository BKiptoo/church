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
                    <i class="menu-icon tf-icons bx bxs-user-account"></i>
                    <div data-i18n="Account Settings">User Management</div>
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
                    <i class="menu-icon tf-icons bx bx-store-alt"></i>
                    <div data-i18n="Account Settings">Ads Management</div>
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
                    <i class="menu-icon tf-icons bx bx-hive"></i>
                    <div data-i18n="Account Settings">Career Management</div>
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
                    <i class="menu-icon tf-icons bx bx-book-content"></i>
                    <div data-i18n="Account Settings">Contacts Management</div>
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
                    <i class="menu-icon tf-icons bx bx-link-alt"></i>
                    <div data-i18n="Account Settings">Subscribers Management</div>
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
                    <i class="menu-icon tf-icons bx bx-map-alt"></i>
                    <div data-i18n="Account Settings">Coverages Management</div>
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
                    <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                    <div data-i18n="Account Settings">Events Management</div>
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
                    <i class="menu-icon tf-icons bx bx-question-mark"></i>
                    <div data-i18n="Account Settings">Faq's Management</div>
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
                    <i class="menu-icon tf-icons bx bx-buildings"></i>
                    <div data-i18n="Account Settings">Office Management</div>
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
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Account Settings">Category Management</div>
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
                    <i class="menu-icon tf-icons bx bxs-category-alt"></i>
                    <div data-i18n="Account Settings">Sub-Category Management</div>
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
                    <i class="menu-icon tf-icons bx bxl-product-hunt"></i>
                    <div data-i18n="Account Settings">Products Management</div>
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
                    <i class="menu-icon tf-icons bx bx-cart-alt"></i>
                    <div data-i18n="Account Settings">Orders Management</div>
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
                    <i class="menu-icon tf-icons bx bxl-blogger"></i>
                    <div data-i18n="Account Settings">Blogs Management</div>
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
                    <i class="menu-icon tf-icons bx bx-slider-alt"></i>
                    <div data-i18n="Account Settings">Slider Management</div>
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
                    <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                    <div data-i18n="Account Settings">Team Management</div>
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
                    <i class="menu-icon tf-icons bx bxs-file-pdf"></i>
                    <div data-i18n="Account Settings">Tender Management</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Account">List</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Media -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Media</span></li>
            <!-- Cards -->
            <li class="menu-item">
                <a href="" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-images"></i>
                    <div data-i18n="Basic">Media</div>
                </a>
            </li>

            <!-- Support -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text"></span>Quick Links</li>
            <li class="menu-item">
                <a href="#" target="_blank"
                   class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Support">Support</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-log-out"></i>
                    Logout
                </a>
            </li>
        </ul>

    </aside>
</div>
