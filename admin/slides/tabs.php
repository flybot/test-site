<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'tabs';
$current_name  = 'Вкладки';

//$admin->filter->def_order = " ORDER BY `priority` ASC";

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

$admin->DescribeField("Название вкладки",	"name",     "string",    array(0, 255), true );
$admin->DescribeField("Регион",	"region_id",	"ForeignKey",
		array(
				'other_table'=>'regions',
				'other_id'   =>'id',
				'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",
				'value'      =>"{{id}}",
				'text'       =>"{{name}}",
				'subtype'    => array('name'=>'xself', 'search_field'=>"name", "value_field"=>"id", 'toadd'=>"/admin/routes/regions.php"),
				'required'   => false,
		), true);

$admin->filter->AddField("ID",            		'id',         1, '', null,   False);
$admin->filter->AddField("Название вкладки",	'name',       1, '', null,   False);

$admin->DoAction();
?>
