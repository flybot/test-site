<?php

//create main context array
$main_context = array();
$main_context['global_server'] = $_SERVER;
$main_context['base_path'] = dirname(__FILE__);
$main_context['base_url'] = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


//Тут определим значения по умолчанию 
$main_context['description'] = "клуб туристов Кулуар";
$main_context['keywords'] = "кулуар, туризм, активный отдых";


require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';               //Здесь хранятся основные настройки сайта (подключение к БД)
require_once $_SERVER['DOCUMENT_ROOT'].'/common/mngrdb.php';        //Здесь находится класс для работы с БД ($mngrDB).
require_once $_SERVER['DOCUMENT_ROOT'].'/common/h2o/h2o.php';       //Шаблонная система (используется повсюду)

require_once $_SERVER['DOCUMENT_ROOT'].'/common/functions.php';

if( ! empty($_GET['type']) ) {
	$required = mysql_real_escape_string($_GET['type']);
	// search module first
	$_module = $mngrDB->mysqlGetOne("SELECT * FROM modules WHERE `active` = 1 AND dir = '{$required}'");
	if(  count($_module) > 0 ) {
		$module = $_module['dir']; 
	}
	// search static page by name
	else {
		$page = $mngrDB->mysqlGetOne("SELECT * FROM pages WHERE page_link = '{$required}'");
		if( count($page) ) {
			$module = 'static'; // and $_page is a complete record here, no need to load it again 
		}
		// no module and no page exist => show 404 error
		else {
			$module = null;
			error404();
		}
	}
}
else {
	// show main page
	$module = 'main-page';
}

menu_load();
menu_autoselect();

$main_context['xpath'] = array(array('name'=>'Главная', 'link'=>'/')); //хлебные крошки

/*** Side bar ***/
$sidebar = new H2O(dirname(__FILE__)."/templates/sidebar.html");
$main_context['sidebar'] = $sidebar->render(sidebar_data());

if($module) {
	require_once $_SERVER['DOCUMENT_ROOT']."/modules/{$module}/main.php";
}

$h2o = new H2o($_SERVER['DOCUMENT_ROOT'].'/templates/base.html');
echo $h2o->render($main_context);
