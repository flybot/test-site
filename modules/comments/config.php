<?php

/*
 * for Twitter set "callback url" to http://mysite.com/modules/comments/hybridauth/Hybrid/?hauth.done=Twitter
 * and change permission to "Read and Write"
 *
 * for Google go to https://code.google.com/apis/console/
 * After project create go to "API Access"
 * Create OAuth Client
 * In "Redirects URL's put http://mysite.com/modules/comments/hybridauth/?hauth.done=Google
 */

$_csocial  = array(
    'vk'=>array('id'=>'3111728', 'secret'=>'8CC4wu4HB2q1aF912R1S'),
    'fb'=>array('id'=>'151931724945416', 'secret'=>'916d9a1ffc66684904e849d8f19a037a'),
    'tw'=>array('id'=>'n4aqivofkDi1HXnFbG2Dhg', 'secret'=>'kCK0tYoyFwyQHL7UHzmPtx43McskvO5Xgq8RQ9DiE'),
    'gp'=>array('id'=>'399824776060.apps.googleusercontent.com', 'secret'=>'IsAnJ8nvFbXQ874z_rjI_wy7'),
    );

$HYBRIDAUTH_CONFIG =  array(
    "base_url" => "http://{$_SERVER['HTTP_HOST']}/modules/comments/hybridauth/",
    "providers" => array (
        "Google"   => array ( "enabled" => true,
                              "keys"    => array ( "id"  => $_csocial['gp']['id'], "secret" => $_csocial['gp']['secret'] ),
                              "scope"   => "https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile",
                              "icon"    => '/modules/comments/images/gp.png',
                              "button"  => '/modules/comments/images/gm_big.png', ),
        "Facebook" => array ( "enabled" => true,  
                              "keys"    => array ( "id"  => $_csocial['fb']['id'], "secret" => $_csocial['fb']['secret'] ),
                              "scope"   => "user_about_me, offline_access",//*/
                              "icon"    => '/modules/comments/images/fb.png',
                              "button"  => '/modules/comments/images/fb_big.png',),
        "Twitter"  => array ( "enabled" => false,
                              "keys"    => array ( "key" => $_csocial['tw']['id'], "secret" => $_csocial['tw']['secret'] ),
                              "icon"    => '/modules/comments/images/tw.png',
                              "button"  => '/modules/comments/images/tw_big.png', ),
        "Vkontakte"=> array ( "enabled" => true,  
                              "keys"    => array ( "id"  => $_csocial['vk']['id'], "secret" => $_csocial['vk']['secret']),
                              "scope"   => "offline",
                              "icon"    => '/modules/comments/images/vk.png',
                              "button"  => '/modules/comments/images/vk_big.png', ),
        ),
    "debug_mode" => false,
    "debug_file" => ""
);