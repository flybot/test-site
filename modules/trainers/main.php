<?php

// Список инcтрукторов
if (empty ( $_GET ['child'] )) {
	$rows = $mngrDB->mysqlGet ( "SELECT * FROM trainers ORDER BY priority" );
	foreach($rows as $key => $row) {
		//возраст
		$rows[$key]['birthday'] = floor((time()-strtotime($row['birthday']))/(60*60*24*365.25));
		//стаж инструктора
		$rows[$key]['experience'] = floor((time()-strtotime($row['experience']))/(60*60*24*365.25));
	}
	
	$context = array ();
	$context ['rows'] = $rows;
	
	$h2o = new H2O ( dirname ( __FILE__ ) . "/list.html" );
	$main_context ['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "Список инструкторов";
	$main_context['xpath'][] = array('name'=>'Список инструкторов', 'link'=>'/trainers');
	
	return;
}

// Карточка инструктора
if (( int ) trim ( $_GET ['child'] ) != trim ( $_GET ['child'] )) {
	error404 (); // неправильный параметр
	return;
}

$trainer = (int) trim($_GET['child']);

$row = $mngrDB->mysqlGetOne ( "SELECT * FROM trainers WHERE id = " . $trainer );
if (count ( $row )) {
	$context = array ();
	$row['birthday'] = floor((time()-strtotime($row['birthday']))/(60*60*24*365.25));
	$row['experience'] = floor((time()-strtotime($row['experience']))/(60*60*24*365.25));
	
	//connect comments module
	$comments = new Comments("trainer_".$row['id'], "Инструктор - ".$row['name']);
	$row['comments'] = $comments->getFullPage();

	//выбираем походы этого инструктора
	$hikes = $mngrDB->mysqlGet("SELECT h.id as hike_id, h.date_start, h.date_finish, r.*
								FROM hikes h, routes r
								WHERE h.route_id = r.id AND h.trainer_id = {$trainer} AND h.date_start > NOW()
								ORDER BY r.name");
	foreach($hikes as $key => $hike){
		$date_start = new DateTime($row['date_start']);
		$date_finish = new DateTime($row['date_finish']);
		$hikes[$key]['period'] = $date_start->format('d.m') . '-' . $date_finish->format('d.m');
	}
	$row['hikes'] = $hikes;
	
	$context['row'] = $row;
	$h2o = new H2O ( dirname ( __FILE__ ) . "/card.html" );
	$main_context ['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "инструктор " . trim($row['name']);	
	$main_context['xpath'][] = array('name'=>'Список инструкторов', 'link'=>'/trainers');
	$main_context['xpath'][] = array('name'=>$row['name'], 'link'=>'/trainers/'.$row['id']);
	
	return;
}

error404 (); // неправильный параметр
