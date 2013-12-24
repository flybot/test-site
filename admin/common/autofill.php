<?php
/* ! --       08.08.2011 shevayura       -- !
 *
 * К этому файлу обращаются ява-скрипты для заполнения полей xselect
 */

    require_once("admin_fnc.php");

    //get the parameters from URL
    $q = trim( stripslashes($_REQUEST["q"]) );
    $q = mysql_real_escape_string($q);

    $table = mysql_real_escape_string($_REQUEST['table']);
    $field = mysql_real_escape_string($_REQUEST['field']);
    $fields = explode("|", $field);
    $value = mysql_real_escape_string($_REQUEST['value']);
    $image = mysql_real_escape_string($_REQUEST['image']);
    $name  = mysql_real_escape_string($_REQUEST['name']);
    $format= mysql_real_escape_string($_REQUEST['format']);

    $where = array();
    foreach($fields as $field){
        $where[] = " `$field` LIKE '%$q%' ";
    }
    $where = join(" OR ", $where);
    $query = "SELECT * FROM `$table` WHERE $where ORDER BY `id` DESC LIMIT 0 , 30";
    if ( strlen($q) < 4 )
        $query = "SELECT * FROM `$table` WHERE 1 ORDER BY `id` DESC LIMIT 0 , 30";

    $x = $admin->mngrDB->mysqlGet($query);

    $hint=array();

    foreach ($x as $k=>$v){
        $hvalue = addslashes($admin->filter->createText($format, $v));
        $img = "";
        if ($image){
            $img = '<a href="javascript: add(\'%s\', \'%s\', \'%s\');" ><img src="%s" style="height:50px;" /></a>';
            $img = sprintf($img, $name, $v[$value], $hvalue, $v[$image]);
        }
        $f = '<li>%s<a href="javascript: add(\'%s\', \'%s\', \'%s\');" >%s</a></li>';
        $hint[] = sprintf($f, $img, $name, $v[$value], $hvalue, $hvalue);
    }
    $hint = join("\n", $hint);


    // set output to "no suggestion" if no hint were found
    // or to the correct values
    if ( $hint == "" ){
        $response = "no suggestion";
    }
    else{
        $response = "<ul>" . $hint . "</ul>";
    }

    echo $response;
?>