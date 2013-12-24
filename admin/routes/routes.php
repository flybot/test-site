<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'routes';
$current_name  = 'Маршруты';

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
$admin->DescribeField("Название",	"name",     "string",    array(0, 255), true );
$admin->DescribeField("Расстояние", 	"distance",    "integer",   array(0,100010), true );
$admin->DescribeField("Сложность",  	"complexity",    "enum",  array(0 => "низкая", 1 => "средняя", 2 => "высокая", 3 => "очень высокая"), true);
$admin->DescribeField("Краткое описание",	"descr_short",   "text_fck", array(0, 0),   true );
$admin->DescribeField("Полное описание",		"descr_long",	"text_fck", array(0, 0),   true );
$admin->DescribeField("Подготовка",		"preparation",	"text_fck", array(0, 0),   true );
// TODO: подключить больеш одной фотки, идеально чтоб перетащить 10 фоток можно было 
//		 и админка сама режет, заливает…, как в ВК.
$admin->DescribeField("Фото",		"photos",	"text_fck", array(0, 0),   true );
$admin->DescribeField("Видео",		"videos",	"text_fck", array(0, 0),   true );
$admin->DescribeField("Отзывы",		"reviews",	"text_fck", array(0, 0),   true );
$admin->DescribeField("Стоимость грн.", 	"cost_grn",    	"float",   array(0, 99999), true );
$admin->DescribeField("Стоимость руб.", 	"cost_rur",    	"float",   array(0, 99999), true );
$admin->DescribeField("Стоимость USD", 		"cost_usd",    	"float",   array(0, 99999), true );
$admin->DescribeField("Место старта",	"start",     "string",    array(0, 255), true );
$admin->DescribeField("Место финиша",	"finish",     "string",    array(0, 255), true );

$middle = array("size"      => array(800,600), 
		"path"      => $_SERVER['DOCUMENT_ROOT']."/files/routes/middle", 
		'url'       =>"/files/routes/middle", 
		"field_url" =>'middle',
		"field_path"=>'middle_p',
);
$thumb    = array("size"      => array(240,240),
		"path"      => $_SERVER['DOCUMENT_ROOT']."/files/routes/thumb", 
		'url'       =>"/files/routes/thumb",
		"field_url" =>'thumb',
		"field_path"=>'thumb_p',
);
$resizer = array($middle, $thumb);
$admin->DescribeField("Изображение", "image", "image", array( "resizer"=>$resizer, 'thumb_field'=>'thumb', 'thumb_size'=>'width: 150px',), true );


$admin->filter->AddField("ID",            	'id',         1, '', null,   False);
$admin->filter->AddField("Название",	'name',       1, '', null,   False);
//$admin->filter->AddField("Изображение", 'image', 0, "",  "filter_field_image",  False);

$admin->DoAction();
?>