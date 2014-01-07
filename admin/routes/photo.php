<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'photo';
$current_name  = 'Фотографии';

$admin->DescribeTable(	$name = $current_name,     //Имя. Просто имя.
		$table    = $current_table,//Таблица. Нужна для создания запросов.
		$change   = true,          //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
		$delete   = true,          //Возможность удаления строк
		$add      = true,          //Возможность добавления строк
		$main_fld = 'id',
		$history  = true
);

//$admin->SetUpDown("priority", true);
$admin->history_name = 'desc';

$admin->DescribeField("Описание",	"desc",     "string",    array(0, 255), true );

$original = array("size"      => array(),   
		"path"      => $_SERVER['DOCUMENT_ROOT']."/files/routes/original", 
		'url'       =>'/files/routes/original',
		"field_url" =>'original',              
		"field_path"=>'original_p', 
);
$thumb    = array("size"      => array(240,240),
		"path"      => $_SERVER['DOCUMENT_ROOT']."/files/routes/thumb", 
		'url'       =>"/files/routes/thumb",
		"field_url" =>'thumb',
		"field_path"=>'thumb_p',
);
$resizer = array($original, $thumb);
$admin->DescribeField("Изображение", "original", "image", array( "resizer"=>$resizer, 'thumb_field'=>'thumb', 'thumb_size'=>'width: 150px',), true );


$admin->filter->AddField("ID",      	'id',       1, '', null,   False);
$admin->filter->AddField("Описание",	'desc',   	1, '', null,   False);
$admin->filter->AddField("Изображение", 'original', 	0, '',"filter_field_image",  False);


$admin->DoAction();
?>