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
                        <a href="" class="menu-link">
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

            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>
            <!-- Cards -->
            <li class="menu-item">
                <a href="cards-basic.html" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="Basic">Cards</div>
                </a>
            </li>
            <!-- User interface -->
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-box"></i>
                    <div data-i18n="User interface">User interface</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="ui-accordion.html" class="menu-link">
                            <div data-i18n="Accordion">Accordion</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-alerts.html" class="menu-link">
                            <div data-i18n="Alerts">Alerts</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-badges.html" class="menu-link">
                            <div data-i18n="Badges">Badges</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-buttons.html" class="menu-link">
                            <div data-i18n="Buttons">Buttons</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-carousel.html" class="menu-link">
                            <div data-i18n="Carousel">Carousel</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-collapse.html" class="menu-link">
                            <div data-i18n="Collapse">Collapse</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-dropdowns.html" class="menu-link">
                            <div data-i18n="Dropdowns">Dropdowns</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-footer.html" class="menu-link">
                            <div data-i18n="Footer">Footer</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-list-groups.html" class="menu-link">
                            <div data-i18n="List Groups">List groups</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-modals.html" class="menu-link">
                            <div data-i18n="Modals">Modals</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-navbar.html" class="menu-link">
                            <div data-i18n="Navbar">Navbar</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-offcanvas.html" class="menu-link">
                            <div data-i18n="Offcanvas">Offcanvas</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-pagination-breadcrumbs.html" class="menu-link">
                            <div data-i18n="Pagination &amp; Breadcrumbs">Pagination &amp; Breadcrumbs</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-progress.html" class="menu-link">
                            <div data-i18n="Progress">Progress</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-spinners.html" class="menu-link">
                            <div data-i18n="Spinners">Spinners</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-tabs-pills.html" class="menu-link">
                            <div data-i18n="Tabs &amp; Pills">Tabs &amp; Pills</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-toasts.html" class="menu-link">
                            <div data-i18n="Toasts">Toasts</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-tooltips-popovers.html" class="menu-link">
                            <div data-i18n="Tooltips & Popovers">Tooltips &amp; popovers</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="ui-typography.html" class="menu-link">
                            <div data-i18n="Typography">Typography</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Extended components -->
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-copy"></i>
                    <div data-i18n="Extended UI">Extended UI</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                            <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="extended-ui-text-divider.html" class="menu-link">
                            <div data-i18n="Text Divider">Text Divider</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="icons-boxicons.html" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-crown"></i>
                    <div data-i18n="Boxicons">Boxicons</div>
                </a>
            </li>

            <!-- Forms & Tables -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Forms &amp; Tables</span>
            </li>
            <!-- Forms -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="Form Elements">Form Elements</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="forms-basic-inputs.html" class="menu-link">
                            <div data-i18n="Basic Inputs">Basic Inputs</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="forms-input-groups.html" class="menu-link">
                            <div data-i18n="Input groups">Input groups</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="Form Layouts">Form Layouts</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="form-layouts-vertical.html" class="menu-link">
                            <div data-i18n="Vertical Form">Vertical Form</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="form-layouts-horizontal.html" class="menu-link">
                            <div data-i18n="Horizontal Form">Horizontal Form</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Tables -->
            <li class="menu-item">
                <a href="tables-basic.html" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div data-i18n="Tables">Tables</div>
                </a>
            </li>
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
                <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank"
                   class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Support">Support</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                   target="_blank" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Documentation">Documentation</div>
                </a>
            </li>
        </ul>

    </aside>
</div>
