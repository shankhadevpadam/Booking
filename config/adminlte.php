<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Magical Nepal',
    'title_prefix' => '',
    'title_postfix' => '- Magical Nepal',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b class="logo-text-color">Magical</b>Nepal',
    'logo_img' => 'vendor/adminlte/dist/img/logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Magical',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => '',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => false,
    'logout_url' => '/logout',
    'login_url' => '/login',
    'register_url' => false,
    'password_reset_url' => '/forgot-password',
    'password_email_url' => '/forgot-password',
    'profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        [
            'text' => 'Home',
            'key' => 'admin_home',
            'route' => 'admin.home',
            'icon' => 'nav-icon fas fa-house-user',
        ],
        [
            'text' => 'Packages',
            'route' => 'admin.packages.index',
            'icon' => 'nav-icon fas fa-box-open',
            'active' => ['*/packages/create',
                'regex:@^.*/packages/.*/edit$@',
                'regex:@^.*/packages/.*/departures$@',
                'regex:@^.*/packages/.*/departures/create$@',
                'regex:@^.*/packages/.*/addons$@',
                'regex:@^.*/packages/.*/addons/create$@',
                'regex:@^.*/packages/.*/discounts$@',
                'regex:@^.*/packages/.*/discounts/create$@',
                'regex:@^.*/packages/.*/expenses$@',
                'regex:@^.*/packages/.*/expenses/create$@',
            ],
            'can' => 'view_packages',
        ],
        [
            'text' => 'Coupons',
            'route' => 'admin.coupons.index',
            'icon' => 'nav-icon fas fa-tags',
            'active' => ['*/coupons/create', 'regex:@^.*/coupons/.*/edit$@'],
            'can' => 'view_coupons',
        ],
        [
            'text' => 'Accounts',
            'icon' => 'nav-icon fas fa-coins',
            'can' => 'view_incomes',
            'submenu' => [
                [
                    'text' => 'Incomes',
                    'route' => 'admin.incomes.index',
                    'icon' => 'nav-icon fas fa-hand-holding-usd',
                    'can' => 'view_incomes',
                ],
                [
                    'text' => 'Expenses',
                    'route' => 'admin.expenses.index',
                    'icon' => 'nav-icon fas fa-calculator',
                    'can' => 'view_expenses',
                ],
            ],
        ],
        [
            'text' => 'Payments',
            'icon' => 'nav-icon fas fa-money-bill-wave',
            'can' => 'view_banks',
            'submenu' => [
                [
                    'text' => 'Banks',
                    'route' => 'admin.banks.index',
                    'icon' => 'nav-icon fas fa-university',
                    'active' => ['*/banks/create', 'regex:@^.*/banks/.*/edit$@'],
                    'can' => 'view_banks',
                ],
                [
                    'text' => 'Currencies',
                    'route' => 'admin.currencies.index',
                    'icon' => 'nav-icon fas fa-funnel-dollar',
                    'active' => ['*/currencies/create', 'regex:@^.*/currencies/.*/edit$@'],
                    'can' => 'view_currencies',
                ],
            ],
        ],
        [
            'text' => 'Reviews',
            'route' => 'admin.reviews.index',
            'icon' => 'nav-icon fas fa-thumbs-up',
            'active' => ['*/reviews/create', 'regex:@^.*/reviews/.*/edit$@'],
            'can' => 'view_reviews',
        ],
        [
            'text' => 'Transportation',
            'icon' => 'nav-icon fas fa-bus',
            'can' => 'view_locations',
            'submenu' => [
                [
                    'text' => 'Locations',
                    'route' => 'admin.locations.index',
                    'icon' => 'nav-icon fas fa-location-arrow',
                    'active' => ['*/locations/create', 'regex:@^.*/locations/.*/edit$@'],
                    'can' => 'view_locations',
                ],
                [
                    'text' => 'Airlines',
                    'route' => 'admin.airlines.index',
                    'icon' => 'nav-icon fas fa-plane',
                    'active' => ['*/airlines/create', 'regex:@^.*/airlines/.*/edit$@'],
                    'can' => 'view_airlines',
                ],
            ],
        ],
        [
            'text' => 'Settings',
            'route' => 'admin.settings.general',
            'icon' => 'nav-icon fas fa-tools',
            'can' => 'view_settings',
        ],
        [
            'text' => 'Email Settings',
            'icon' => 'nav-icon far fa-envelope',
            'can' => 'view_settings',
            'submenu' => [
                [
                    'text' => 'User Notifications',
                    'route' => 'admin.settings.user.email',
                    'can' => 'view_settings',
                ],
                [
                    'text' => 'Guide Notifications',
                    'route' => 'admin.settings.guide.email',
                    'can' => 'view_settings',
                ],
                [
                    'text' => 'Cron Notifications',
                    'route' => 'admin.settings.cron.email',
                    'can' => 'view_settings',
                ],
                [
                    'text' => 'Admin Notifications',
                    'route' => 'admin.settings.admin.email',
                    'can' => 'view_settings',
                ],
            ],
        ],
        [
            'text' => 'Logs',
            'url' => 'admin/log-viewer',
            'icon' => 'nav-icon fas fa-history',
            'can' => 'view_settings',
        ],
        ['header' => 'account_settings', 'can' => 'view_profile'],
        [
            'text' => 'Users',
            'route' => 'admin.users.index',
            'icon' => 'nav-icon far fa-user',
            'active' => ['*/users/create', 'regex:@^.*/users/.*/edit$@'],
            'can' => 'view_users',
        ],
        [
            'text' => 'Clients',
            'route' => 'admin.clients.index',
            'icon' => 'nav-icon fas fa-user-tie',
            'active' => ['*/clients/create', 'regex:@^.*/clients/.*/edit$@'],
            'can' => 'view_clients',
        ],
        [
            'text' => 'Guides',
            'route' => 'admin.guides.index',
            'icon' => 'nav-icon fab fa-guilded',
            'active' => ['*/guides/create', 'regex:@^.*/guides/.*/edit$@'],
            'can' => 'view_guides',
        ],
        [
            'text' => 'Vendors',
            'route' => 'admin.vendors.index',
            'icon' => 'nav-icon fas fa-users',
            'active' => ['*/vendors/create', 'regex:@^.*/vendors/.*/edit$@'],
            'can' => 'view_vendors',
        ],
        [
            'text' => 'Roles',
            'route' => 'admin.roles.index',
            'icon' => 'nav-icon fas fa-user-tag',
            'active' => ['*/roles/create', 'regex:@^.*/roles/.*/edit$@'],
            'can' => 'view_roles',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/datatables.net@1.11.5/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.11.5/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/datatables.net-responsive@2.2.9/js/dataTables.responsive.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs4@2.2.9/js/responsive.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.11.5/css/dataTables.bootstrap4.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs4@2.2.9/css/responsive.bootstrap4.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5.0.4/bootstrap-4.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js',
                ],
            ],
        ],
        'Moment' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js',
                ],
            ],
        ],
        'DateRangePicker' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/bootstrap-daterangepicker@3.1.0/daterangepicker.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/bootstrap-daterangepicker@3.1.0/daterangepicker.min.js',
                ],
            ],
        ],
        'FlatPickr' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/flatpickr',
                ],
            ],
        ],
        'Rating' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/bootstrap-star-rating@4.0.9/css/star-rating.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.9/themes/krajee-svg/theme.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.7/js/star-rating.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.0.9/themes/krajee-svg/theme.min.js',
                ],
            ],
        ],
        'Filepond' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/filepond@4.28.2/dist/filepond.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/filepond@4.28.2/dist/filepond.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-size@2.2.4/dist/filepond-plugin-file-validate-size.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-type@1.2.6/dist/filepond-plugin-file-validate-type.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/jquery-filepond@1.0.0/filepond.jquery.js',
                ],
            ],
        ],
        'SummerNote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => true,
];
