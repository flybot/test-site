<?php
/* ! --       08.08.2011 shevayura       -- !
 *
 * Статические страницы для модуля статических страниц
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

//$admin->filter_query ="SELECT pages.* , menu.name, menu.id FROM pages,menu WHERE pages.menu_id=menu.id AND menu.id=0";

$admin->DescribeTable($name     ="Static pages",   //Имя. Просто имя.
                      $table    = "pages",  //Таблица. Нужна для создания запросов.
                      $change   = true,       //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id',
                      $history  = true
        );
$admin->history_name = 'page_name';

$admin->DescribeField("Имя страницы",    "page_name",        "string",     array(0, 255), true );
$admin->DescribeField("Ссылка",          "page_link",        "string",     array(0, 255), true );
//$admin->DescribeField("Язык",          "page_lang",        "string",     array(0, 20), true );
$admin->DescribeField("Меню на сайте",   "menu_id",          "ForeignKey", array('other_table'=>'menu','other_id'=>'id',
                                         'opt_query'  =>  "SELECT * FROM {{other_table}}  WHERE 1",
                                         'value'      =>"{{id}}",'text'       =>"{{name}}",'subtype'    => array()),   true );

$admin->DescribeField("Текст",           "page_text",        "text_fck",   array(0, 0),   true );
$admin->DescribeField("Тэг Description", "page_description", "text",       array(0, 0),   true );
$admin->DescribeField("Тэг Keywords",    "page_keywords",    "text",       array(0, 0),   true );
//$admin->DescribeField("CSS",             "css",              "text",       array(0, 0),   true );
$admin->DescribeField("Показывать дату изменений", "show_changes", "enum",   array(0 => "Нет", 1 => "Да"), true);


//create menu filter
$menus = $mngrDB->mysqlGet("SELECT `id`, `name` FROM `menu` WHERE `parent`=0 ");
$m_arr = array();
foreach($menus as $key=>$value){
    $menus[$key]['ids'] = array();
    $menus[$key]['ids'][] = $value['id'];
    foreach( $mngrDB->mysqlGet("SELECT `id` FROM `menu` WHERE parent='{$value['id']}'") as $sub){
        $menus[$key]['ids'][] = $sub['id'];
    }
    $m_arr[$value['name']] = " menu_id IN ('". join("','", $menus[$key]['ids']) ."') ";
}

$admin->filter->AddAvailable("Меню первого уровня", 'menuxxx', "custom", "", array( 'join'=>"OR", 'variants'=>$m_arr, ), '', 10);
//$admin->filter->AddAvailable("Меню на сайте", "menu_id",   "list", "SELECT menu.* FROM  menu WHERE 1 ORDER BY name ", "id", "{{name}}", 10);
$admin->filter->AddAvailable("Имя страницы",  "page_name", "list", "SELECT DISTINCT `page_name` FROM `pages` ORDER BY  `page_name`", "page_name", "{{page_name}}", 10);


function body($row, $field){
    $text = strip_tags($row['page_text']);
    if (strlen($text) > 200)
        $text = substr($text, 0, 200) . '...';
    return $text;//htmlspecialchars($text);
}
function menu($row,$field){
global $admin;
	if($row['menu_id']==0){
		$text = "Нету";
	}else{
	$id = $row['menu_id'];
	$aux=$admin->mngrDB->mysqlGet("SELECT menu.* FROM menu WHERE id=$id ORDER BY priority"); 	
	$text = $aux[0]['name'];	
	}
	return $text;
}
function page_link($row,$field){
    $link = $row['page_link'];
    $text = "<a href=\"/$link\">$link<a>";
    return $text;
}

function xbool($r, $f){
    return $r[$f['value']] ? "Да" : "Нет";
}

function xdate($r, $f){
    return date("d.m.Y H:i", strtotime($r[$f['value']]));
}

//Fields
$admin->filter->AddField("ID",             'id',                     1, '', null,   False);
$admin->filter->AddField("Имя",            'page_name',              1, '', null,   False);
$admin->filter->AddField("Ссылка",         'page_link',              1, '','page_link',   False);
$admin->filter->AddField("Меню на сайте",  "menu.id" ,               1, '','menu',  FALSE);
//$admin->filter->AddField("Язык",         'page_lang',              1, '', null,   False);
$admin->filter->AddField("Текст",          'page_text',              0, '',"body",  False);
$admin->filter->AddField("Description",    'page_description',       1, '', null,   False, 1, 1);
$admin->filter->AddField("Keywords",       'page_keywords',          1, '', null,   False, 1, 1);
//$admin->filter->AddField("CSS",            'css',                    1, '', null,   False);
$admin->filter->AddField("Дата изм.",       'changed',               1, '', "xdate",   False);
$admin->filter->AddField("Показ изм.",      'show_changes',          1, '', "xbool",   False);


/*
 * А этот метод пережует запрос и поймёт что делать дальше
 * Будь то печать списка, или вывод формы редактирования/добавления
 * Либо удаление и снова печать списка...
 */
$admin->DoAction();
//$admin->filter->

?>
