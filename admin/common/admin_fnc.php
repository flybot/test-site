<?php
/* ! --       02.09.2011 shevayura       -- !
 *
 * Базовый файл для административного интерфейса
 *
 */

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/admin_main.php");
require_once($_SERVER['DOCUMENT_ROOT']."/admin/common/filter.php");

class MyMegaFilter extends MegaFilter{

}

class MAdmin extends SAdmin{
    /*
     * Менять только здесь
     * Основной класс не менять, чтобы была возможность бытрого обновления.
     * аминь
     *
     */
}

$filter = new MyMegaFilter($mngrDB);
$admin = new MAdmin($mngrDB, $filter);
$admin->path_to_admin = '/admin';

require_once $_SERVER['DOCUMENT_ROOT'].$admin->path_to_admin.'/common/h2o/h2o.php';



/* Init rights */
$admin->rightsInit(
        array(
            array('admins',   SAdminRights::$WRITE),
            array('superHR',  SAdminRights::$NONE),
            array('HR',       SAdminRights::$NONE),
));

