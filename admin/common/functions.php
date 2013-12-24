<?php

/**
 * Data for langs
 * Must be an array 
 * [ ['name'=>'Name of language', 'abbr'=>'abbreviation'], ... ]
 */
$i18n_langs = $mngrDB->mysqlIsTableExists('i18n_langs') ? $mngrDB->mysqlGet("SELECT * FROM i18n_langs WHERE 1 ORDER BY priority", null, 'abbr') : array();

/**
 * Create and register multiple fields for all available languages (Externals)
 *
 * @global <Admin object> $admin
 * @global <Array> $i18n_langs  - array of langs
 * @param <String> $name
 * @param <String> $field
 * @param <String> $type
 * @param <Array> $values
 */
function create_i18n_fields($name, $field, $type, $values){
    global $admin, $i18n_langs;
    $kl = array_keys($i18n_langs);
    foreach($i18n_langs as $lang){
        $external = array(
            'mode'       =>'as_link', //подтип поля
            'table'      =>'i18n_base',//название таблицы
            'main_fld'   =>'id',      //название ключевого поля во внешней таблице
            'value_field'=>'value',   //название поля для записи редактируетмого значения
            'this_id'    =>'row_id', //название поля во внешней таблице для сохранения ИД текущей записи
            'other_id'   =>'',        //название поля в текущей таблице для сохранения ИД внешней записи
            'values'     =>array('tname'=>$admin->current['table'], 'lang'=>$lang['abbr'], 'fname'=>$field),
            'values_in_request'=>true,//использовать значения из подмассива values при построении запроса на выборку
            'extra_where'=>'',//дополнительные условия на выборку
            'delete'=>true,
        );
        $admin->DescribeField($name." [{$lang['name']}]",    $field."_".$lang['abbr'], $type,    $values, true, '', '', '', $external);
    }
}

function search_i18n($name){
    global $i18n_langs;
    $ret = array();
    foreach($i18n_langs as $lang){
        $ret[] = $name."_".$lang['abbr'];
    }
    return $ret;
}


/**
 *
 * Create query part for extract multilang data from base i18n table
 * Have variable  mirror for call from strings - $_create_i18n_query_part
 *
 * @global <type> $admin
 * @global <type> $i18n_langs
 * @param <String> $table  - table (default - current table)
 * @param <String> $lang   - lang  (default - first lang (by priority)
 * @param <String> $_      - fields (default - all available fields)
 * @return <String>  - part fon insert in query ("select" area)
 */
function create_i18n_query_part($table='', $lang='', $_=''){
    global $admin, $i18n_langs;

    if (!$table) $table = $admin->current['table'];
    if (!$lang)  foreach($i18n_langs as $l){ $lang = $l['abbr']; break; };

    $table = mysql_real_escape_string($table);
    $lang = mysql_real_escape_string($lang);

    $format = "(SELECT i18n_base.value FROM i18n_base WHERE `i18n_base`.`lang`='$lang' AND `i18n_base`.`tname`='{$table}'
                AND `i18n_base`.`row_id`=`{$table}`.`id` AND `i18n_base`.`fname`='%s') as `%s`";
    $query = array();

    $fields = array_slice(func_get_args(), 2);
    if (!$fields){
        $fields = array_keys($admin->mngrDB->mysqlGet("SELECT DISTINCT fname FROM i18n_base WHERE tname='{$table}'", null, 'fname'));
    }
    foreach($fields as $fname){
        $fname = mysql_real_escape_string($fname);
        $query[] = sprintf($format, $fname, $fname);
    }

    return $query ? " ".join(", ", $query)." " : " 'x' as xtemplatevalue ";
}
$_create_i18n_query_part = 'create_i18n_query_part'; //variable mirror for call from strings


/**
 *
 * @param <String> $table - name of table (default: current table form $admin->current)
 * @param <String> $as_name - set column name for return data (def: last_edit_time)
 * @return <String>  Part for paste in request (block select)
 */
function _create_last_edit_time($table='', $as_name='last_edit_time'){
    global $admin;
    if (!$table) $table = $admin->current['table'];
    if (!$as_name) $as_name = 'last_edit_time';
    
    return " (select adminhistory.`date` from adminhistory where adminhistory.`table`='$table' AND adminhistory.row_id=`$table`.`{$admin->current['main_fld']}` ORDER BY adminhistory.`date` DESC LIMIT 1) as $as_name ";
}
$_create_last_edit_time = '_create_last_edit_time'; //mirror

