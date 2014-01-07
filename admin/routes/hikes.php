<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'hikes';
$current_name  = 'Походы';

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

$admin->DescribeField("Маршрут",	"route_id",	"ForeignKey",
		array(
				'other_table'=>'routes',
				'other_id'   =>'id',
				'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",
				'value'      =>"{{id}}",
				'text'       =>"{{name}}",
				//'subtype'    => array('name'=>'xself', 'search_field'=>"name", "value_field"=>"id", 'toadd'=>"/admin/articles/types.php"),
				'required'   => false,
		), true);
$admin->DescribeField("Дата старта",	"date_start",     "date",    array(0, 0), true );
$admin->DescribeField("Дата финиша", 	"date_finish",    "date",    array(0, 0), true );
$admin->DescribeField("Инструктор",	"trainer_id",	"ForeignKey",
		array(
				'other_table'=>'trainers',
				'other_id'   =>'id',
				'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",
				'value'      =>"{{id}}",
				'text'       =>"{{name}}",
				'required'   => false,
		), true);



$admin->filter->AddField("ID",      'id',         1, '', null,   False);
$admin->filter->AddField("Маршрут",	'route_id',   1, '', null,   False);
$admin->filter->AddField("Дата старта",	'date_start',   1, '', null,   False);
$admin->filter->AddField("Дата финиша",	'date_finish',   1, '', null,   False);
$admin->filter->AddField("Инструктор",	'trainer_id',   1, '', null,   False);

$admin->DoAction();
?>