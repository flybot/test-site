<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'slides';
$current_name  = 'Слайды';

$admin->filter->def_order = " ORDER BY `priority` ASC";

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

$admin->DescribeField("Название слайда",	"name",     "string",    array(0, 255), true );
$admin->DescribeField("Ссылка",				"link",     "string",    array(0, 255), true );

$thumb = array(	"size" 	=> array(0,0),
			"path"      => $_SERVER['DOCUMENT_ROOT']."/files/slides",
			'url'       =>'/files/slides',
			"field_url" =>'image',
			"field_path"=>'image_p',
);
$admin->DescribeField("Рисунок", 			"thumb", 		"image", 	array( "resizer"=>array($thumb, ),'thumb_field'=>'image','thumb_size'=>'width: 150px', ), true );


$admin->filter->AddField("ID",            	'id',         1, '', null,   False);
$admin->filter->AddField("Название слайда",	'name',       1, '', null,   False);
$admin->filter->AddField("Изображение", 'image', 0, '',"filter_field_image",  False);

$admin->DoAction();
?>