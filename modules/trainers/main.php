<?php

// Список инcтрукторов
if (empty ( $_GET ['child'] )) {
	$rows = $mngrDB->mysqlGet ( "SELECT * FROM trainers ORDER BY priority" );
	
	$context = array ();
	$context ['rows'] = $rows;
	
	$h2o = new H2O ( dirname ( __FILE__ ) . "/list.html" );
	$main_context ['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "Список инструкторов";
	
	return;
}

// Карточка инструктора
if (( int ) trim ( $_GET ['child'] ) != trim ( $_GET ['child'] )) {
	error404 (); // неправильный параметр
	return;
}

$row = $mngrDB->mysqlGet ( "SELECT * FROM trainers WHERE id = " . (int) trim($_GET['child']) );
if (count ( $row )) {
	$context = array ();
	$context['row'] = $row[0];
	$h2o = new H2O ( dirname ( __FILE__ ) . "/card.html" );
	$main_context ['content'] = $h2o->render ( $context );
	$main_context['page_name'] = "инструктор " . trim($row[0]['name']);
	
	return;
}

error404 (); // неправильный параметр
