<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'trainers';
$current_name  = 'Инструкторы';

$admin->filter->def_order = " ORDER BY `priority` ASC";
//$admin->filter_query = "SELECT {$current_table}.* FROM {$current_table} WHERE 1 ";

$admin->DescribeTable(	$name = $current_name,     //Имя. Просто имя.
		$table    = $current_table,//Таблица. Нужна для создания запросов.
		$change   = true,          //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
		$delete   = true,          //Возможность удаления строк
		$add      = true,          //Возможность добавления строк
		$main_fld = 'id',
		$history  = true
);

$admin->SetUpDown("priority", true);
$admin->history_name = 'name';

$admin->DescribeField("Имя",					"name",     	"string",  	array(0, 255), 	true );
$admin->DescribeField("Дата рождения",			"birthday",     "date",    	array(0, 0), 	true );
$admin->DescribeField("Опыт походов", 			"practice",   	"date",    	array(0, 0), 	true );
$admin->DescribeField("Стаж инструктора", 		"experience",   "date",    	array(0, 0), 	true );
$admin->DescribeField("Девиз",					"slogan",     	"string",  	array(0, 255), 	true );
$admin->DescribeField("Достижения",				"progress",     "string",  	array(0, 255), 	true );
$admin->DescribeField("Краткий рассказ о себе",	"text_short",   "text_fck",	array(0, 0), 	true );
$admin->DescribeField("Полный рассказ о себе",	"text_long",    "text_fck",	array(0, 0), 	true );

$middle = array("size"      => array(800,600),
		"path"      => $_SERVER['DOCUMENT_ROOT']."/files/trainers/middle",
		'url'       =>"/files/trainers/middle",
		"field_url" =>'middle',
		"field_path"=>'middle_p',
);
$thumb    = array("size"      => array(240,240),
		"path"      => $_SERVER['DOCUMENT_ROOT']."/files/trainers/thumb",
		'url'       =>"/files/trainers/thumb",
		"field_url" =>'thumb',
		"field_path"=>'thumb_p',
);
$resizer = array($middle, $thumb);
$admin->DescribeField("Фото",	"image", "image", array( "resizer"=>$resizer, 'thumb_field'=>'thumb', 'thumb_size'=>'width: 150px',), true );
$admin->DescribeField("Показывать на главной странице",	"show_on_main_page",	"enum",  array(1 => "да", 0 => "нет"), true);


$admin->filter->AddField("ID",      		'id',       1, '', null,   False);
$admin->filter->AddField("Имя",				'name',   	1, '', null,   False);
$admin->filter->AddField("Дата рождения",	'birthday', 1, '', null,   False);
$admin->filter->AddField("Фото",	 		'thumb', 	0, "", "filter_field_image",  False);

$admin->DoAction();
?>
