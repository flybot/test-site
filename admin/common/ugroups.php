<?php
/* ! --       09.08.2011 shevayura       -- !
 *
 * Редактирование списков администраторов. 
 */
require_once 'admin_fnc.php';

/*
 * Опишем таблицу.
 */

$admin->DescribeTable($name     ="Группы админ.",   //Имя. Просто имя.
                      $table    = $admin->user->table_groups,  //Таблица. Нужна для создания запросов.
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

$admin->DescribeField("Alias", $admin->user->column_gr_al, "string", array(4, 255), true);
$admin->DescribeField("Название", 'name', "string", array(4, 255), true);
$admin->DescribeField("Комментарий", 'comment', "string", array(4, 255), true);
$admin->history_name = $admin->user->column_gr_al;

/*
 * Опишем фильтры и поля!
 */

$admin->filter->AddField("ID",          $admin->user->column_gr_id, 1, '', null,   False);
$admin->filter->AddField("Alias",       $admin->user->column_gr_al, 1, '', null,   False);
$admin->filter->AddField("Название",    'name',                     1, '', null,   False);
$admin->filter->AddField("Комментарий", 'comment',                  0, '', null,   False);

$admin->DoAction();