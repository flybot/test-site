<?php
/* ! --       08.08.2011 shevayura       -- !
 *
 * Доступ к автоматическим логам админки
 */

require_once 'admin_fnc.php';

/*
 * Опишем таблицу.
 */
$admin->filter->def_order = " ORDER BY time DESC ";

$admin->DescribeTable($name     ="Логи административной панели",   //Имя. Просто имя.
                      $table    = "adminlog",  //Таблица. Нужна для создания запросов.
                      $change   = false,       //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = false,     //Возможность удаления строк
                      $add      = false,     //Возможность добавления строк
                      $main_fld = 'id'      //Поле. Что-то типа ИД. Первичный ключ в таблице. Не повторяющийся.
        );
/*
 * Опишем поля БД, чтобы стало возможным их править.
 * Описывать нужно все поля, которые нужно заполнять при инсерте.
 * Для апдейта просто ставить отметку
 */

/*
 * Опишем фильтры и поля!
 */
$admin->filter->AddAvailable("Пользователь", "admin", "list",
        "SELECT DISTINCT adminlog.admin, {$admin->user->table_users}.`{$admin->user->column_email}` FROM `adminlog`, {$admin->user->table_users} WHERE adminlog.admin={$admin->user->table_users}.`{$admin->user->column_id}`",
        "admin", "{{".$admin->user->column_email."}}");
$admin->filter->AddAvailable("Дейтсвие", "type", "list", "SELECT DISTINCT `type` FROM `adminlog`", "type", "{{type}}");
$admin->filter->AddAvailable("Время", "time", "range_date",
                                "SELECT MIN(time) AS vmin, MAX(time) AS vmax FROM `adminlog` WHERE 1",
                                array(), "");

//callback func
function adm($row, $field){
    global $admin;
    $a = $admin->GetAdminById($row['admin']);
    return $a != '#ERROR#' ? $a : "Не могу найти данные для ".$row['admin'];
}

function tm($row, $field){
    return date("d.m.Y H:i", strtotime($row['time']));
}
//Fields
$admin->filter->AddField("ID",           'id',             1, '', null,    False);
$admin->filter->AddField("Пользователь", 'admin',          1, '', "adm",   False);
$admin->filter->AddField("Действие",     'type',           1, '', null,    False);
$admin->filter->AddField("Подробнее",    'action',         1, '', null,    False);
$admin->filter->AddField("Время",        'time',           1, '', 'tm',    False);


$admin->DoAction();