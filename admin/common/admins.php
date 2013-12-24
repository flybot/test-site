<?php
/* ! --       09.08.2011 shevayura       -- !
 *
 * Редактирование списков администраторов. 
 */
require_once 'admin_fnc.php';

/*
 * Опишем таблицу.
 */

$admin->filter_query = "SELECT *, (select name from {$admin->user->table_groups} where {$admin->user->table_users}.{$admin->user->column_group}={$admin->user->table_groups}.{$admin->user->column_gr_id} limit 1) as grname FROM {$admin->user->table_users} WHERE 1 ";
$admin->DescribeTable($name     ="Администраторы",   //Имя. Просто имя.
                      $table    = $admin->user->table_users,  //Таблица. Нужна для создания запросов.
                      $change   = true,       //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id',      //Поле. Что-то типа ИД. Первичный ключ в таблице. Не повторяющийся.
                      $history  = true
        );
/*
 * Опишем поля БД, чтобы стало возможным их править.
 * Описывать нужно все поля, которые нужно заполнять при инсерте.
 * Для апдейта просто ставить отметку
 */

$admin->DescribeField("Email", $admin->user->column_email, "string", array(4, 255), true);
$admin->history_name = $admin->user->column_email;
$admin->DescribeField("Group", $admin->user->column_group, "ForeignKey",
                      array(
                          'other_table'=>$admin->user->table_groups,
                          'other_id'   =>$admin->user->column_gr_id,
                          'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",
                          'value'      =>"{{".$admin->user->column_gr_id."}}",                              //Значение из результата выборки
                          'text'       =>"{{name}} [{{".$admin->user->column_gr_al."}}]",                        //Текст варианта из результат выборки
                          'subtype'    => array(),                              //Подтип поля (если нету - пустой массив)
                          'required'   => true,
                      ),
                      true ); //foreign key

/*
 * Опишем фильтры и поля!
 */

$admin->filter->AddField("ID",    'id',                       1, '', null,   False);
$admin->filter->AddField("Email", $admin->user->column_email, 1, '', null,   False);
$admin->filter->AddField("Группа",'grname',                   1, '', null,   False);

$admin->DoAction();