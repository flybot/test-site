<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'regions';
$current_name  = 'Регионы';

//$admin->filter->def_order = " ORDER BY `priority` ASC";
//$admin->filter_query = "SELECT {$current_table}.* FROM {$current_table} WHERE 1 ";

$admin->DescribeTable(	$name = $current_name,     //Имя. Просто имя.
		$table    = $current_table,//Таблица. Нужна для создания запросов.
		$change   = true,          //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
		$delete   = true,          //Возможность удаления строк
		$add      = true,          //Возможность добавления строк
		$main_fld = 'id',
		$history  = true
);

//$admin->SetUpDown("priority", true);
$admin->history_name = 'name';

$admin->DescribeField("Название",	"name",     "string",    array(0, 255), true );
$admin->DescribeField("Заголовок", 	"title",    "string",    array(0, 255), true );
$admin->DescribeField("Описание",  	"descr",    "text_fck",  array(0, 0),   true );
$admin->DescribeField("алиас",		"alias", 	"string",    array(0, 255), true );

$admin->filter->AddField("ID",            	'id',         1, '', null,   False);
$admin->filter->AddField("Название",	'name',       1, '', null,   False);
//$admin->filter->AddField("Заголовок темы",  'title',      1, '', null,   False);

$admin->DoAction();
?>