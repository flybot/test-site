<?php
/*
 * Создание сайдбара
 */
function sidebar_data() {
	global $main_context, $mngrDB;
	$data = array();
	//акция
	$row = $mngrDB->mysqlGetOne("SELECT * FROM actions WHERE `visible` = 1 AND date_end >= NOW() ORDER BY id");
	if($row){
		$data['action'] = $row;
	}
	//список инструкторов
	$rows = $mngrDB->mysqlGet("SELECT * FROM trainers WHERE `show_on_main_page` = 1 ORDER BY `priority` ASC");
	$data['trainers'] = (count($rows))? $rows : array();
	//
	return $data;
}

function error404() {
	global $main_context;
	ob_start();
	include $main_context['base_path'] . '/templates/404.php';
	$main_context['content'] = ob_get_clean();
}

function generateCode($len=6, $spaces=false) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    if ($spaces)
        $chars .= '        ';
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $len) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

/*
 * Загрузка меню
 */
function menu_load(){
    global $main_context, $mngrDB;
    $main_context['main_menu'] = array();
    $columns   = array();

    $menus = $mngrDB->mysqlGet("SELECT menu.* FROM `menu`, `modules`
                                 WHERE ((modules.id=menu.module_id AND modules.active=1) or menu.module_id=0)
                                 GROUP BY menu.id ORDER BY menu.priority");
    $main_context['main_menu'] = _menu_load_deep(0, $menus, $columns);
}

function _menu_load_deep($parent, &$menus, &$columns){
    global $main_context;
    $ret = array();
    foreach($menus as $m){
        if ($m['parent_id'] != $parent) continue;
        $loader = hash_loader(array( "menu_url.html" => $m['url']));
        $menu_h2o = new H2o('menu_url.html', array('loader' => $loader));
        $m['url'] = $menu_h2o->render($main_context);
        foreach($columns as $col)
            $m[$col] = _menu_load_ml($m['id'], $col);
        $c = _menu_load_deep($m['id'], $menus, $columns);
        if ($c) $m['childs'] = $c;
        $ret[] = $m;
    }
    return $ret;
}

function _menu_load_ml($id, $column){
    $current = array();
    foreach($lang_data as $data){
        if ($data['menu_id'] != $id) continue;
        if ($data['fname'] != $column) continue;

        $current[$data['lang']] = $data;
    }

    if (!$current)
        return '';

    //search current lang
    if (!empty($current[$_i18n_current]['value']))
        return $current[$_i18n_current]['value'];

    //search default
    if (!empty($current[$_i18n_default]['value']))
        return $current[$_i18n_default]['value'];

    $ck = array_keys($current);
    return $current[$ck[0]]['value'];
}

/*
 * Добавление элемента в хлебные крошки
 */
function add_path($name, $url){
    global $main_context;
    $main_context['xpath'][] =array('name'=>$name, 'path'=>$url);
}

/*
 * Выбор пункта меню используя его имя (name)
 */
function menu_select_byname($name){
    _menu_select('name', $name);
}

/*
 * Выбор пукнта меню с заданным url
 */
function _menu_select_rtrim($str){ return rtrim($str, '/ '); }
function menu_select_byurl($url){
    $x = false;
    _menu_select('url', rtrim($url, '/ '), $x, '_menu_select_rtrim');
}

function _menu_select($col, $value, &$menu_level=false, $usr_fnc=''){
    global $main_context;
    if ($menu_level === false)
        $menu_level = &$main_context['main_menu'];

    foreach($menu_level as &$menu){
        if (!empty($menu['childs']) && _menu_select($col, $value, $menu['childs'])){
            $menu['child_selected'] = 1;
            return true;
        }
        if (array_key_exists($col, $menu) && ($menu[$col] == $value || (function_exists($usr_fnc) && call_user_func($usr_fnc, $menu[$col]) == $value))){
            $menu['selected'] = 1;
            return true;
        }
    }
    return false;
}
/*
 * Автоматическое выделение пунктов меню по их url
 */
function menu_autoselect(){
    menu_select_byurl($_SERVER['REQUEST_URI']);
}

/*
 * Безопасное добавление данных в основной контекстный словарь
 *
 * Безопасное в смысле с проверкой на наличие ключа
 *   и конкатениции данных вместо перезаписывания.
 */
function main_context_add($key, $data, $rewrite=false){
    global $main_context;
    if (!array_key_exists($key, $main_context) || $rewrite){
        $main_context[$key] = $data;
        return;
    }
    $main_context[$key] .= $data;
}
//end main_context_add

//предзагрузка модулей
/*$onload_mods_result = $modules;
foreach ($onload_mods_result as $onload_mod){
    if ( file_exists($_SERVER['DOCUMENT_ROOT'].'/modules/'.$onload_mod['dir'].'/onload.php') ){
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/'.$onload_mod['dir'].'/onload.php';
    }
}*/


//Простой комментарий для демонстрации множественных изменений.
//qweqwe
?>