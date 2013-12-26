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

$row = $mngrDB->mysqlGetOne ( "SELECT * FROM trainers WHERE id = " . (int) trim($_GET['child']) );
if (count ( $row )) {
	$context = array ();
	$row['birthday'] = floor((time()-strtotime($row['birthday']))/(60*60*24*365.25));
	$row['experience'] = floor((time()-strtotime($row['experience']))/(60*60*24*365.25));
	$context['row'] = $row;
	$h2o = new H2O ( dirname ( __FILE__ ) . "/card.html" );
	$main_context ['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "инструктор " . trim($row[0]['name']);	
	$main_context['xpath'][] = array('name'=>'Список инструкторов', 'link'=>'/trainers');
	$main_context['xpath'][] = array('name'=>$row[0]['name'], 'link'=>'/trainers/'.$row[0]['id']);
	
	return;
}

error404 (); // неправильный параметр
