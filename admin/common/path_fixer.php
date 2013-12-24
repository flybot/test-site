<?php

require_once 'admin_fnc.php';


$tables = array();
foreach($mngrDB->mysqlGet("SHOW TABLES") as $t){
    $t = array_values($t);
    if (empty($t[0])) continue;
    $tables[] = $t[0];
}


/*
 * log consts
 */

$droot= $_SERVER['DOCUMENT_ROOT'];
$what = '';
$to   = '';
$log  = array();
$use_tables = array();
if (!empty($_REQUEST['submit'])){
    $what = !empty($_REQUEST['what'])  ? mysql_real_escape_string($_REQUEST['what']) : '';
    $to   = !empty($_REQUEST['to'])    ? mysql_real_escape_string($_REQUEST['to'])   : '';
    
    $to   = !empty($_REQUEST['droot']) ? '' : $to; //use empty @to@ or droot
    
    $use_tables = !empty($_REQUEST['tables']) ? array_map('mysql_real_escape_string', $_REQUEST['tables']) : array();
    
    fixer_start($use_tables, $what, $to);
}







$context = array();
$context['tables'] = $tables;
$context['what']   = $what;
$context['to']     = $to;
$context['droot']  = $droot;
$context['log']    = $log; 

$context['droot_selected']  = empty($to);
$context['tables_selected'] = $use_tables;


$template = $_SERVER['DOCUMENT_ROOT'].rtrim($admin->path_to_admin, '/ ').'/common/templates/path_fixer.html';
$h2o = new H2o($template);

echo $h2o->render($context);


function xlog($type, $message){
    global $log;
    $log[] = array('type'=>$type, 'message'=>$message);
}

function fixer_start($tabl, $what, $to='') {
    global $mngrDB;
    
    if (!$to){
        $to = $_SERVER['DOCUMENT_ROOT'];
    }
    
    if (!$to){
        xlog('warning', '"На что заменить" не объявлен. Используется пустая строка!');
    }
    
    if (!$what){
        xlog('error', '"Что заменить" не объявлен! Остановка выполнения..');
        return;
    }
    
    if (empty($tabl)){
        xlog('notify', 'Список таблиц пуст! Применение происходит ко всем таблицам..');
        global $tables;
        $tabl = $tables;
    }
    
    xlog("message", "Замена [$what] на [$to] в ".join(', ', $tabl));
    
    //create queries
    $format = 'UPDATE `%s` SET %s WHERE 1';
    $for_fl = "`%s`=REPLACE(`%s`, '%s', '%s')";
    
    //get fields
    foreach($tabl as $table){
        $fields = array();
        foreach($mngrDB->mysqlGet("SHOW COLUMNS FROM `$table`") as $field){
            if (strpos($field['Type'], 'varchar') === false && strpos($field['Type'], 'text') === false) continue; //this is not text field
            $fields[] = sprintf($for_fl, $field['Field'], $field['Field'], $what, $to);
        }
        if (!$fields){
            xlog('notice', "Таблица $table не имеет текстовых полей");
            continue;
        }
        $query = sprintf($format, $table, join(', ', $fields));
        xlog("message", "К таблице $table применяется запрос - <br/><i>$query</i>");
        
        mysql_query($query, $mngrDB->dbConn);
        if ($myerr = mysql_error($mngrDB->dbConn))
            xlog('error', "При запросе к таблице $table произогла ошибка: $myerr");
    }
}