<?php
$context = array ();

$complexity = array(
		0 => array("name" => "низкая", "alias" => "low"),
		1 => array("name" => "средняя", "alias" => "medium"),
		2 => array("name" => "высокая", "alias" => "high"), 
		3 => array("name" => "очень высокая", "alias" => "extremely"), 
);



if ( empty($_GET['child']) || ($_GET['child'] == 'filter')  || ($_GET['child'] == 'sort') ) 
{
	//фильтруем список походов
	$filter = array();
	if( (isset($_GET['child']) && isset($_GET['param1'])) && $_GET['child'] == 'filter') { 
		$filter = explode("-",$_GET['param1']); 
	}
	elseif( (isset($_GET['param2']) && isset($_GET['param3']) )  && $_GET['param2'] == 'filter') { 
		$filter = explode("-",$_GET['param3']); 
	}
	
	//По умолчанию походы отсортированы по дате старта
	$order = 'date_start asc';
	if(isset($_GET['child']) && $_GET['child'] == 'sort') { 
		$order = str_replace('-', ' ', $_GET['param1']); 
	}
	elseif(isset($_GET['param2']) && $_GET['param2'] == 'sort') { 
		$order = str_replace('-', ' ', $_GET['param3']); 
	}

	$where_filter_str = "";
	//формируем список регионов
	$regions =  $mngrDB->mysqlGet("SELECT * FROM regions");
	foreach($regions as $key => $region) {
		$regions[$key]['selected'] = ( in_array($region['alias'], $filter) )? "checked" : "";
		if( in_array($region['alias'], $filter) ){
			if($where_filter_str != "") $where_filter_str .= " or ";
			$where_filter_str .= "r.region_id = " . $region['id'];
		}
	}
	if($where_filter_str != "") $where_filter_str = " and " . $where_filter_str;
	$context['regions'] = $regions;

	
	$where_filter_str2 = "";
	//create complexity list for rendering into view
	foreach($complexity as $key => $value) {
		$complexity[$key]['selected'] = ( in_array($value['alias'], $filter) )? "checked" : "";
		if( in_array($value['alias'], $filter) ) {
			if($where_filter_str2 != "") $where_filter_str2 .= " or ";
			$where_filter_str2 .= "r.complexity = " . $key;
		}
	}
	if($where_filter_str2 != "") $where_filter_str2 = " and " . $where_filter_str2;
	$context['complexity_list'] = $complexity;


	$rows = $mngrDB->mysqlGet ("SELECT h.id as hike_id, h.date_start, h.date_finish, r.*, t.name as trainer
								FROM hikes h, routes r, trainers t
								WHERE h.route_id = r.id AND h.trainer_id = t.id AND h.date_start > NOW()
								{$where_filter_str}{$where_filter_str2} ORDER BY {$order}" );
	
	foreach($rows as $key => $row){
		$rows[$key]['complexity_txt'] = $complexity[$row['complexity']]['name'];
		$date_start = new DateTime($row['date_start']);
		$date_finish = new DateTime($row['date_finish']);
		$rows[$key]['period'] = $date_start->diff($date_finish)->days;
	}
	$context['rows'] = $rows;
	
	//$context['filter'] = $filter;
	$pos = strpos($order, 'desc');
	if ($pos === false) {
		$context['sort_order'] = 'up';
		$context['sort_name'] = trim(str_replace('asc', '', $order));
	}
	else {
		$context['sort_order'] = 'down';
		$context['sort_name'] = trim(str_replace('desc', '', $order));
	}
	
	$h2o = new H2O ( dirname ( __FILE__ ) . "/list.html" );
	$main_context['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "Список походов";
	//на этой странице сайдбар не нужен, отключаем
	$main_context['sidebar'] = null;
	//на странице используем джава-скрипт
	$main_context['page_footer'][] = '<script type="text/javascript" src="/templates/js/routes.js"></script>';
	return;
}


$child = trim ( $_GET ['child'] );

//по числовому номеру выводим карточку похода
if (( int ) $child == $child) 
{
	$rows = $mngrDB->mysqlGet ("SELECT h.id as hike_id, h.date_start, h.date_finish, r.*, t.name as trainer
		FROM hikes h, routes r, trainers t
		WHERE h.route_id = r.id AND h.trainer_id = t.id AND h.id = {$child}" );

	if (count ( $rows )) 
	{
		$row = $rows[0];
		$context = array ();
	
		$row['complexity_txt'] = $complexity[$row['complexity']];
		$date_start = new DateTime($row['date_start']);
		$date_finish = new DateTime($row['date_finish']);
		$row['period'] = $date_start->diff($date_finish)->days;
	
		$context['row'] = $row;
		$h2o = new H2O ( dirname ( __FILE__ ) . "/card.html" );
		$main_context ['content'] = $h2o->render ( $context );
		$main_context['page_name'] = "Поход " . trim($row['name']);
	
		return;
	}
}

// неправильный параметр
error404 (); 
