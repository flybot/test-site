<?php
SAdminDebuger::logIt(NULL, "Call to afterfunc!");
if (empty($this->update)){
    exit();
}

$mngrDB = $this->admin->mngrDB;

SAdminDebuger::logIt($this->admin, "Updater: Start afterupdate action...");

function _upd_table_exists($table, $mngrDB){
    $table  = strtolower($table);
    foreach($mngrDB->mysqlGet("SHOW TABLES") as $row){
        if (count($row) == 1 && $table == strtolower(array_pop($row))) return true;
    }
    return false;
}

/*
 * User update [July 2013]
 */

//check is new table does not exists (adminusers and adminugroups)
if (!_upd_table_exists('adminugroups', $mngrDB)){
    SAdminDebuger::logIt($this->admin, "Updater: adminugroups");
    //create table
    mysql_query("CREATE TABLE IF NOT EXISTS `adminugroups` (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                `alias` VARCHAR( 255 ) NOT NULL ,
                `name` VARCHAR( 255 ) NOT NULL ,
                `comment` TEXT NOT NULL
                ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;", $this->admin->mngrDB->dbConn);
    //create default group for admins
    $this->admin->mngrDB->mysqlInsertArray('adminugroups', array('id'=>1, 'alias'=>'admins', 'name'=>'Administrators', 'comment'=>'...'), 1);
    //insert link into adminmenu
    //searh admins.php
    foreach($this->admin->mngrDB->mysqlGet("SELECT * FROM adminmenu WHERE 1") as $_upd_menu){
        if (strpos($_upd_menu['url'], '/common/admins.php') == false) continue; //this is not admins.php
        $this->admin->mngrDB->mysqlInsertArray('adminmenu', array(
            'parent'=>$_upd_menu['parent'], 
            'name'  =>'Группы адм.', 
            'descr' =>"Группы пользователей административного интерейса",
            'url'   =>  str_replace('admins.php', 'ugroups.php', $_upd_menu['url']),
            ), 1); //insert new item in same level as admins.php
        break; //its done
    }
}

if (!_upd_table_exists('adminusers', $mngrDB)){
    SAdminDebuger::logIt($this->admin, "Updater: adminusers");
    //create new table
    mysql_query("CREATE TABLE IF NOT EXISTS `adminusers` (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                `email` VARCHAR( 255 ) NOT NULL ,
                `group_id` INT NOT NULL
                ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;", $this->admin->mngrDB->dbConn);
    //copy old users data to new table
    foreach($this->admin->mngrDB->mysqlGet("SELECT * FROM `allow_users` WHERE 1") as $_upd_user){
        $this->admin->mngrDB->mysqlInsertArray('adminusers', array('id'=>$_upd_user['id'], 'email'=>$_upd_user['email'], 'group_id'=>1), 1);
    }
    //remove old tables (allow_users)
    mysql_query("DROP TABLE `allow_users` ", $this->admin->mngrDB->dbConn);
}

//check is new auth table does not exists (admin_auth)
if (!_upd_table_exists('adminauth', $mngrDB)){
    SAdminDebuger::logIt($this->admin, "Updater: adminauth");
    //create new table
    mysql_query("CREATE TABLE IF NOT EXISTS `adminauth` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `userid` int(11) NOT NULL,
                `hash` varchar(32) NOT NULL,
                `openid` varchar(255) NOT NULL,
                `expire` int(11) unsigned NOT NULL,
                `email` varchar(255) NOT NULL,
                `agent` varchar(255) NOT NULL,
                `ip` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;", $this->admin->mngrDB->dbConn);
    //copy old data to new table
    foreach($this->admin->mngrDB->mysqlGet("SELECT * FROM `open_id` WHERE 1") as $_upd_user){
        $this->admin->mngrDB->mysqlInsertArray('adminauth', $_upd_user, 1);
    }
    //drop old table (open_id)
    mysql_query("DROP TABLE `open_id` ", $this->admin->mngrDB->dbConn);
}

/*
 * END user update
 */