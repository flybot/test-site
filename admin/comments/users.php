<?php
/* ! --       shevayura       -- ! */

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

/*
 * Опишем таблицу.
 */
$admin->DescribeTable($name     ="Комментарии - пользователи",   //Имя. Просто имя.
                      $table    = "comments_users",  //Таблица. Нужна для создания запросов.
                      $change   = true,     //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = false,     //Возможность добавления строк
                      $main_fld = 'id',      //Поле. Что-то типа ИД. Первичный ключ в таблице. Не повторяющийся.
                      $history  = true
        );
$admin->history_name = 'name';


$admin->DescribeField("Провайдер",          "provider",    "string",    array(0, 255), true );
$admin->DescribeField("Идентификатор",      "identifier",  "string",    array(0, 255), true );
$admin->DescribeField("Имя",                "name",        "string",    array(0, 255), true );
$admin->DescribeField("УРЛ фото",           "photo",       "string",    array(0, 255), true );
$admin->DescribeField("УРЛ профайла",       "profile",     "string",    array(0, 255), true );

$admin->filter->AddAvailable("Пользователь", "id", "list", "SELECT * FROM `comments_users` WHERE 1 ORDER BY provider, name", "id", "[{{provider}}] {{name}}", 20);


//fields in result table
function mess($r, $f){
    global $mngrDB;
    $c = $mngrDB->mysqlGetCount('comments_messages', " `user_id`='{$r['id']}' ");

    return $c ? sprintf('<a href="/admin/comments/messages.php?user_id=%s">Сообщений: %s</a>', $r['id'], $c) : 'Сообщений нету';
}

function photo($r, $f){
    return sprintf('<img src="%s" style="max-width:50px; max-height:50px;"/>', $r['photo']);
}

function url($row, $field){
    return sprintf('<a href="%s" target="_blank">%s on %s</a>', $row['profile'], $row['name'], $row['provider']);
}

$admin->filter->AddField("ID",                 'id',            1, '', null,   False);
$admin->filter->AddField("Провайдер",          'provider',      1, '', null,   False);
$admin->filter->AddField("Идентиф.",           'identifier',    1, '', null,   False);
$admin->filter->AddField("Имя",                'name',          1, '', null,   False);
$admin->filter->AddField("Профиль",            'profile',       1, '', 'url',  False);
$admin->filter->AddField("Фото",               'photo',         0, '', 'photo',False);
$admin->filter->AddField("Обновлен",           'updated',       1, '', null,   False);
$admin->filter->AddField("Сообщений",          '',              0, '', 'mess', False);



$admin->DoAction();

?>
