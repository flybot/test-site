<?php
/* ! --       08.08.2011 shevayura       -- !
 *
 * Статические страницы для модуля статических страниц
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

$admin->DescribeTable($name     ="Модули",   //Имя. Просто имя.
                      $table    = "modules",  //Таблица. Нужна для создания запросов.
                      $change   = true,       //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id'      //Поле. Что-то типа ИД. Первичный ключ в таблице. Не повторяющийся.
        );
$admin->SetUpDown("priority", true);
$admin->history_name = 'name';


$admin->DescribeField("Название",   "name",       "string",    array(0, 255), true );
$admin->DescribeField("Директория", "dir",        "string",    array(0, 255), true );
$admin->DescribeField("Активный",   "active",     "enum",      array('Неактивный', 'Активный'), true );


function act($r, $f){
    global $admin;
    return array_key_exists($r[$f['value']], $admin->fields[$f['value']]['values'])
            ? $admin->fields[$f['value']]['values'][$r[$f['value']]] : '#error#';
}

//Fields
$admin->filter->AddField("ID",                  'id',               1, '', null,   False);
$admin->filter->AddField("Название",            'name',             1, '', null,   False);
$admin->filter->AddField("Директория",          'dir',              1, '', null,   False);
$admin->filter->AddField("Активный",            'active',           1, '', 'act',   False);
$admin->filter->AddField("Приоритет",           'priority',         1, '', null,   False);

/*
 * А этот метод пережует запрос и поймёт что делать дальше
 * Будь то печать списка, или вывод формы редактирования/добавления
 * Либо удаление и снова печать списка...
 */
$admin->DoAction();
//$admin->filter->

?>
