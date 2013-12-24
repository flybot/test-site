<?php
/*
 *  Запуск системы ресайза изображений 
 * (обёртка для класса дающая ему урл)
 */

ini_set('max_input_time', 999);
ini_set('max_execution_time', 999);
set_time_limit(999);

require_once 'admin_fnc.php';

$resizer = new SAdminMassResizer($admin);

$resizer->DoAction();