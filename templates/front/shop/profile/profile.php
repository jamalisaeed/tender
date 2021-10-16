<?php
use Tender_Shop_Dir\Includes\Functions\Utility;

if (!is_user_logged_in())
{
    wp_redirect( home_url('login') );
    exit;
}

$current_user=wp_get_current_user();
$current_user_type=get_user_meta($current_user->ID,'tnd_user_type',true);
$current_user_status=get_user_meta($current_user->ID,'user_status',true);
$dash_assets_url=trailingslashit( Tender_Shop_URL ) . 'assets/dashboard/';
if ($current_user_type == 'shop' and ($current_user_status=='enable' or $current_user_status=='pending' or $current_user_status=='verified'))
{

    Utility::load_template( 'shop.profile.header',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop.profile/top-bar',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop.profile/sidebar',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop.profile/content',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop.profile/buttom-bar',  compact( 'dash_assets_url' ), 'front' );
    Utility::load_template( 'shop.profile/footer',  compact( 'dash_assets_url' ), 'front' );
}
else
{
    wp_redirect(home_url('login'));
    exit;
}
?>