/**
 *
 * @param <String> $table - name of table (default: current table form $admin->current)
 * @param <String> $as_name - set column name for return data (def: last_edit_user)
 * @return <String>  Part for paste in request (block select)
 */
function _create_last_edit_user($table='', $as_name='last_edit_user'){
    global $admin;
    if (!$table) $table = $admin->current['table'];
    if (!$as_name) $as_name = 'last_edit_user';

    return " (select {$admin->user->table_users}.`{$admin->user->column_email}` from {$admin->user->table_users}, adminhistory where adminhistory.`table`='$table' AND adminhistory.row_id=`$table`.`{$admin->current['main_fld']}` AND {$admin->user->table_users}.{$admin->user->column_id}=adminhistory.admin_id ORDER BY adminhistory.`date` DESC LIMIT 1) as $as_name ";
}
$_create_last_edit_user = '_create_last_edit_user'; //mirror

//mirror for both
function _create_last_edit_data($table='', $as_name_time='', $as_name_user=''){
    return _create_last_edit_time($table, $as_name_time).', '._create_last_edit_user($table, $as_name_user);
}
$_create_last_edit_data = '_create_last_edit_data';



/*
 * user defined functions for check field data
 */


/**
 * custom user defined function for check field data for unique value in current table
 * 
 */
function field_check_unique($field, $data){
    global $admin;
    $fname = $field['field'];
    if ($admin->current_action == "edit" && $admin->row[$fname] == $data)
            return array();

    $data = mysql_real_escape_string($data);
    $err = array();
    if ( $admin->mngrDB->mysqlGetCount($admin->current['table'], " `$fname`='$data' ") > 0 )
        $err[] = 'Этот алиас уже занят';

    return $err;
}


/**
 * custom check data for unique and check chars for safely
 */
function field_check_alias($field, $data){
    $err = field_check_unique($field, $data);
    
    //create pattern for good chars
    $patt  = 'qwertyuiopasdfghjklzxcvbnm';
    $patt .= strtoupper($patt);
    $patt .= '1234567890_-';
    
    for($i=0; $i<mb_strlen($data, 'utf-8'); $i++){
        $char = mb_substr($data, $i, 1, 'utf-8');
        if (mb_strpos($patt, $char, 0, 'utf-8')===false){
            $err[] = "Недопустимый символ &quot;{$char}&quot;<br/><a href=\"#\" title=\"$patt\" style=\"text-decoration:none; border: gray dotted 1px; color: gray;\">Можно только эти</a> ";
            break;
        }
    }
    
    return $err;
}


/**
 * filters fields functions
 */

/**
 * Create avilable filter using field data
 * @param <String> $field_name - admin field name 
 * @param <Array>  $additional - array with additional info
 *   - name = force name for filter (label)
 *   - subtype = subtype for filter (not implemented yet)
 */
