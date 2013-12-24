<?php
/*
 *  Запуск системы автообновления 
 * (обёртка для класса дающая ему урл)
 */

require_once 'admin_fnc.php';

$updater = new SAdminUpdater($admin);

$updater->DoAction();