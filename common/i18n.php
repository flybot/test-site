<?php
/*
 * init of multilanguage engine
 */

H2o::addFilter("i18n", "i18n_get_value");
H2o::addFilter("i18n_link", "i18n_replace_link");
H2o::addFilter("i18n_decl", "i18n_decl");

$_i18n_dict    = array();
$_i18n_langs   = $mngrDB->mysqlGet("SELECT * FROM i18n_langs WHERE `active`=1 ORDER BY priority", null, 'abbr');
$_i18n_current = '';
$_i18n_load    = i18n_get_config("get_method", "query");
$_i18n_default = i18n_get_default_lang();
$_i18n_all     = $mngrDB->mysqlGet("SELECT * FROM i18n_langs WHERE 1", null, 'abbr');


/*
 * debug mode init!
 */
$_i18n_DEBUG   = TRUE;

if ($_i18n_DEBUG)
    mysql_query("CREATE TABLE IF NOT EXISTS `i18n_debug` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `key` varchar(255) NOT NULL,
                  `url` varchar(255) NOT NULL,
                  `trace` text NOT NULL,
                  `server` text NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;", $mngrDB->dbConn);
// end debug init


if (empty($i18n_skip_initialization)){
    /*
     * Initialize i18n for site engine
     */
    i18n_parse_lang();
    i18n_proc_links();
    i18n_fill_context();
}

function i18n_saved_lang(){
    global $_i18n_langs, $_i18n_default;
    $now = !empty($_COOKIE['xlang']) ? $_COOKIE['xlang'] : '';
    $now = array_key_exists($now, $_i18n_langs) ? $now : $_i18n_default;
    return $now;
}

function i18n_new_lang($now){
    global $_i18n_default, $_i18n_langs;
    if (!isset($_GET['xlang'])){
        //query without params
        $new = $now ? $now : $_i18n_default;
        i18n_set_lang($new);
        header("Location: /$new".$_SERVER['REQUEST_URI']);
        exit;
    }

    $new = $_GET['xlang'];
    if (!array_key_exists($new, $_i18n_langs)){
        //this is not language
        $new = $now ? $now : $_i18n_default;
        header("Location: /$new".$_SERVER['REQUEST_URI']);
        exit;
    }
    return $new;
}

function i18n_parse_lang(){
    global $_i18n_langs, $_i18n_current;

    $now = i18n_saved_lang();
    $new = i18n_new_lang($now);
    
    if ($new != $now){
        //set new lang
        i18n_set_lang($new);
        $now = $new;
    }


    if (!$now){
        i18n_set_lang(i18n_get_default_lang());
    }
    $_i18n_current = $now;
}

function i18n_set_lang($abbr){
    setcookie('xlang', $abbr, time()+3600*24*365, '/', null, null, null);
}

function i18n_get_default_lang(){
    global $_i18n_langs;
    $def = i18n_get_config('def_lang', false);
    if (!$def)
        $def = $_i18n_langs[0]['abbr'];
    return $def;
}

function i18n_get_config($value, $default=false){
    global $mngrDB;
    $value = mysql_real_escape_string($value);
    $data  = $mngrDB->mysqlGetOne("SELECT `value` FROM i18n_config WHERE `name`='$value' LIMIT 1", null);
    return $data ? $data['value'] : $default;
}

function i18n_get_value($key){
    global $mngrDB, $_i18n_dict, $_i18n_load, $_i18n_current, $_i18n_DEBUG;
    $_i18n_current = mysql_real_escape_string($_i18n_current);
    if (!$_i18n_dict){
        //load dict
        $load_type = i18n_get_config("get_method", "query");
        if ($_i18n_load == "full"){
            $_i18n_dict = $mngrDB->mysqlGet("SELECT `keys`.*,
                    (SELECT `vals`.`value` FROM i18n_values as `vals` WHERE `vals`.`lang`='$_i18n_current' AND `vals`.`key_id`=`keys`.`id` LIMIT 1) as `value`
                    FROM i18n_keys as `keys` WHERE 1", null, 'key');

        }
    }
    if (!array_key_exists($key, $_i18n_dict)){
        //this key not exists in array
        if ($_i18n_load == 'full')
            return '';
        $key_query = mysql_real_escape_string($key);
        $tmp_value = $mngrDB->mysqlGetOne("SELECT `keys`.*,
                (SELECT `vals`.`value` FROM i18n_values as `vals` WHERE `vals`.`lang`='$_i18n_current' AND `vals`.`key_id`=`keys`.`id` LIMIT 1) as `value`
                FROM i18n_keys as `keys` WHERE `keys`.`key`='$key_query' ");

        if (!$tmp_value){
            if ($_i18n_DEBUG){
                //DEBUG MODE
                try{
                    $key_safe = mysql_real_escape_string($key);
                    $bt_lines = array();
                    foreach(array_slice(debug_backtrace(), 1) as $bt_stage)
                        $bt_lines[] = sprintf("%s [%s]", $bt_stage['file'], $bt_stage['line']);
                    $bt_lines = join(" => ", $bt_lines);
                    if (!$mngrDB->mysqlGetCount("i18n_debug", " `key`='$key_safe' "))
                        $mngrDB->mysqlInsertArray('i18n_debug', 
                                array('key'=>$key, 'trace'=>$bt_lines, 'url'=>$_SERVER['REQUEST_URI'], 'server'=>serialize($_SERVER)), 1);

                }catch(Exception $ex){
                    ;
                }
                return "##$key";
                //END DEBUG
            }
            else {
                return '';
            }
        }

        $_i18n_dict[$tmp_value['key']] = $tmp_value;
    }

    if (!array_key_exists($key, $_i18n_dict)){
        return '';
    }
    return !empty($_i18n_dict[$key]['value']) ? $_i18n_dict[$key]['value'] : $_i18n_dict[$key]['default'];
}

function i18n_get_lang(){
    global $_i18n_current;
    return $_i18n_current;
}

function i18n_fill_context(){
    global $main_context, $_i18n_current, $_i18n_langs, $_i18n_load;
    $main_context['i18n'] = array();
    $main_context['i18n']['lang']  = $_i18n_current;
    $main_context['i18n']['full']  = $_i18n_langs[$_i18n_current];
    $main_context['i18n']['block'] = i18n_get_config('lang_block', 0);
    $main_context['i18n']['all']   = $_i18n_langs;
    $main_context['i18n']['mode']  = $_i18n_load;
}

function i18n_replace_link($link=null, $lang=''){
    global $_i18n_current;
    if ($link === null)
        $link = $_SERVER['REQUEST_URI'];
    if (!$lang)
        $lang = i18n_get_default_lang();

    if ($_i18n_current == $lang)
        return $link;

    $link = str_ireplace("/$_i18n_current/", "/$lang/", $link);
    $link = str_ireplace("xlang=$_i18n_current", "xlang=$lang", $link);

    return $link;
}

function i18n_proc_links(){
    global $_i18n_langs;
    foreach($_i18n_langs as $key=>$value){
        $_i18n_langs[$key]['full_link'] = i18n_replace_link($_SERVER['REQUEST_URI'], $value['abbr']);
    }
}

/*
 * load i18n data from `i18n_base`
 * where
 * $tname = value in i18n_base.tname (this is name of table for this entity)
 * $row_id = value in i18n_base.row_id (this is main entity id)
 * $empty = (boolean) return empty data and dont replace empty
 *          values with values from other language
 * $_ = fields. multiple variables (not array) like
 *
 * example
 * $data = i18n_load_base("guna_pharm_pharmacy", 10, true, "name", "desc", "additional", "phone");
 *
 * return: assoc array with key=field_name and value=translated_data
 */

function i18n_load_base($tname, $row_id, $empty, $_){
    global $_i18n_current;
    $fgargs = func_get_args();
    $args = array_merge(array($_i18n_current), $fgargs);
    return call_user_func_array("i18n_load_base_bylang", $args);
}
function i18n_load_base_bylang($lang, $tname, $row_id, $empty, $_){
    global $mngrDB, $_i18n_langs, $_i18n_current, $_i18n_default;
    if (empty($lang)) $lang = $_i18n_default;
    if (!array_key_exists($lang, $_i18n_langs))
        return array(); //bad lang
    if (func_num_args() < 4)
        return array();
    $fields = func_get_args();
    $fields = array_slice($fields, 3);
    $fields = array_map('mysql_real_escape_string', $fields);
    if (!$fields)
        return array();

    $fieldsq = "'".join("', '", $fields)."'";
    $tname   = mysql_real_escape_string($tname);
    $row_id  = mysql_real_escape_string($row_id);
    $query   = "SELECT * FROM `i18n_base` WHERE `tname`='$tname' AND `row_id`=$row_id AND `fname` IN ($fieldsq)";

    $data = $mngrDB->mysqlGet($query);

    $ret = array();

    foreach($fields as $field){
        $ret[$field] = '';
        //get for current lang
        foreach($data as $dat){
            if ($dat['fname'] == $field && $dat['lang']  == $lang)
                $ret[$field] = $dat['value'];
        }

        if (!$empty && empty($ret[$field])){
            //get for default
            foreach($data as $dat){
                if ($dat['fname'] == $field && $dat['lang']  == $_i18n_default)
                    $ret[$field] = $dat['value'];
            }
        }

        if (!$empty && empty($ret[$field])){
            //get for default
            foreach($data as $dat){
                if ($dat['fname'] == $field && !empty($dat['value']))
                    $ret[$field] = $dat['value'];
            }
        }

    }
    return $ret;

}

function i18n_decl($key, $count, $params='ru:,а,ов;en:e,es,es'){
    global $_i18n_langs;
    $value = i18n_get_value($key);
    if (!$value) return $value;
    //parse params
    $config = array();
    foreach(explode(";", $params) as $param){
        $list = explode(':', $param);
        if (count($list) != 2) continue;
        $lang = $list[0];
        if (!array_key_exists($lang, $_i18n_langs)) continue; //bad language abbr
        $values = explode(',', $list[1]);
        if (count($values) != 3) continue;
        $arr = array();
        $arr['one']   = $values[0];
        $arr['two']   = $values[1];
        $arr['three'] = $values[2];
        $config[$lang] = $arr;
    }
    if (!array_key_exists(i18n_get_lang(), $config))
        return $value;

    if ($count%10 == 1 && $count != 11){
        return $value.$config[i18n_get_lang()]['one'];
    }
    if (in_array($count%10, array(2,3,4)) && ($count < 10 || $count > 20)){
        return $value.$config[i18n_get_lang()]['two'];
    }
    return $value.$config[i18n_get_lang()]['three'];
}
?>