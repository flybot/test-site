<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

/*
 * Опишем таблицу.
 */
#$admin->filter_query = "";
$admin->DescribeTable($name     ="Группы меню",   //Имя. Просто имя.
                      $table    = "menu_types",  //Таблица. Нужна для создания запросов.
                      $change   = true,     //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id',
                      $history = true
        );
$admin->history_name = 'name';

$admin->DescribeField("Название",        "name",             "string",       array(2, 255), true );
$admin->DescribeField("Алиас",           "alias",            "string",       array(2, 255), true );
$admin->DescribeField("Описание",        "desc",             "text_fck",     array(0, 0),   true );

/*
$admin->DescribeField("Пункты меню",
                      "menu_links",
                      "link",
                      array(
                          'other_table' => 'menu',
                          'other_value' => 'id',
                          'other_link'  => 'type_id',
                          'opt_query'   => "SELECT * FROM {{other_table}} WHERE {{other_link}}=0 ",
                          'value'       => '{{id}}',
                          'text'       => '{{name}}',
                          'search_field'=> 'name',
                          'toadd'       => '',
                      ),
                      true);*/

function body($row, $field){
    $text = $row[$field['value']];
    return mb_strcut(strip_tags($text), 0, 100);
}


$admin->filter->AddField("ID",          'id',       1, '', null,   False);
$admin->filter->AddField("Название",    'name',     1, '', null,   False);
$admin->filter->AddField("Алиас",       'alias',    1, '', null,   False);
$admin->filter->AddField("Описание",    'desc',     1, '', 'body', False);

$admin->DoAction();

?>
