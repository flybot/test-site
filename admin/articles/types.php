<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$current_table = 'article_types';
$current_name  = 'Темы статей';

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

$admin->DescribeField("Название темы",	"name",     "string",    array(0, 255), true );
$admin->DescribeField("Содержание",		"text",     "text_fck",  array(0, 0),   true );
$admin->DescribeField("Заголовок темы", "title",    "string",    array(0, 255), true );
$admin->DescribeField("Описание темы",  "descr",    "text_fck",  array(0, 0),   true );
$admin->DescribeField("Ключевые слова",	"keywords", "string",    array(0, 255), true );

$admin->filter->AddField("ID",            	'id',         1, '', null,   False);
$admin->filter->AddField("Название темы",	'name',       1, '', null,   False);
//$admin->filter->AddField("Заголовок темы",  'title',      1, '', null,   False);

$admin->DoAction();
?>