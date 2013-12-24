<?php
/* ! --       25.08.2011 shevayura / mod by zolotaryov      -- !
 *
 * Базовый файл для административного интерфейса
 *
 */

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/admin_main.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/filter.php");

class MyMegaFilter extends MegaFilter{
}

class MAdmin extends SAdmin{}
$filter = new MyMegaFilter($mngrDB);
$admin = new MAdmin($mngrDB, $filter);
$admin->path_to_admin = '/admin';

require_once $_SERVER['DOCUMENT_ROOT'].$admin->path_to_admin.'/common/h2o/h2o.php';

?>