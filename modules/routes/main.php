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

	$where_filter_str = ""; // строка фильтра БД
	$page_title_str = "";   // формируем заголовок страницы
	
	//формируем список регионов
	$regions =  $mngrDB->mysqlGet("SELECT * FROM regions");
	foreach($regions as $key => $region) {
		$regions[$key]['selected'] = ( in_array($region['alias'], $filter) )? "checked" : "";
		if( in_array($region['alias'], $filter) )
		{
			if($where_filter_str != "") $where_filter_str .= " or ";
			$where_filter_str .= "r.region_id = " . $region['id'];
			
			if($page_title_str != "") $page_title_str .= ", ";
			$page_title_str .= $region['name'];
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

	$months = array();
	for($i=1;$i<=12;$i++){
		$months[$i] = (in_array('m'.$i, $filter))? 'checked' : '';
	}
	$context['months'] = $months;

	$rows = $mngrDB->mysqlGet ("SELECT h.id as hike_id, h.date_start, h.date_finish, r.*, t.name as trainer
								FROM hikes h, routes r, trainers t
								WHERE h.route_id = r.id AND h.trainer_id = t.id AND h.date_start > NOW()
								{$where_filter_str}{$where_filter_str2} ORDER BY {$order}" );
	
	foreach($rows as $key => $row){
		$rows[$key]['complexity_txt'] = $complexity[$row['complexity']]['name'];
		$date_start = new DateTime($row['date_start']);
		$date_finish = new DateTime($row['date_finish']);
		$rows[$key]['duration'] = $date_start->diff($date_finish)->days;
		$rows[$key]['period'][] = $date_start->format('d.m') . '-' . $date_finish->format('d.m');
		
		if($months[$date_start->format('n')] !== 'checked' && in_array('checked', $months)) {
			unset($rows[$key]);
		}
		else {
			$periods = $mngrDB->mysqlGet("SELECT date_start, date_finish FROM hikes WHERE route_id = ".$row['id']." ORDER BY date_start LIMIT 5");
			foreach($periods as $period) {
				$ds = new DateTime($period['date_start']);
				$df = new DateTime($period['date_finish']);
				$rows[$key]['period'][] = $ds->format('d.m') . '-' . $df->format('d.m');
			}
		}
		
		
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
	//заголовок страницы
	if($page_title_str != "") {
		$main_context['page_name'] = "Походы по регионам: " . $page_title_str;
	}
	else { // нет фильтра
		$main_context['page_name'] = "Список походов";
	}
	//на этой странице сайдбар не нужен, отключаем
	$main_context['sidebar'] = null;
	//на странице используем джава-скрипт
	$main_context['page_footer'][] = '<script type="text/javascript" src="/templates/js/routes.js"></script>';
	
	$main_context['xpath'][] = array('name'=>'Список походов', 'link'=>'/routes');
	return;
}


$child = trim ( $_GET ['child'] );

//по числовому номеру выводим карточку похода
if (( int ) $child == $child) 
{
	$row = $mngrDB->mysqlGetOne("SELECT h.id as hike_id, h.date_start, h.date_finish, h.trainer_id, r.*, t.name as trainer
		FROM hikes h, routes r, trainers t
		WHERE h.route_id = r.id AND h.trainer_id = t.id AND h.id = {$child}" );

	if (count ( $row )) 
	{
		//connect comments module
		$comments = new Comments("hike_".$row['id'], "Поход - ".$row['name']);
		$row['comments'] = $comments->getFullPage();
		
		$row['complexity_txt'] = $complexity[$row['complexity']]['name'];
		$date_start = new DateTime($row['date_start']);
		$date_finish = new DateTime($row['date_finish']);
		$row['period'] = $date_start->diff($date_finish)->days;
	
		$context['row'] = $row;
		$h2o = new H2O ( dirname ( __FILE__ ) . "/card.html" );
		$main_context ['content'] = $h2o->render ( $context );
		$main_context['page_name'] = "Поход " . trim($row['name']);
		$main_context['xpath'][] = array('name'=>'Список походов',  'link'=>'/routes');
		$main_context['xpath'][] = array('name'=>'Карточка похода', 'link'=>'/routes/'.$child);
	
		$main_context['page_head'][] = '<link rel="stylesheet" type="text/css" href="/templates/css/lightbox.css">';
		$main_context['page_footer'][] = '<script type="text/javascript" src="/templates/js/lightbox-2.6.min.js"></script>';
		
		return;
	}
}

// неправильный параметр
error404 (); 
