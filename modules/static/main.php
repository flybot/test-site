<?php
$main_context['content'] = $page['page_text'];
$main_context['description'] = $page['page_description'];
$main_context['keywords'] = $page['page_keywords'];
$main_context['page_name'] = $page['page_name'];

$main_context['xpath'][] = array('name'=>$page['page_name'], 'link'=>'/'.$page['page_link']);


/* SOCIAL */
/*
require_once $_SERVER['DOCUMENT_ROOT'].'/common/h2o/h2o.php';

$context = array();
$context['thisurl'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$context['vk_app_id'] = $VK_APP_ID;
$context['fb_app_id'] = $FB_APP_ID;

$h2o = new H2O($_SERVER['DOCUMENT_ROOT']."/modules/static/social.html");

if ($page_content_static['show_changes']){
	$changes_date = date("d.m.Yг.", strtotime($page_content_static['changes']));
	$changes_time = date("H:i", strtotime($page_content_static['changes']));
	$page_content['page_text'] .= '<div class="static_page_changes">Дата внесения изменений '.$changes_date.'&nbsp;&nbsp;'.$changes_time.'</div>';
}

$page_content['page_text'] .= $h2o->render($context);

$page_content['html_extend']  = !empty($page_content['html_extend']) ? $page_content['html_extend'] : '';
$page_content['html_extend'] .=' xmlns:fb="http://ogp.me/ns/fb#" ';

$page_content['page_head']  = !empty($page_content['page_head']) ? $page_content['page_head'] : '';
$page_content['page_head'] .= '<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?48"></script>';
$page_content['page_head'] .= '<script type="text/javascript"> VK.init({apiId: '.$VK_APP_ID.', onlyWidgets: true}); </script>';

$page_content['page_head'] .= '<link href="http://stg.odnoklassniki.ru/share/odkl_share.css" rel="stylesheet">
                               <script src="http://stg.odnoklassniki.ru/share/odkl_share.js" type="text/javascript" ></script>';

$page_content['body_extend']  = !empty($page_content['body_extend']) ? $page_content['body_extend'] : '';
$page_content['body_extend'] .=' onload="ODKL.init();" ';
*/
/* END SOCIAL */