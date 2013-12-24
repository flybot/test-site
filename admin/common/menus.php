<?php
/* ! --       shevayura       -- ! */

require_once 'admin_fnc.php';

/*
 * Опишем таблицу.
 */
$admin->filter->def_order = " ORDER BY priority ";
$admin->DescribeTable($name     ="Меню",   //Имя. Просто имя.
                      $table    = "adminmenu",  //Таблица. Нужна для создания запросов.
                      $change   = true,     //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id',      //Поле. Что-то типа ИД. Первичный ключ в таблице. Не повторяющийся.
                      $history  = true
        );
$admin->SetUpDown("priority", true);
$admin->history_name = 'name';


$admin->DescribeField("Название",        "name",        "string",    array(3, 255), true );


$subtype = array();
$admin->DescribeField("Радитель", "parent", "ForeignKey",  //Вот он! Новый тип поля!
                      array(
                          'other_table'=>'adminmenu',                               //Таблица, куда ссылаемся
                          'other_id'   =>'id',                                  //главное поле в той таблице
                          'opt_query'  => "SELECT * FROM {{other_table}} WHERE parent=0",      //Запрос на выборку элементов
                          'value'      =>"{{id}}",                              //Значение из результата выборки
                          'text'       =>"{{name}}",                        //Текст варианта из результат выборки
                          'subtype'    => $subtype,                              //Подтип поля (если нету - пустой массив)
                          'required'   => false,
                      ),
                      true ); //foreign key

$admin->DescribeField("Описание",        "descr",        "string",    array(3, 255), true );
$admin->DescribeField("URL",        "url",        "string",    array(3, 255), true );



$admin->filter->AddAvailable("Родитель", "parent", "list", "SELECT * FROM `adminmenu` WHERE parent=0", "id", "{{name}}", 100);

//user functions



function p($row, $field){
    $id = $row['parent'];
    if ($id == 0 )
        return '';
    global $admin;
    $p = $admin->mngrDB->mysqlGet("SELECT * FROM  adminmenu WHERE parent=0 AND id='$id'");
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
$admin->filter->AddField("Родитель",          'parent',     1, '', 'p',    False);
$admin->filter->AddField("Описание",          'descr',      0, '', null,   False);
$admin->filter->AddField("URL",               'url',        1, '', 'url',  False);
$admin->filter->AddField("P",                 'priority',   1, '', null,   False);



$admin->DoAction();

?>
