<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'articles';
$current_name  = 'Статьи';
$current_fdir  = 'articles';

//$admin->filter->def_order = " ORDER BY `id` DESC ";
//$admin->filter_query = "SELECT {$current_table}.* FROM {$current_table} WHERE 1 ";

$admin->DescribeTable(
		$name	  = $current_name,     //Имя. Просто имя.
		$table    = $current_table,//Таблица. Нужна для создания запросов.
		$change   = true,          //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
		$delete   = true,          //Возможность удаления строк
		$add      = true,          //Возможность добавления строк
		$main_fld = 'id',
		$history  = true
);

$admin->history_name = 'name';

$admin->DescribeField("Тема",	"article_type",	"ForeignKey",
                      array(
                          'other_table'=>'article_types',
                          'other_id'   =>'id',
                          'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",
                          'value'      =>"{{id}}",
                          'text'       =>"{{name}}",
                          //'subtype'    => array('name'=>'xself', 'search_field'=>"name", "value_field"=>"id", 'toadd'=>"/admin/articles/types.php"),
                          'required'   => false,
                      ), true);
$admin->DescribeField("Название",			"name",     	"string",  	array(0, 255), true );

$thumb = array(	"size" 	=> array(0,0),
			"path"      => $_SERVER['DOCUMENT_ROOT']."/files/".$current_fdir,
			'url'       =>'/files/'.$current_fdir,
			"field_url" =>'thumb',
			"field_path"=>'thumb_p',
);
$admin->DescribeField("Рисунок", 			"thumb", 		"image", 	array( "resizer"=>array($thumb, ),'thumb_field'=>'thumb','thumb_size'=>'width: 150px', ), true );

$admin->DescribeField("Краткое описание",	"text_short",   "text_fck", array(0, 0),   true );
$admin->DescribeField("Полный текст",		"text_long",	"text_fck", array(0, 0),   true );
$admin->DescribeField("Заголовок статьи",	"title",		"string",   array(0, 255), true );
$admin->DescribeField("Описание",  			"descr",		"text_fck", array(0, 0),   true );
$admin->DescribeField("Ключевые слова",		"keywords",		"string",   array(0, 255), true );


$admin->filter->AddField("ID",         	'id',    1, '', null,   False);
$admin->filter->AddField("Название",	'name',  1, '', null,   False);
$admin->filter->AddField("Изображение", 'thumb', 0, '',"filter_field_image",  False);

//$admin->filter->AddField("Заголовок темы",  'title',      1, '', null,   False);

$admin->DoAction();
?>