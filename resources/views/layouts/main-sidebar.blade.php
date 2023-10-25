<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Home-->
                    <li>
                        <a href="{{ route('home') }}"><i class="ti-home"></i><span class="right-nav-text">الرئيسيه
                            </span></a>
                    </li>
                    <!-- menu item Cities-->
                    <li>
                        <a href="{{ route('cities.index') }}"><i class="fa-solid fa-city"></i><span class="right-nav-text"> قائمة المدن
                            </span> </a>
                    </li>
                    <!-- menu item Regoins-->
                    <li>
                        <a href="{{ route('regoins.index') }}"><i class="ti-location-pin"></i><span class="right-nav-text">قائمة الاحياء
                            </span> </a>
                    </li>
                    <!-- menu item Categories-->
                    <li>
                        <a href="{{ route('categories.index') }}"><i class="fa-regular fa-rectangle-list"></i><span class="right-nav-text">
                                قائمة الاقسام
                            </span> </a>
                    </li>
                    <!-- menu item Restaurants -->
                    <li>
                        <i class=""></i>
                        <a href="{{ route('restaurants.index') }}"><i class="fa-solid fa-dungeon"></i><span class="right-nav-text"> قائمة المطاعم
                            </span> </a>
                    </li>
                    <!-- Payment item -->
                    <li>
                        <a href="{{ route('payment_types.index') }}"><i class="fa-solid fa-money-check"></i><span class="right-nav-text"> قائمة طرق الدفع
                            </span> </a>
                    </li>
                    <!-- menu item Offers-->
                    <li>
                        <a href="{{ route('offers.index') }}"><i class="fa-solid fa-truck-monster"></i><span class="right-nav-text">
                                قائمة العروض</span></a>
                    </li>
                    <!-- menu item Contacts-->
                    <li>
                        <a href="{{ route('contacts.index') }}"><i class="fas fa-comments"></i><span class="right-nav-text"> قائمة الرسائل</span></a>
                    </li>
                    <!-- menu item Settings-->
                    <li>
                        <a href="{{ route('settings.index') }}"><i class="fas fa-cogs"></i><span class="right-nav-text">الاعدادات</span></a>
                    </li>
                    <!-- menu item Clients-->
                    <li>
                        <a href="{{ route('clients.index') }}"><i class="fas fa-users"></i><span class="right-nav-text">
                                قائمة العملاء</span></a>
                    </li>
                    <!-- menu item Orders-->
                    <li>
                        <a href="{{ route('orders.index') }}"><i class="fa-solid fa-basket-shopping"></i><span class="right-nav-text"> قائمة الطلبات</span></a>
                    </li>
                    <!-- menu item Users-->
                    <li>
                        <a href="{{ route('users.index') }}"><i class="fas fa-user"></i><span class="right-nav-text">
                                قائمة المستخدمين</span></a>
                    </li>
                    <!-- menu item Roles-->
                    <li>
                        <a href="{{ route('roles.index') }}"><i class="fas fa-tasks"></i><span class="right-nav-text">
                                قائمة الرتب</span></a>
                    </li>
                    {{--
                    <!-- menu item Settings-->
                    <li>
                        <a href="{{ route('settings.index') }}"><i class="fas fa-cogs"></i><span class="right-nav-text">الاعدادات</span></a>
                    </li>
                    <!-- menu item Settings-->
                    <li>
                        <a href="{{ route('password.index') }}"><i class="fas fa-key"></i><span class="right-nav-text">تغير الباسورد</span></a>
                    </li>
                    --}}
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
