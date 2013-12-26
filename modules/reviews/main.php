<?php

$context = array ();

// список отзывов с возможной фильтрацией по регионам
if ( empty($_GET['child']) || ($_GET['child'] == 'filter') ) 
{
	//фильтруем список отзывов
	$filter = array();
	if( (isset($_GET['child']) && isset($_GET['param1'])) && $_GET['child'] == 'filter') {
		$filter = explode("-",$_GET['param1']);
	}
	
	$where_filter_str = "";
	//формируем список регионов
	$regions =  $mngrDB->mysqlGet("SELECT * FROM regions");
	foreach($regions as $key => $region) {
		$regions[$key]['selected'] = ( in_array($region['alias'], $filter) )? "checked" : "";
		if( in_array($region['alias'], $filter) ){
			if($where_filter_str != "") $where_filter_str .= " or ";
			$where_filter_str .= "rt.region_id = " . $region['id'];
		}
	}
	if($where_filter_str != "") $where_filter_str = " and " . $where_filter_str;
	$context['regions'] = $regions;
	
	$rows = $mngrDB->mysqlGet ("SELECT rv.*, rt.region_id, rt.name as route_name FROM reviews rv, routes rt 
								WHERE rv.route_id = rt.id {$where_filter_str} 
								ORDER BY priority, id desc" );
	$context['rows'] = $rows;
	
	
	
	$h2o = new H2O ( dirname ( __FILE__ ) . "/list.html" );
	$main_context['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "Список отзывов";
	$main_context['xpath'][] = array('name'=>'Отзывы', 'link'=>'/reviews');
	
	//на странице используем джава-скрипт
	$main_context['page_footer'][] = '<script type="text/javascript" src="/templates/js/reviews.js"></script>';
	return;
}

$child = $_GET['child'];
// ишем отзыв по названию и отдаем страницу
$row = $mngrDB->mysqlGetOne("SELECT rv.*, rt.region_id, rt.name as route_name FROM reviews rv, routes rt 
							WHERE rv.route_id = rt.id AND rv.id = {$child}" );
	

if (count ( $row ))
{
	$context['row'] = $row;
	
	$h2o = new H2O ( dirname ( __FILE__ ) . "/card.html" );
	
	$main_context ['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "Отзыв: " . trim($row['name']);
	$main_context['xpath'][] = array('name'=>'Отзывы', 'link'=>'/reviews');
	$main_context['xpath'][] = array('name'=>$row['name'], 'link'=>'/reviews/'.$child);
	
	return;
}

// нету запрошенного названия отзыва, пользователь ошибся, страница удалена и т.п.
// отдаем страницу 404
error404 (); // неправильный параметр