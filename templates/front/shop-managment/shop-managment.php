<?php
use Tender_Shop_Dir\Includes\Functions\Utility;
$cu_id=get_current_user_id();
$dash_assets_url=trailingslashit( Tender_Shop_URL ) . 'assets/dashboard/';
if (is_user_logged_in() and current_user_can('administrator'))
{
    Utility::load_template( 'shop-managment.header',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop-managment/top-bar',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop-managment/sidebar',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop-managment/content',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop-managment/buttom-bar',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop-managment/footer',  compact( 'dash_assets_url' ), 'front' );
}
else
{
    wp_redirect(home_url('login'));
    exit;
}
?>


