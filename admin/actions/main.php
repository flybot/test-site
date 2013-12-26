<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'actions';
$current_name  = 'Акции';

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

$admin->DescribeField("Название",			"name",     	"string",  	array(0, 255), 	true );
$admin->DescribeField("Дата завершения", 	"date_end",    "date",    array(0, 0), true );
$admin->DescribeField("Выводить в регионе",	"visible",	"enum",  array(1 => "да", 0 => "нет"), true);

$thumb = array(	"size" 	=> array(0,0),
			"path"      => $_SERVER['DOCUMENT_ROOT']."/files/actions",
			'url'       =>'/files/actions',
			"field_url" =>'image',
			"field_path"=>'image_p',
);
$admin->DescribeField("Рисунок", 			"thumb", 		"image", 	array( "resizer"=>array($thumb, ),'thumb_field'=>'image','thumb_size'=>'width: 150px', ), true );

$admin->filter->AddField("ID",      		'id',       1, '', null,   False);
$admin->filter->AddField("Название",		'name',   	1, '', null,   False);
$admin->filter->AddField("Фото",	 		'image', 	0, "", "filter_field_image",  False);

$admin->DoAction();
?>