function filter_available_from_field($field_name, $additional=array()){
    global $admin;
    $field = array_key_exists($field_name, $admin->fields) ? $admin->fields[$field_name] : false;
    if (!$field || !$field['field']) return; //field not exists or field is empty
    
    $filter_name  = !empty($additional['name']) ? $additional['name'] : $field['name'];
    $filter_field = $field['field'];
    $filter_table = $admin->current['table'];
    
    $filter_subtype = !empty($additional['subtype']) ? $additional['subtype'] : '';
    
    $type = $field['type'];
    
    if (in_array($type, array('text', 'text_fck', 'image', 'file', 'user_text')))
        return; //we cant do filter from this data
    
    if ($type == 'string'){
        //select distinc values
        $admin->filter->AddAvailable($filter_name, $filter_field, "list", "SELECT DISTINCT `{$filter_field}` FROM `{$filter_table}` WHERE 1", $filter_field, '{{'.$filter_field.'}}');
        return;
    }
    
    if ($type == 'integer' || $type == 'float'){
        if (!$filter_subtype)
            return $admin->filter->AddAvailable($filter_name, $filter_field, "list", "SELECT DISTINCT `{$filter_field}` FROM `{$filter_table}` WHERE 1", $filter_field, '{{'.$filter_field.'}}');
    }
    
    if ($type == 'date'){ 
        //not implemented yet
        return; 
    }
    
    if ($type == 'enum'){
        return $admin->filter->AddAvailable($filter_name, $filter_field, "list_enum", "", $field['values'], '{{value}}');
    }
    
    if ($type == 'ForeignKey'){
        //only for simple "value"
        $value = trim($field['values']['value'], "{ }");
        return $admin->filter->AddAvailable($filter_name, $filter_field, "list", $admin->filter->createText($field['values']['opt_query'], $field['values']), $value, $field['values']['text']);
    }
    if ($type == 'ManyToMany'){
        $f_field = $field['values']['rel_table'].'.'.$field['values']['other_id'];
        $f_value = trim($field['values']['value'], "{ }");
        $f_add_w = sprintf(" %s.%s=%s.%s AND ", $field['values']['rel_table'], $field['values']['this_id'], $admin->current['table'], $admin->current['main_fld']);
        
        return $admin->filter->AddAvailable($filter_name, $f_field, "list",
                                            $admin->filter->createText($field['values']['opt_query'], $field['values']), $f_value, $field['values']['text'], 100,
                                            "", $f_add_w, $field['values']['rel_table'], true);
    }
    if ($type == 'link'){
        //not tested yet
        $f_value = trim($field['values']['value'], '{ }');
        return $admin->filter->AddAvailable($filter_name, $f_field, "list", $admin->filter->createText($field['values']['opt_query'], $field['values']), $f_value, $field['values']['text']);
    }
    
    return;
}


/**
 * Replace data from DB with label from values of admin-field
 */
function filter_field_boolean($row, $field){
    global $admin;

    $values = $admin->fields[$field['value']]['values'];
    $val    = $row[$field['value']];
    return array_key_exists($val, $values) ? $values[$val] : "#not found#";
}

/**
 * Create data for foreign key field
 */
function filter_field_foreign_key($row, $field){
    global $admin;
    static $data = array();
    $fname       = $field['value'];
    $val         = $row[$field['value']];
    $admin_field = array_key_exists($fname, $admin->fields) ? $admin->fields[$fname] : false;
    $table       = $admin_field['values']['other_table'];
    
    if (!$admin_field) return '#error#';
    
    if (empty($data[$fname])){
        $data[$fname] = array();
        $rows = $admin->mngrDB->mysqlGet($admin->filter->createText($admin_field['values']['opt_query'], $admin_field['values']));
        foreach($rows as $r)
            $data[$fname][$admin->filter->createText($admin_field['values']['value'], $r)] = $admin->filter->createText($admin_field['values']['text'],  $r);
    }
    
    return array_key_exists($val, $data[$fname]) ? $data[$fname][$val] : '#not found#';
}

/**
 * Create filter field for images field
 */
function filter_field_image($row, $field){
    global $admin;
    
    $val         = $row[$field['value']];
    $admin_field = array_key_exists($field['value'], $admin->fields) ? $admin->fields[$field['value']] : false;
    
    $thumb_size  = ' width: 100px; ';
    
    if ($admin_field['type'] == 'image'){
        $thumb_size  = !empty($admin_field['values']['thumb_size'])  ? $admin_field['values']['thumb_size']  : ' width: 100px; ';
    }
    
    if (empty($val)) return "#Не установлено#";
    if (!file_exists($_SERVER['DOCUMENT_ROOT'].$val)) return "#Не найдено!#";
    
    return sprintf('<img src="%s" style=" %s " />', $val, $thumb_size);
}

/**
 * Check is field exists and create it if not.
 *
 * @param <String> $table - name of table ato alter
 * @param <String> $field - name of field
 * @param <String> $field_param_query - field params in SQL like "VARCHAR( 255 ) NOT NULL"
 */
function db_field_check_and_create($table, $field, $field_param_query='VARCHAR( 255 ) NOT NULL'){
    global $admin;
    if (!$table) $table = $admin->current['table'];
    if (!$admin->mngrDB->mysqlIsHaveField($table, $field)){
        mysql_query("ALTER TABLE  `{$table}` ADD  `{$field}` {$field_param_query}", $admin->mngrDB->dbConn);
    }
}