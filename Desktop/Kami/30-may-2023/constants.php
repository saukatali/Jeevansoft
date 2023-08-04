<?php

$WEBSITE_URL				= env("APP_URL");
$WEBSITE                    = $WEBSITE_URL.'public/';

$PATH                       = base_path();
$WEBSITE_PATH                = $WEBSITE.'adminpnlx/';


return [
'ALLOWED_TAGS_XSS' => '<iframe><a><strong><b><p><br><i><font><img><h1><h2><h3><h4><h5><h6><span>
<div><em><table><ul><li><section><thead><tbody><tr><td><figure><article>',


'DS'                          => '/',
'URL'                         => base_path(),
'PATH'                        => app_path(),
'LANGUAGE_PATH'               => $PATH.'/resources',


"WEBSITE_IMG_URL"             => $WEBSITE_PATH.'img/',
"WEBSITE_CSS_URL"             => $WEBSITE_PATH.'css/',
"WEBSITE_JS_URL"              => $WEBSITE_PATH.'js/',


"ABOUT_US_IMAGE_ROOT_URL"          =>  $WEBSITE_URL.'public/uploads/About_image/',
"ABOUT_US_IMAGE_ROOT_PATH"         => "public/uploads/About_image/",

"TESTIMONAIL_IMAGE_ROOT_URL"       =>  $WEBSITE_URL.'public/uploads/Testimonial_image/',
"TESTIMONAIL_IMAGE_ROOT_PATH"      => "public/uploads/Testimonial_image/",

"BANNER_IMAGE_ROOT_URL"          =>  $WEBSITE_URL.'public/uploads/banner/',
"BANNER_IMAGE_ROOT_PATH"         => "public/uploads/banner/",

"CATEGORY_IMAGE_ROOT_URL"          =>  $WEBSITE_URL.'public/uploads/category/',
"CATEGORY_IMAGE_ROOT_PATH"         => "public/uploads/category/",

"SUB_CATEGORY_IMAGE_ROOT_URL"          =>  $WEBSITE_URL.'public/uploads/sub_category/',
"SUB_CATEGORY_IMAGE_ROOT_PATH"         => "public/uploads/sub_category/",


"CLIENT_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/Client_image/',
"CLIENT_IMAGE_ROOT_PATH"           => "public/uploads/Client_image/",

"SIZE_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/size/',
"SIZE_IMAGE_ROOT_PATH"           => "public/uploads/size/",

"COLOR_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/colors/',
"COLOR_IMAGE_ROOT_PATH"           => "public/uploads/colors/",

"BRAND_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/brands/',
"BRAND_IMAGE_ROOT_PATH"           => "public/uploads/brands/",

"PROJECT_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/Project_image/',
"PROJECT_IMAGE_ROOT_PATH"           => "public/uploads/Project_image/",

"PORTFOLIO_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/Portfolio_image/',
"PORTFOLIO_IMAGE_ROOT_PATH"           => "public/uploads/Portfolio_image/",

"PRODUCT_IMAGE_ROOT_URL"            =>  $WEBSITE_URL.'public/uploads/product_image/',
"PRODUCT_IMAGE_ROOT_PATH"           => "public/uploads/product_image/",

"BLOG_IMAGE_ROOT_URL"               =>  $WEBSITE_URL.'public/uploads/Blog_image/',
"BLOG_IMAGE_ROOT_PATH"              => "public/uploads/Blog_image/",

"COUPON_IMAGE_ROOT_URL"               =>  $WEBSITE_URL.'public/uploads/Coupon_imge/',
"COUPON_IMAGE_ROOT_PATH"              => "public/uploads/Coupon_imge/",

"SEO_PAGE_IMAGE_ROOT_URL"           =>  $WEBSITE_URL.'public/uploads/seo_page/',
"SEO_PAGE_IMAGE_ROOT_PATH"          => "public/uploads/seo_page/",

"CMS_PAGE_IMAGE_ROOT_URL"           =>  $WEBSITE_URL.'public/uploads/cms_page/',
"CMS_PAGE_IMAGE_ROOT_PATH"          => "public/uploads/cms_page/",

"USER_IMAGE_ROOT_URL"               =>  $WEBSITE_URL.'public/uploads/User_image/',
"USER_IMAGE_ROOT_PATH"              => "public/uploads/User_image/",

"STAFF_IMAGE_ROOT_URL"              =>  $WEBSITE_URL.'public/uploads/staffs/',
"STAFF_IMAGE_ROOT_PATH"             => "public/uploads/staffs/",

"CONTACT_US_IMAGE_ROOT_URL"         =>  $WEBSITE_URL.'public/uploads/contact_us/',
"CONTACT_US_IMAGE_ROOT_PATH"        => "public/uploads/contact_us/",

"LANGUAGES_IMAGE_ROOT_URL"          =>  $WEBSITE_URL.'public/uploads/Language_image/',
"LANGUAGES_IMAGE_ROOT_PATH"         => "public/uploads/Language_image/",



'ACLS' => [
    'ACLS_TITLE' => 'Acl Management',
    'ACL_TITLE'  => 'Acl',
    ],


'BANNERS' => [
    'BANNERS_TITLE' => 'Banners',
    'BANNER_TITLE'  => 'Banner',
    ],
        
'ORDERS' => [
    'ORDERS_TITLE' => 'Orders',
    'ORDER_TITLE'  => 'Orders',
    ],

'ORDER_CANCELS' => [
        'ORDER_CANCELS_TITLE' => 'Order cancel',
        'ORDER_CANCEL_TITLE'  => 'Order cancel',
        ],

'ORDER_REFUNDS' => [
    'ORDER_REFUNDS_TITLE' => 'Order Refund',
    'ORDER_REFUND_TITLE'  => 'Order Refund',
    ],
    
'ORDER_RETURNS' => [
    'ORDER_RETURNS_TITLE' => 'Order Return',
    'ORDER_RETURN_TITLE'  => 'Order Return',
    ],

'PAYMENTS' => [
    'PAYMENTS_TITLE' => 'Payments',
    'PAYMENT_TITLE'  => 'Payment',
    ],

'PRODUCTS' => [
    'PRODUCTS_TITLE' => 'Products',
    'PRODUCT_TITLE'  => 'Product',
    ],

'CATEGORY' => [
    'CATEGORYS_TITLE' => 'Category',
    'CATEGORY_TITLE'  => 'Category',
    ],

'SUB_CATEGORY' => [
    'SUB_CATEGORYS_TITLE' => 'Sub Category',
    'SUB_CATEGORY_TITLE'  => 'Sub Category',
    ],

'COUPONS' => [
    'COUPONS_TITLE' => 'Coupons',
    'COUPON_TITLE'  => 'Coupon',
    ],


    'NOTIFICATIONS' => [
        'NOTIFICATIONS_TITLE' => 'Notifications',
        'NOTIFICATION_TITLE'  => 'Notification',
        ],
    
'RATINGS' => [
    'RATINGS_TITLE' => 'Ratings',
    'RATING_TITLE'  => 'Rating',
    ],

'REVIEWS' => [
    'REVIEWS_TITLE' => 'Reviews',
    'REVIEW_TITLE'  => 'Review',
    ],

    'REVIEW_RATINGS' => [
        'REVIEW_RATINGS_TITLE' => 'Reviews And Ratings',
        'REVIEW_RATING_TITLE'  => 'Review And Rating',
        ],

'CMS_PAGES' => [
    'CMS_PAGES_TITLE' => 'CMS Pages',
    'CMS_PAGE_TITLE'  => 'CMS Page',
    ],

'EMAIL_TEMPLATES' => [
    'EMAIL_TEMPLATES_TITLE' => 'Email Templates',
    'EMAIL_TEMPLATE_TITLE'  => 'Email Templates',
    ],


'EMAIL_LOGS' => [
    'EMAIL_LOGS_TITLE' => 'Email Logs',
    'EMAIL_LOG_TITLE'  => 'Email Log',
    ],

'SEO_PAGES' => [
    'SEO_PAGES_TITLE' => 'Seo Pages',
    'SEO_PAGE_TITLE'  => 'Seo Page',
    ],


'DEPARTMENTS' => [
    'DEPARTMENTS_TITLE' => 'Departments',
    'DEPARTMENT_TITLE'  => 'Department',
    ],

'DESIGNATIONS' => [
    'DESIGNATIONS_TITLE' => 'Designations',
    'DESIGNATION_TITLE'  => 'Designation',
    ],

'VIRIENTS' => [
    'VIRIENTS_TITLE' => 'Virients',
    'VIRIENT_TITLE'  => 'Virient',
    ],

'SIZES' => [
    'SIZES_TITLE' => 'Sizes',
    'SIZE_TITLE'  => 'Size',
    ],


'COLORS' => [
    'COLORS_TITLE' => 'Colors',
    'COLOR_TITLE'  => 'Color',
    ],


'BRANDS' => [
    'BRANDS_TITLE' => 'Brands',
    'BRAND_TITLE'  => 'Brand',
    ], 
    
'BLOGS' => [
    'BLOGS_TITLE' => 'Blogs',
    'BLOG_TITLE'  => 'Blog',
    ], 

'READING_SETTINGS' => [
    'READING_SETTINGS_TITLE' => 'Reading Settings',
    'READING_SETTING_TITLE'  => 'Reading Setting',
    ],
    
'SOCIAL_SETTINGS' => [
    'SOCIAL_SETTINGS_TITLE' => 'Social Settings',
    'SOCIAL_SETTING_TITLE'  => 'Social Setting',
    ],

'CONTACT_SETTINGS' => [
    'CONTACT_SETTINGS_TITLE' => 'Contact Settings',
    'CONTACT_SETTING_TITLE'  => 'Contact Setting',
    ], 



'CONTACT_ENQUIRY' => [
    'CONTACT_ENQUIRYS_TITLE' => 'Contact Enquiry',
    'CONTACT_ENQUIRY_TITLE'  => 'Contact Enquiry',
    ],

    
'SETTINGS' => [
    'SETTINGS_TITLE' => 'Settings',
    'SETTING_TITLE'  => 'Setting',
    ], 

'USERS' => [
    'USERS_TITLE' => 'Customers',
    'USER_TITLE'  => 'Customer',
    ],
    
'STAFFS' => [
    'STAFFS_TITLE' => 'Staffs',
    'STAFF_TITLE' => 'Staff',
    ],

'LANGUAGES' => [
    'LANGUAGES_TITLE' => 'Langauge Settings',
    'LANGUAGE_TITLE' => 'Langauge Setting',
    ],
    

'ROLE_ID' => [
    'ADMIN_ID' => 1,
    'ADMIN_ROLE_ID' => 1,
    'CUSTOMER_ROLE_ID' => 2,
    ],


'DEFAULT_LANGUAGE' => [
'FOLDER_CODE' => 'en',
'LANGUAGE_CODE' => 1,
'LANGUAGE_NAME' => 'English'
],


'CURRENCY_SYMBOL_RS' => '&#8360',
'CURRENCY_SYMBOL_RUPEES' => '&#8377;',


'api_keys' => [
    'secret_key' => env('STRIPE_SECRET_KEY', 'pk_test_51M2SZ0SA6GAaBclTeMWbl2lC0zzavTtNSBDkDHAhyi5S8A6Me7CEwynwh53wd0yQovSvF5mURUKZ4zdGlf9GyVkh00rO9tRGgW')
],

'SETTING_FILE_PATH'	=> base_path() . "/" .'config'."/". 'settings.php',

];
