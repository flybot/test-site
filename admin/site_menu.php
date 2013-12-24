<?php
/* ! --       shevayura       -- ! */

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

/*
 * Опишем таблицу.
 */
$admin->filter->def_order = " ORDER BY priority ";
$admin->filter_query = "SELECT
                        (select menu_types.name from menu_types WHERE menu_types.id=menu.type_id)   as type_name,
                        (select modules.name    from modules    WHERE    modules.id=menu.module_id) as module_name,
                        menu.* FROM menu WHERE 1";
$admin->DescribeTable($name     ="Меню сайта",   //Имя. Просто имя.
                      $table    = "menu",  //Таблица. Нужна для создания запросов.
                      $change   = true,     //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id',
                      $history = true
        );
$admin->SetUpDown("priority", true);
$admin->history_name = 'name';


$admin->DescribeField("Название",        "name",        "string",    array(3, 255), true );
$admin->DescribeField("Описание",        "desc",        "string",    array(0, 255), true );
$admin->DescribeField("URL",             "url",         "string",    array(1, 255), true );

$admin->DescribeField("Родитель", "parent_id", "ForeignKey",  //Вот он! Новый тип поля!
		array(
				'other_table'=>'menu',                               //Таблица, куда ссылаемся
				'other_id'   =>'id',                                  //главное поле в той таблице
				'opt_query'  => "SELECT * FROM {{other_table}} WHERE parent_id=0",      //Запрос на выборку элементов
				'value'      =>"{{id}}",                              //Значение из результата выборки
				'text'       =>"{{name}}",                        //Текст варианта из результат выборки
				'subtype'    => array(),                              //Подтип поля (если нету - пустой массив)
				'required'   => false,
		),
		true ); //foreign key

$admin->DescribeField("Группа меню", "type_id", "ForeignKey",  //Вот он! Новый тип поля!
                      array(
                          'other_table'=>'menu_types',                               //Таблица, куда ссылаемся
                          'other_id'   =>'id',                                       //главное поле в той таблице
                          'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",   //Запрос на выборку элементов
                          'value'      =>"{{id}}",                                   //Значение из результата выборки
                          'text'       =>"{{name}} [{{alias}}]",                     //Текст варианта из результат выборки
                          'subtype'    => array(),                                   //Подтип поля (если нету - пустой массив)
                          'required'   => false,
                      ),
                      true ); //foreign key

$admin->DescribeField("Модуль", "module_id", "ForeignKey",  //Вот он! Новый тип поля!
                      array(
                          'other_table'=>'modules',                                  //Таблица, куда ссылаемся
                          'other_id'   =>'id',                                       //главное поле в той таблице
                          'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",   //Запрос на выборку элементов
                          'value'      =>"{{id}}",                                   //Значение из результата выборки
                          'text'       =>"{{name}}",                                 //Текст варианта из результат выборки
                          'subtype'    => array(),                                   //Подтип поля (если нету - пустой массив)
                          'required'   => false,
                      ),
                      true ); //foreign key


$admin->filter->AddAvailable("Группа", "type_id",   "list", "SELECT * FROM `menu_types` WHERE 1", "id", "{{name}} [{{alias}}]", 100);
$admin->filter->AddAvailable("Модуль", "module_id", "list", "SELECT * FROM `modules`    WHERE 1", "id", "{{name}}",             100);
$admin->filter->AddAvailable("Родитель", "parent_id", "list", "SELECT * FROM `menu` WHERE parent_id=0", "id", "{{name}}", 100);
//user functions



function p($row, $field){
    $id = $row['parent_id'];
    if ($id == 0 )
        return '';
    global $admin;
    $p = $admin->mngrDB->mysqlGet("SELECT * FROM  adminmenu WHERE parent_id=0 AND id='$id'");
    if ( !$p )
        return "#Родитель не найден#";

    return $p[0]['name'];
}
function p2($row, $field){
	$id = $row['parent_id'];
	if ($id == 0 )
		return '';
	global $admin;
	$p = $admin->mngrDB->mysqlGet("SELECT * FROM  menu WHERE parent_id=0 AND id='$id'");
	if ( !$p )
		return "#Родитель не найден#";

	return $p[0]['name'];
}
//fields in result table

function url($row, $field){
    $u = $row['url'];
    $su = substr($u, 0, 30);
    return '<a href="'.$u.'" title="'.$row['name'].'">'.$su.'</a>';
}

$admin->filter->AddField("ID",                'id',         1, '', null,   False);
$admin->filter->AddField("Название",          'name',       1, '', null,   False);
$admin->filter->AddField("Описание",          'desc',       0, '', null,   False);
$admin->filter->AddField("URL",               'url',        1, '', 'url',  False);

$admin->filter->AddField("Группа",            'type_name',  0, '', null,   False);
$admin->filter->AddField("Модуль",            'module_name',0, '', null,   False);
$admin->filter->AddField("Родитель",    	  'parent_id',     1, '', 'p2',    False);

$admin->filter->AddField("P",                 'priority',   1, '', null,   False);



$admin->DoAction();

?>
