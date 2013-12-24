<?php
/*
 *  !---- shevayura ----!
 *  Старайтесь не менять этот файл.
 *
 */

class MngrDB{
    # Class for easy acess to db
    # made by me (shevayura)
    private $hostname = "";
    private $username = "";
    private $password = "";
    private $dbName   = "";
    public  $dbConn;

    function  __construct($hostname=null, $username=null, $password=null, $dbname=null) {
        if ($hostname !== null) $this->hostname = $hostname;
        if ($username !== null) $this->username = $username;
        if ($password !== null) $this->password = $password;
        if (  $dbname !== null)   $this->dbName = $dbname;

        $this->dbConn = mysql_connect($this->hostname, $this->username, $this->password)
                or die("Не могу создать соединение c базой данных!");
        mysql_select_db($this->dbName, $this->dbConn) or die(mysql_error());
        mysql_query("SET NAMES 'utf8'", $this->dbConn);
        mysql_query("SET collation_connection = 'UTF-8_general_ci'", $this->dbConn);
        mysql_query("SET collation_server = 'UTF-8_general_ci'", $this->dbConn);
        mysql_query("SET character_set_client = 'UTF-8'", $this->dbConn);
        mysql_query("SET character_set_connection = 'UTF-8'", $this->dbConn);
        mysql_query("SET character_set_results = 'UTF-8'", $this->dbConn);
        mysql_query("SET character_set_server = 'UTF-8'", $this->dbConn);
    }

    public function mysqlGet($query, $db=null, $key=false){
        if (!$db) $db = $this->dbConn;
        $result = mysql_query($query, $db);
        if (!$result) return array();
        for ( $data=array(); $row=mysql_fetch_assoc($result); $key!==false && array_key_exists($key, $row) ? $data[$row[$key]]=$row : $data[]=$row);
        return $data;
    }

    public function mysqlGetOne($query, $db=null){
        if (!$db) $db = $this->dbConn;
        $result = mysql_query($query, $db);
        if (!$result) return array();
        $row = mysql_fetch_assoc($result);
        return $row ? $row : array();
    }

    public function mysqlGetKV($query, $key, $value, $db=null){
        if (!$db) $db = $this->dbConn;
        $result = mysql_query($query, $db);
        if (!$result) return array();
        for ( $data=array(); $row=mysql_fetch_assoc($result); $data[$row[$key]]=$row[$value] );
        return $data;
    }

    public final function mysqlGetCount($table, $where=1, $db=null){
        #not safe!
        if (!$db) $db=$this->dbConn;
        $table = mysql_real_escape_string($table);
        $query = "SELECT COUNT(*) as 'rows' FROM `$table` WHERE $where";
        $result = mysql_query($query);
        @$result = mysql_fetch_assoc($result);
        return (int)$result['rows'];
    }

    public function mysqlListFields($table){
        $res = $this->mysqlGet("SHOW COLUMNS FROM `$table`");
        $data = array();
        foreach($res as $field)
            $data[] = strtolower($field['Field']);
        return $data;
    }
    
    public function mysqlListTables($strtolower=false){
        $tables = array();
        foreach($this->mysqlGet("SHOW TABLES") as $row){
            if (count($row) != 1) continue;
            $tables[] = $strtolower ? strtolower(array_pop($row)) : array_pop($row);
        }
        
        return $tables;
    }
    
    public function mysqlIsTableExists($table){
        return in_array($table, $this->mysqlListTables(1));
    }
    
    public function mysqlIsHaveField($table, $field){
        return in_array(strtolower($field), $this->mysqlListFields($table));
    }
    public function mysqlInsertArray($table, $array, $skipSpecCh=0, $db=null, $skipEscape=0){
        if (!$db) $db = $this->dbConn;
        if (get_magic_quotes_gpc())
            $array  = array_map( 'stripslashes',        $array );
        if ( !$skipSpecCh ){
            $array  = array_map( 'stripslashes',     $array );
            $array  = array_map( 'htmlspecialchars', $array );
        }
        if ( !$skipEscape ){
            $array  = array_map( 'mysql_real_escape_string', $array );
        }

        $names  = '`'.join("`, `", array_keys($array)).'`';
        $values = "'" . join("', '", array_values($array)) . "'";
        $query = "INSERT INTO $table ($names) VALUES ($values)";
        mysql_query($query, $db);
    }

    public function mysqlUpdateArray( $table, $set, $where, $skipSpecCh=0, $db=null, $skipEscape=0 ){
        if (!$db) $db = $this->dbConn;
        if (get_magic_quotes_gpc())
            $set  = array_map( 'stripslashes',        $set );
        if ( !$skipSpecCh ){
            $set  = array_map( 'stripslashes',     $set );
            $set  = array_map( 'htmlspecialchars', $set );
        }
        if ( !$skipEscape ){                
            $set  = array_map( 'mysql_real_escape_string', $set );
        }

        foreach ( $set as $k=>$v ){
            $k = mysql_real_escape_string($k);
            $set[$k] = "`$k`='$v'";
        }

        $set = join(", ", $set);

        $query = "UPDATE `$table` SET $set WHERE $where";
        mysql_query($query, $db);
        #echo "$query<br>\n";
        #echo mysql_error($db)."<br>\n";
    }
}



$mngrDB = new MngrDB($dbhost, $dbuser, $dbpasswd, $dbname);

class SAdmin{
    public  $path_to_admin = '/admin';   //path to admin folder (from DOCUMENT_ROOT)
    public  $mngrDB;                     //MngrDB instance
    public  $host = '';
    public  $userclass = 'SAdminUser';   //classname for users
    public  $user      = null;           //current user (admin)
    public  $authtable = 'adminauth';    //table with sessions info store
    public  $rights_cl = 'SAdminRights'; //classname for rights 
    public  $rights    = null;           //rights instance
    public  $adminID   = null;           //(deprecated) ID of current user
    public  $adminData = null;           //(deprecated) data array for current user
    public  $filter    = null;           //main filter instance
    public  $current   = null;           //data about current table
    public  $fields    = array();        //fields info
    public  $row       = null;           //current saved row (for edit actions)
    public  $history_last_id = 0;        //last id of stored history data
    public  $history_name = '';          //fieldname for history trash identification
    public  $history_allow_revert = true;//is enabled undo action from history
    public  $filter_query = '';          //query for main filter instance
    public  $filter_query_lite  = '';    //query (lite version) for main filter instance
    public  $filter_query_count = '';    //query (count version) for main filter instance
    public  $old_values = array();
    protected $xjava_added = false;
    public  $wysiwyg_css = array();      //css for connect in CKEditor
    public  $menu_bind = 0;
    public  $time_started_gen = 0;
    public  $current_action = '';
    protected $history_timestamp = 0;
    public  $base_context = array();
    
    public $actiontype   = 0;
    public $ACTION_READ  = 1;
    public $ACTION_WRITE = 2;
    

    public  $favicon = '';

    public  $templates = array(
        'add' =>"/common/templates/add.html",
        'edit'=>"/common/templates/edit.html",
    );
    
    protected $morphy           = array(); //search morphology engine
    protected $search_available = false;   //flag is search available and initialized
    protected $search_fields    = array(); //fields in DB for search data
    protected $search_fields_ex = array();
    protected $search_results   = array(); //results of current search
    protected $search_init      = false;
    
    public    $search_use_root  = true;
    public    $search_use_db    = false;

    function  __construct($mngrDB, $filter=null) {

        $this->time_started_gen = microtime(true);

        /*clear request from cookies*/
        foreach($_COOKIE as $cook=>$val){
            unset($_REQUEST[$cook]);
            if (isset($_GET[$cook]))  $_REQUEST[$cook] = $_GET[$cook];
            if (isset($_POST[$cook])) $_REQUEST[$cook] = $_POST[$cook];
        }
        /*clear request from cookies*/
        
        $this->mngrDB = $mngrDB;
        $this->host   = $_SERVER['HTTP_HOST'];
        $this->filter = $filter!==null ? $filter : new MegaFilter($this->mngrDB);
        global $admin_favicon;
        if (isset($admin_favicon)) $this->favicon = $admin_favicon;
        $this->CheckAdmin();
    }

    function calcGenTime(){
        $delta = microtime(true) - $this->time_started_gen;
        return round($delta, 3);
    }

    public function createContext(&$context){
        if (!isset($context) || !is_array($context))
            $context = array();
        //fill context
        $context['base_context'] = &$this->base_context;
        $context['menu']         = $this->Menu();
        $context['admin_path']   = $this->path_to_admin;
        $context['gentime']      = $this->calcGenTime();
        $context['self_url']     = $_SERVER['PHP_SELF'];
        $context['current']      = $this->current;

        $context['from_url'] = isset($_REQUEST['fromurl']) ? $_REQUEST['fromurl'] : '';
        
        if (isset($_REQUEST['id'])){
            $context['id'] = (int)$_REQUEST['id'];
        }
        $context['adminaction'] = $this->current_action;
        $context['favicon']     = $this->favicon ? $this->favicon : rtrim($this->path_to_admin, '/ ').'/common/templates/favicon.ico';
        return $context;
    }

    public function FillTemplate($template, $context=array()){
        @$h2o = new H2O($template);
        return @$h2o->render($context);
    }

    public function getOutFromHere($loc = "/"){
        if ($loc == "#xclose#"){
            echo "<script>window.close();</script>";
            exit();
        }
        header("Location: $loc");
        exit();
    }

    public function AdminGetLogin(){
        return $adminData ? $adminData['username'] : '';
    }

    public function AdminGetEmail(){
        return $adminData ? $adminData['email'] : '';
    }


    function isAuth(){
        if( !isset($_COOKIE['xhash']) ){
            return False;
        }
        $hash = mysql_real_escape_string($_COOKIE['xhash']);
        $res = $this->mngrDB->mysqlGet("SELECT * FROM `{$this->authtable}` WHERE hash='$hash'");
        if ( count($res) != 1 ){
            mysql_query("DELETE FROM `{$this->authtable}` WHERE hash='$hash'", $this->mngrDB->dbConn);
            setcookie ("xhash", "", time() - 3600);
            return False;
        }
        $res = $res[0];
        if ( $res['ip'] != $_SERVER['REMOTE_ADDR'] )
            return False;
        if( $res['agent'] != $_SERVER['HTTP_USER_AGENT'])
            return False;
        if ( (int)$res['expire'] < time() ){
            mysql_query("DELETE FROM `{$this->authtable}` WHERE hash='$hash'", $this->mngrDB->dbConn);
            setcookie ("xhash", "", time() - 3600);
            return False;
        }
        
        $user  = $this->createUser($res['userid']);
        if ($user && $user->isValid()){
            $this->user      = $user;
            $this->adminID   = $user->getId();
            $this->adminData = $user->getDataAll();
            return $user->getEmail();
        }
        echo "O_o";
        return False;
    }
    
    protected function userGetInstance($mngrdb_instance=null){
        if (is_null($mngrdb_instance))
            $mngrdb_instance = $this->mngrDB;
        $refl = new ReflectionClass($this->userclass);
        $classname = $refl->isSubclassOf('SAdminUser') ? $this->userclass : 'SAdminUser';
        $instance  = new $classname($mngrdb_instance);
        
        return $instance;
    }
    
    public function createUser($user_id){
        $user = $this->userGetInstance();
        $user->load($user_id);
        
        if (!$user->isValid()) return null;
        
        return $user;
    }
    
    public function createUserByEmail($user_email){
        $user = $this->userGetInstance();
        $user->loadByEmail($user_email);
        
        if (!$user->isValid()) return null;
        
        return $user;
    }
    
    /**
     * Initialize internal rights system
     * @param <Array> $map - array for autoset using setRightsMap($map) of new object
     * @param <String> $classname - custom classname (must be subclass of SAdminRights)
     * @return <SAdminRights> initialized object (Stored in $admin->rights)
     */
    public function rightsInit($map=array(), $classname=''){
        if (!$classname){
            $classname = $this->rights_cl;
        }
        
        $refl = new ReflectionClass($classname);
        if (!$refl->isSubclassOf('SAdminRights')){
            $classname = 'SAdminRights';
        }
        
        $this->rights = new $classname();
        
        if ($map) $this->rights->setRightsMap($map);
        
        return $this->rights;
    }
    
    public function rightsIsInit(){
        return !is_null($this->rights) && $this->rights instanceof SAdminRights;
    }
    
    public function rightsCheck($actiontype, SAdminUser $user = null, SAdminRights $rights = null){
        if (is_null($user)) $user = $this->user;
        if (is_null($rights)){
            if ($this->rightsIsInit()) $rights = $this->rights;
            else return true; //rights is not init
        }
        
        $group_alias = $user->getGroupAlias();
        if ($actiontype === $this->ACTION_READ  && $rights->isCanRead($group_alias))  return true;
        if ($actiontype === $this->ACTION_WRITE && $rights->isCanWrite($group_alias)) return true;
        
        return false;
    }
    
    public function rightsCheckAction($actiontype=null){
        if (is_null($actiontype)) $actiontype = $this->actiontype;
        if (!in_array($this->actiontype, array($this->ACTION_READ, $this->ACTION_WRITE)))
            $actiontype = $this->ACTION_READ;
        
        if ($this->rightsCheck($actiontype)) return;
        
        //draw error page
        echo sprintf("<h1>Access denied!</h1><br/><h3>You cannot %s this content! Contact with main administrator.</h3>", $this->actiontype == $this->ACTION_WRITE ? "modify" : 'view');
        exit(); //break script actions
    }

    function getCurrentAdminPath(){
        $trace = debug_backtrace();
        foreach($trace as $step){
            if (strpos($step['file'], 'common/admin_main.php') === false)
                continue;
            $full = rtrim(str_replace('common', '', dirname($step['file'])), '/ ');
            return rtrim('/'.trim(str_replace($_SERVER['DOCUMENT_ROOT'], '', $full), '/ '), '/ ');
        }
        return '/admin';
    }

    function loginForm(){
        $this->path_to_admin = $this->getCurrentAdminPath();
        require_once $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.'/common/h2o/h2o.php';
        $log_url = $_SERVER['REQUEST_URI'];
        $log_url .= strpos($log_url, '?') !== false ? '&login' : '?login';
        $context = array();
        $context['log_url']    = $log_url;
        $context['admin_path'] = $this->path_to_admin;
        $context['favicon']    = $this->favicon ? $this->favicon : rtrim($this->path_to_admin, '/ ').'/common/templates/favicon.ico';
        $template = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.'/common/templates/login.html';
        echo $this->FillTemplate($template, $context);
        exit();
    }

    function login(){
        require 'openid.php';
        $openid = new LightOpenID($this->host);
        $openid->required = array('contact/email');

            # Change 'localhost' to your domain name.
            if(!$openid->mode) {
                if(isset($_GET['login'])) {
                    $openid->identity = 'https://www.google.com/accounts/o8/id';
                    header('Location: ' . $openid->authUrl());
                }
                $this->loginForm();
                exit;

            } elseif($openid->mode == 'cancel') {
                echo 'User has canceled authentication!';
            } else {
                $val = $openid->validate();
                if (!$val || !isset($_GET['openid_ext1_value_contact_email']) || !isset($_GET['openid_sig']) ){
                    echo 'User is not logged in';
                    exit;
                }
                else{
                    $email = $_GET['openid_ext1_value_contact_email'];
                    $good  = $this->createUserByEmail($email);
                    if (!$good){
                        echo 'This email is not allowed';
                        exit;
                    }

                    $a = array();
                    $a['userid'] = $good->getId();
                    $a['hash']   = md5( htmlspecialchars_decode($_GET['openid_sig']));
                    $a['openid'] = htmlspecialchars_decode($_GET['openid_sig']);
                    $a['expire'] = time() + 60*60*24*365;
                    $a['email']  = $good->getEmail();
                    $a['agent']  = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
                    $a['ip']     = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
                    setcookie('xhash', $a['hash'], time()+3600*24*30, '/');
                    # remove old auth data
                    mysql_query("DELETE * FROM `{$this->authtable}` WHERE `expire` < '".time()."'", $this->mngrDB->dbConn);
                    $this->mngrDB->mysqlInsertArray($this->authtable, $a, 1, null, 1);
                    $log_url = $_GET['openid_return_to'];
                    $log_url = str_replace(array('&login', '?login'), array('',''), $log_url);
                    header('Location: '.$log_url);
                    exit;
                }
            }
    }

    public function logout(){
        if( !isset($_COOKIE['xhash']) ){
            $this->getOutFromHere($this->path_to_admin."/index.php");
        }
        $hash = mysql_real_escape_string($_COOKIE['xhash']);
        mysql_query("DELETE FROM `{$this->authtable}` WHERE hash='$hash'", $this->mngrDB->dbConn);
        mysql_query("DELETE FROM `{$this->authtable}` WHERE user_id='{$this->user->getId()}'", $this->mngrDB->dbConn);
        setcookie ("xhash", "", time() - 3600);
        $this->getOutFromHere($this->path_to_admin."/index.php");
    }


    public function CheckAdmin(){
        if ( !$this->isAuth() )
            $this->login();
    }

    public function DescribeTable($name, $table, $change, $delete, $add, $main_fld, $history=false, $after_func=array()){
        $current = Array();
        $current['name']       = $name;
        $current['query']      = $this->filter_query ? $this->filter_query : "SELECT * FROM `$table` WHERE `$main_fld` IS NOT NULL ";
        $current['table']      = $table;
        $current['change']     = $change;
        $current['delete']     = $delete;
        $current['add']        = $add;
        $current['main_fld']   = $main_fld;
        $current['history']    = $history;
        $current['after_func'] = $after_func;

        $this->current = $current;

        $this->filter->mainquery = $current['query'] ;
        $this->filter->litequery = $this->filter_query_lite;
        $this->filter->countquery= $this->filter_query_count;
    }

    public function DoAction(){

        if ( isset($_GET['type']) && $_GET['type'] == "xself" ){
            $this->current_action = "xself";
            $this->actiontype     = $this->ACTION_READ;
            $this->rightsCheckAction();
            $this->xself();
            exit();
        }
        if ( isset($_GET['type']) && $_GET['type'] == "showform" ){
            $this->current_action = "add";
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $adminaction = "add";
            $_REQUEST['adminaction'] = $_POST['adminaction'] = "add";
            $_REQUEST['fromurl']     = $_POST['fromurl'] = "#xclose#";
        }
        if ( isset($_GET['type']) && $_GET['type'] == "showedit" ){
            $this->current_action = "edit";
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $adminaction = "edit";
            $_REQUEST['adminaction'] = $_POST['adminaction'] = "edit";
            $_REQUEST['fromurl']     = $_POST['fromurl']     = "#xclose#";
            $_REQUEST['id']          = $_POST['id']          = $_GET['id'];
        }
        if ( isset($_REQUEST['adminupdown'])){
            $this->current_action = "adminupdown";
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $this->UpDown();
        }
        if (!isset($_POST) || !isset($_REQUEST['adminaction'])){
            $this->current_action = "list";
            $this->actiontype     = $this->ACTION_READ;
            $this->rightsCheckAction();
            $this->drawfilter();
            exit;
        }

        if ( $_REQUEST['adminaction'] == "add" ){
            $this->current_action = "add";
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $this->add();
            exit;
        }

        if ( $_REQUEST['adminaction'] == "delete" ){
            $this->current_action = "delete";
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $this->delete($_POST['id']);
            exit;
        }
        if ( $_REQUEST['adminaction'] == "edit" ){
            $this->current_action = "edit";
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $this->edit();
            exit;
        }
        if ( $_REQUEST['adminaction'] == 'history' ){
            $this->current_action = "history";
            $this->history();
            exit;
        }
    }
    
    /**
     * initialize search engine for current table
     * get lists of fields in argumets
     */
    public function search_init(){
        $this->morphy[] = new phpMorphy($_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.'/common/phpmorphy/dicts', 'en_EN', array('storage' => PHPMORPHY_STORAGE_FILE,) );
        $this->morphy[] = new phpMorphy($_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.'/common/phpmorphy/dicts', 'ru_RU', array('storage' => PHPMORPHY_STORAGE_FILE,) );
        $this->morphy[] = new phpMorphy($_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.'/common/phpmorphy/dicts', 'uk_UA', array('storage' => PHPMORPHY_STORAGE_FILE,) );
                
        
        $this->search_fields    = array();
        foreach (func_get_args() as $field){
            if (!is_array($field))
                $this->search_fields[] = $field;
            else 
                $this->search_fields = array_merge ($this->search_fields, $field);
        }
        
        $this->search_fields    = array_filter(array_unique($this->search_fields));
        $this->search_available = true;

    }
    
    protected function _search_init_fields(){
        if ($this->search_init) return;
        $available  = array();
        if ($this->search_use_db){
            //create available fields list from DB table
            foreach($this->mngrDB->mysqlGet("SHOW COLUMNS FROM `{$this->current['table']}`") as $fld)
                if (preg_match("{(varchar)|(text)}i", $fld['Type'])) $available[] = $fld['Field'];
        }
        else{
            //create available fields list from admin fields
            foreach($this->fields as $field){
                if (in_array($field['type'], array('string', 'text', 'text_fck'))) $available[] = $field['field'];
            }
        }
        
        $fields    = $this->search_fields;
        $fields_ex = array();
        
        if (!$fields)
            $fields = $available; //search in all available fields
        else
            foreach($fields as $key=>$value) if (!in_array($value, $available)) unset($fields[$key]); //check fields is exists
        
        if (!$this->search_use_db){
            //filter externals
            foreach($fields as $key=>$field){
                if (!$this->fields[$field]['externals']) continue;
                unset($fields[$key]);
                $fields_ex[] = $field;
            }
        }
        
        $this->search_fields    = $fields;
        $this->search_fields_ex = $fields_ex;
        if (!$fields && !$fields_ex) $this->search_available = false;
        $this->search_init = true;
    }
    
    protected function _search_create_part($word){
        $word  = mysql_real_escape_string($word);
        $parts = array(); 
        foreach($this->search_fields as $field){
            $parts[] = "`$field` LIKE '%$word%' ";
        }
        return '('.join('OR', $parts).')';
    }

    function search(){
        $this->_search_init_fields();
        if (!$this->search_available){
            echo "Search is not available for this page!";
            exit;
        }
        
        $text = !empty($_REQUEST['admin_search_text']) ? $_REQUEST['admin_search_text'] : '';
        $full = !empty($_REQUEST['admin_search_full']);
        $html = !empty($_REQUEST['admin_search_html']);
        
        $origin = $text;
        
        
        if (!trim($text)) 
            return; //no text to search
        
        
        $where = '';
        $words = array();
        if ($full){
            //search full exists in table
            $where   = ' AND '. $this->_search_create_part($text)." ";
            $words[] = $text;
        }
        else{
            //create words from text
            $text = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $text);
            $text = trim(preg_replace("/\s(\S{1,2})\s/", " ", ereg_replace(" +", "  "," $text ")));
            $text = ereg_replace(" +", " ", $text);
            
            $xwords = array_map("trim", array_filter(explode(" ", $text)));  
            if (!$xwords)
                return;
            
            $text   = array();
            foreach($xwords as $word){
                $word = mb_strtoupper($word, 'utf-8');
                $text[$word] = array();
                foreach($this->morphy as $morphy)
                    if (empty($text[$word])) $text[$word] = $this->search_use_root ? $morphy->getPseudoRoot($word) : $morphy->getAllForms($word);
                if (empty($text[$word])) $text[$word] = array($word,); //use original word if not data created by morph
            }
            
            $parts = array();
            foreach($text as $w_array){
                $pts = array();
                foreach($w_array as $word){
                    $words[] = $word;
                    $pts[]   = "    ".$this->_search_create_part ($word);
                }
                $parts[] = "  (\n".join(" OR \n", $pts)."\n  )";
            }
            
            $where = " AND \n( \n".join(" \n  OR \n", $parts)."\n) ";
        }
        
        if (!$where) $where = " AND 1 ";
        
        
        $fields = '`'.join("`, `", $this->search_fields).'`';
        $result = $this->mngrDB->mysqlGet("SELECT `{$this->current['main_fld']}`, $fields FROM `{$this->current['table']}` WHERE 1 $where", null, $this->current['main_fld']);
        
        if (!$html){
            //strip html tags
            foreach($result as $rkey=>$row)
                foreach($row as $fkey=>$field)
                    $result[$rkey][$fkey] = strip_tags($field);
        }
        
        //print_r($words);
        //print_r($result);
        $words = array_filter($words);
        $found = array();
        foreach($result as $id=>$row){
            foreach($row as $field=>$value){
                $fieldname = !$this->search_use_db && !empty($this->fields[$field]['name']) ? $this->fields[$field]['name'] : $field;
                foreach($words as $word){
                    $position = mb_stripos($value, $word, null, 'utf-8');
                    if ($position === false) continue;
                    if (!array_key_exists($id, $found)) $found[$id] = array();
                    
                    $found[$id][] = sprintf('Поле: %s, Позиция: %s<br/> Контекст: %s', $fieldname, $position, htmlspecialchars(mb_substr($value, $position-32, 64, 'utf-8')));//array('word'=>$word, 'pos'=>$position);
                }
            }
            //if (!empty($found[$id])) $found[$id] = join('<br/>...<br/>', $found[$id]);
        }
        
        foreach($this->search_fields_ex as $fexname){
            $this->_search_request_externals($words, $fexname, $html, $found);
        }
        
        //print_r($found);
        $ids = array_keys($found);
        
        $select_add = " AND `{$this->current['main_fld']}` IN ('".join("', '",$ids)."') ";
        //print_r($select_add);
        
        foreach($found as $key=>$value) $found[$key] = join("<br/>...<br/>", $value); 
        
        $this->search_results = array();
        $this->search_results['select']   = $select_add;
        $this->search_results['found']    = $found;
        $this->search_results['text']     = $origin;
        $this->search_results['full']     = $full;
        $this->search_results['html']     = $html;
        $this->search_results['main_fld'] = $this->current['main_fld'];
        
    }
    
    protected function _search_create_link(){
        $_params = explode("&", $_SERVER['QUERY_STRING']);
        $params = array();
        foreach($_params as $param){
            $param = explode("=", $param, 2);
            $key   = $param[0];
            $value = isset($param[1]) ? $param[1] : '';
            $params[$key] = $value;
        }
        
        
        if (isset($params['adminaction'])) unset($params['adminaction']);
        if (isset($params['admin_search_text'])) unset($params['admin_search_text']);
        if (isset($params['admin_search_full'])) unset($params['admin_search_full']);
        if (isset($params['admin_search_html'])) unset($params['admin_search_html']);
        
        foreach($params as $key=>$value) $params[$key] = $key.'='.$value;
        
        $params = join('&',$params);
        
        $link   = $_SERVER['SCRIPT_NAME'] . ( $params ? '?'.$params : '' );
        $link  .= mb_strpos($link, '?', 0, 'utf-8') === false ? '?' : '&';
        
        return $link;
    }
    
    protected function _search_request_externals($words, $field_name, $html, &$found){
        
        if ($this->search_use_db) return false; //because we cant redirect from db
        if (!array_key_exists($field_name, $this->fields)) return false;//field is not exists
        if (!$this->fields[$field_name]['externals']) return false;//this is not externals field
        
        //get field data
        $field     = $this->fields[$field_name];
        $ext_value = $field['externals']['value_field'];
        $fieldname = $field['name'];
        
        //get field externals request where
        $request_externals = $this->externals_get_where_search($field);
        
        //make request   
        $request = "SELECT * FROM `{$field['externals']['table']}` WHERE 1 ";
        $parts   = array();
        foreach($words as $word){
            $word = mysql_real_escape_string($word);
            $parts[] = "`$ext_value` LIKE '%$word%'";
        }
        $request .= $parts ? ' AND ('.join(" OR ", $parts).')' : '';
        $request .= $request_externals;
        
        
        $response = $this->mngrDB->mysqlGet($request);
        
        //prepare response
        // is html - striptags
        if (!$html) foreach($response as $row_id=>$row) $response[$row_id][$ext_value] = strip_tags($row[$ext_value]);
            
        //compile found
        foreach($response as $row){
            foreach($words as $word){
                $position = mb_stripos($row[$ext_value], $word, 0, 'utf-8');
                if ($position === false) continue;
                if ($field['externals']['mode'] == 'as_link'){
                    $id = !empty($row[$field['externals']['this_id']]) ? mysql_real_escape_string($row[$field['externals']['this_id']]) : 0;
                    if (!$id) continue; //id not found
                    if (!array_key_exists($id, $found)) $found[$id] = array();
                    $found[$id][] = sprintf('Поле: %s, Позиция: %s<br/> Контекст: %s', $fieldname, $position, htmlspecialchars(mb_substr($row[$ext_value], $position-32, 64, 'utf-8')));
                }
                if ($field['externals']['mode'] == 'as_foreign'){
                    $ids = $this->mngrDB->mysqlGet("SELECT `{$this->current['main_fld']}` FROM `{$this->current['table']}` WHERE `{$field['externals']['other_id']}`='{$row[$field['externals']['main_fld']]}'");
                    foreach($ids as $i){
                        $id = !empty($i[$this->current['main_fld']]) ? mysql_real_escape_string($i[$this->current['main_fld']]) : 0;
                        if (!$id) continue; //id not found
                        if (!array_key_exists($id, $found)) $found[$id] = array();
                        $found[$id][] = sprintf('Поле: %s, Позиция: %s<br/> Контекст: %s', $fieldname, $position, htmlspecialchars(mb_substr($row[$ext_value], $position-32, 64, 'utf-8')));
                    }
                }
            }
        }
        
        //woohoo!
    }
    
    function history_list($main_id){
        $self  = $_SERVER['REQUEST_URI'];
        $selfp = $_SERVER['PHP_SELF'].'?adminaction=history&hist_action=trash';
        $this->filter = new HistMegaFilter($this->mngrDB);
        $a = '<form action="" method="GET">
                <input type="hidden" name="adminaction" value="history" />
                <input type="hidden" name="id" value="'.$main_id.'" />
                <input type="hidden" name="row_id" value="{{id}}" />
                <input type="hidden" name="hist_action" value="show" />
                <input type="submit" value="Смотреть" />
              </form>';
        $a.= !$this->history_allow_revert ? '' : 
             '<form action="'.$selfp.'" class="actionform" method="POST">
                <input type="hidden" name="adminaction" value="history" />
                <input type="hidden" name="hist_action" value="undo" />
                <input type="hidden" name="id"          value="{{row_id}}" />
                <input type="hidden" name="stamp"       value="{{id}}" />
                <input type="hidden" name="fromurl"     value="'.$self.'" />
                <input type="submit" value="Откатить на предыдущее" title="Восстановить на то состояние, которое было до этого" />
              </form>';
        $this->filter->def_order = ' ORDER BY adminhistory.date DESC ';
        $this->filter->mainquery = "SELECT adminhistory.*, group_concat(adminhistory.column separator ',') as cols, count(*) as rc FROM adminhistory WHERE `table`='{$this->current['table']}' AND `row_id`='$main_id' ";
        $this->filter->getFilters();

        $this->filter->fgroup = " GROUP BY adminhistory.date ";
        $this->filter->GetData($a, '');

        $this->filter->AddField("Изменения", "rc", 0);
        $this->filter->AddField("Время", "date", 0);
        $this->filter->AddField("Кто", "whochange", 0);
        $this->filter->AddField("Поля", 'cols', 0, '', null, 0, 1, 0);
        $this->filter->AddField("Действия", "adminactions", 0);


        $context = array();
        $this->createContext($context);

        $stname = $this->history_name ? $this->mngrDB->mysqlGetOne("SELECT `{$this->history_name}` FROM `{$this->current['table']}`
                                                                    WHERE `{$this->current['main_fld']}`='{$main_id}' LIMIT 1") : array();
        $stname = $stname && array_key_exists($this->history_name, $stname) ? ">>&quot;".$stname[$this->history_name]."&quot;" : '';

        $context['title']            = "История для `{$this->current['name']}`$stname (`{$this->current['main_fld']}`='{$main_id}')";
        $context['filter_menu']      = '';
        $context['filter_poslinks']  = '';
        $context['filter_table']     = $this->filter->DrawTable();


        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/history_list.html";
        $body = $this->FillTemplate($file, $context);

        echo $body;
        exit;
    }

    function history_show($main_id, $group){
        //many many actions here!
        $rows = $this->mngrDB->mysqlGet("SELECT * FROM adminhistory WHERE `table`='{$this->current['table']}' AND `row_id`='$main_id' AND
                                         date=(SELECT `date` FROM adminhistory WHERE id='$group')");
        $rows = $rows ? $rows : false;
        if ( !$rows ){
            echo "error";
            return;
        }
        $ch_admin = $this->GetAdminById($rows[0]['admin_id']);
        
        $context = array();
        $this->createContext($context);

        $stname = $this->history_name ? $this->mngrDB->mysqlGetOne("SELECT `{$this->history_name}` FROM `{$this->current['table']}` 
                                                                    WHERE `{$this->current['main_fld']}`='{$main_id}' LIMIT 1") : array();
        $stname = $stname && array_key_exists($this->history_name, $stname) ? ">>&quot;".$stname[$this->history_name]."&quot;" : '';

        $context['admin'] = $ch_admin;
        $context['title'] = "Изменения для `{$this->current['name']}`$stname (`{$this->current['main_fld']}`='{$main_id}') [{$rows[0]['date']}]";
        $context['date']  = $rows[0]['date'];
        $context['vals']  = array();
        foreach($rows as $row_num=>$column){
            $context['vals'][] = array_merge($column, $this->CreateHistoryField($column, $rows));
        }

        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/history.html";
        $body = $this->FillTemplate($file, $context);
        echo $body;
        exit;
    }

    function history_showtrash(){
        $table    = $this->current['table'];
        $main_fld = $this->current['main_fld'];
        $query_name = ', adminhistory.row_id as name ';
        if ($this->history_name){
            $query_name =", (SELECT A1.old_value FROM adminhistory as A1 WHERE A1.date=adminhistory.date AND A1.column='{$this->history_name}' ) as name ";
        }
        $query = "SELECT
                    adminhistory.* {$query_name}
                  FROM
                    adminhistory {{_head_}}
                  WHERE
                        `table`='{$this->current['table']}'
                    AND `type`='delete_all'
                    AND `column`='{$this->current['main_fld']}'
                    ";

        $self  = $_SERVER['REQUEST_URI'];
        $selfp = $_SERVER['PHP_SELF'].'?adminaction=history&hist_action=trash';
        $this->filter = new HistMegaFilter($this->mngrDB);
        $a = '<form action="'.$_SERVER['PHP_SELF'].'" target="_blank" class="actionform" method="GET">
                <input type="hidden" name="adminaction" value="history" />
                <input type="hidden" name="id"          value="{{row_id}}" />
                <input type="submit" value="История" />
              </form>';

        $a .='<form action="'.$selfp.'" class="actionform" method="POST">
                <input type="hidden" name="adminaction" value="history" />
                <input type="hidden" name="hist_action" value="full_delete" />
                <input type="hidden" name="id"          value="{{row_id}}" />
                <input type="hidden" name="fromurl"     value="'.$self.'" />
                <input type="submit" value="Удалить" />
              </form>';
        $a .= !$this->history_allow_revert ? '' : 
             '<form action="'.$selfp.'" class="actionform" method="POST">
                <input type="hidden" name="adminaction" value="history" />
                <input type="hidden" name="hist_action" value="undo" />
                <input type="hidden" name="id"          value="{{row_id}}" />
                <input type="hidden" name="stamp"       value="{{id}}" />
                <input type="hidden" name="fromurl"     value="'.$self.'" />
                <input type="submit" value="Восстановить" />
              </form>';

        $this->filter->def_order = ' ORDER BY adminhistory.date DESC ';
        $this->filter->mainquery = $query;
        $this->filter->getFilters();

        $this->filter->fgroup = " GROUP BY adminhistory.row_id ";
        $this->filter->GetData($a, '');

        $this->filter->AddAvailable("Пользователь", "admin_id", "list", "SELECT `user_id`, `login` FROM `users`", "user_id", "{{login}}", 10, "", "", "", true);

        $this->filter->AddField("", "name", 0);
        $this->filter->AddField("Время", "date", 1);
        $this->filter->AddField("Кто", "whochange", 0);
        $this->filter->AddField("Действия", "adminactions", 0);

        $this->createContext($context);
        $context['title'] = 'Корзина '.$this->current['name'];
        $context['current'] = $this->current;
        $context['filter_table']    = $this->filter->DrawTable();

        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/trash.html";
        $body = $this->FillTemplate($file, $context);
        echo $body;
        exit;
    }

    function history_fulldelete($main_id){
        $to_del = array();
        $columns = array();

        foreach ($this->fields as $f){
            if ( $f['type'] == "image" )
                foreach($f['values']['resizer'] as $resizer)
                    $columns[] = $resizer['field_path'];
            if ( $f['type'] == "file" )
                $columns[] = $f['values']['field_path'];
        }
        
        $columns = $columns ? "'".join("', '", $columns)."'" : '';
        $rows = $this->mngrDB->mysqlGet("SELECT * FROM adminhistory
                            WHERE `table`='{$this->current['table']}' AND `row_id`='$main_id' AND `column` IN ($columns)");

        foreach($rows as $row){
            $to_del[] = $row['old_value'];
            $to_del[] = $row['new_value'];
        }
        $to_del = array_unique($to_del);
        $query = "DELETE FROM adminhistory WHERE `table`='{$this->current['table']}' AND `row_id`='$main_id'";
        mysql_query($query, $this->mngrDB->dbConn);
        //delete all saved files and images
        foreach($to_del as $filename){
                if (!$filename) continue;
                try {
                    @unlink($filename);
                } catch (Exception $exc) {}
        }
        $ret = $_REQUEST['fromurl'] ? $_REQUEST['fromurl'] : $_SERVER['PHP_SELF']."?adminaction=history&hist_action=trash";
        $this->getOutFromHere($ret);
        exit;
    }

    function _history_getlast($row_id, $column, $stamp_id){
        $column   = mysql_real_escape_string($column);
        $query = "SELECT * FROM adminhistory
                  WHERE
                        `table`='{$this->current['table']}'
                    AND `row_id`='$row_id'
                    AND `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id' LIMIT 1)
                    AND `column`='$column'
                  ORDER BY `date`, id LIMIT 1";
        $old = $this->mngrDB->mysqlGetOne($query);
        $old = $old ? $old['old_value'] : "";
        return $old;
    }
    
    function _history_getnewest($row_id, $column, $stamp_id){
        $column   = mysql_real_escape_string($column);
        $query = "SELECT * FROM adminhistory
                  WHERE
                        `table`='{$this->current['table']}'
                    AND `row_id`='$row_id'
                    AND `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id' LIMIT 1)
                    AND `column`='$column'
                  ORDER BY `date` DESC, id DESC LIMIT 1";
        $data = $this->mngrDB->mysqlGetOne($query);
        if (!$data) return '';
        return !empty($data['new_value']) ? $data['new_value'] : $data['old_value'];
    }

    function history_undo($main_id, $stamp_id){
        if (!$this->history_allow_revert){
            echo "This action for this table is not allowed!";
            exit();
        }
        $stamp_id = intval($stamp_id);
        $row_id   = mysql_real_escape_string($main_id);
        $stamp = $this->mngrDB->mysqlGetOne("SELECT `date` FROM adminhistory WHERE `row_id`='$row_id' AND `id`='$stamp_id' LIMIT 1");
        if (!$stamp){
            $this->error("Не удалось восстановить данные из-за отсутсвующих записей в таблице хранения изменений. Попробуйте выбрать другую точку отката.");
            exit;
        }
        $stamp = strtotime($stamp['date']);

        $arr = array();
        if (!$this->mngrDB->mysqlGet("SELECT `{$this->current['main_fld']}` FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='$row_id'")){
            $arr[$this->current['main_fld']] = $row_id;
        }
        

        $mtm_process = array();
        $lnk_process = array();
        $ext_process = array();

        $fields_to_update = $this->mngrDB->mysqlGet("SELECT DISTINCT `column` FROM adminhistory
                                                     WHERE `table`='{$this->current['table']}' AND `row_id`='$row_id' AND
                                                     `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id')");
                                                     
        
        $delete_stamp = false;
        $current_data = $this->mngrDB->mysqlGetOne("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='$row_id'");
        if (!$current_data && $this->mngrDB->mysqlGetCount('adminhistory', " `table`='{$this->current['table']}' AND `row_id`='$row_id' AND `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id') AND `type`='delete_all'") > 0){
            //row was deleted! restore data from admin
            foreach($fields_to_update as $field_data){
                $current_data[$field_data['column']] = $this->_history_getnewest($row_id, $field_data['column'], $stamp_id);
            }
            $dstmp = $this->mngrDB->mysqlGetOne("SELECT `date` FROM adminhistory WHERE `table`='{$this->current['table']}' AND `row_id`='$row_id' AND `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id') AND `type`='delete_all'");
            $delete_stamp = $dstmp ? $dstmp['date'] : false;
        }
        
        foreach($this->fields as $k=>$v){
            if ( $v['type'] == "user_text" )
                continue;
            
            if ( $v['type'] == "image" ){
                foreach($v['values']['resizer'] as $resizer){
                    if ( $resizer['field_url']  ){
                        $saved = $this->_history_getlast($row_id, $resizer['field_url'], $stamp_id);
                        if ($saved){
                            $arr[ $resizer['field_url'] ] = $saved;
                        }
                    }
                    if ( $resizer['field_path'] ){
                        $saved = $this->_history_getlast($row_id, $resizer['field_path'], $stamp_id);
                        if ($saved){
                            $arr[ $resizer['field_path'] ] = $saved;
                        }
                    }
                }
                continue;
            }
            
            if ( $v['type'] == "file" ){
                if ($v['values']['field_path']){
                    $saved = $this->_history_getlast($row_id, $v['values']['field_path'], $stamp_id);
                    if ($saved){
                        $arr[ $v['values']['field_path'] ] = $saved;
                    }
                }
                if ($v['values']['field_size']){
                    $saved = $this->_history_getlast($row_id, $v['values']['field_size'], $stamp_id);
                    if ($saved){
                        $arr[ $v['values']['field_size'] ] = $saved;
                    }
                }
                continue;
            }

            if ( $v['type'] == "ManyToMany" ){
                $query = "SELECT * FROM adminhistory WHERE `table`='{$this->current['table']}' AND `row_id`='$row_id' AND
                          `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id') AND `column`='{$v['field']}' ORDER BY `date` DESC, id DESC";
                $mtm_process[$v['field']] = $this->mngrDB->mysqlGet($query);
                continue;
            }

            if ( $v['type'] == "link" ){
                $query = "SELECT * FROM adminhistory WHERE `table`='{$this->current['table']}' AND `row_id`='$row_id' AND
                          `date`>=(select A1.`date` from adminhistory as A1 WHERE A1.id='$stamp_id') AND `column`='{$v['field']}' ORDER BY `date` DESC, id DESC";
                $lnk_process[$v['field']] = $this->mngrDB->mysqlGet($query);
                continue;
            }
            
            $exists = false;
            foreach($fields_to_update as $ftu){
                if ($ftu['column']==$v['field']){
                    $exists = true;
                    break;
                }
            }

            if ($exists){
                if ($v['externals']){
                    $ext = $v['externals'];
                    $ext_process[$k] = $k;
                    if ($ext['other_id'])
                        $arr[$ext['other_id']] = $this->_history_getlast($row_id, $ext['other_id'], $stamp_id);
                    continue;
                }

                $arr[$v['field']] = $this->_history_getlast($row_id, $v['field'], $stamp_id);
            }

                
        }
        
        if (!empty($this->current['updown'])){
            $saved = $this->_history_getlast($row_id, $this->current['updown'], $stamp_id);
            if ($saved) $arr[$this->current['updown']] = $saved;
        }

        if (!$this->mngrDB->mysqlGet("SELECT `{$this->current['main_fld']}` FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='$row_id'")){
            $this->mngrDB->mysqlInsertArray($this->current['table'], $arr, 1, null, 0); //insert main data
        }
        else{
            $this->mngrDB->mysqlUpdateArray($this->current['table'], $arr, "`{$this->current['main_fld']}`='$row_id'", 1, null, 0); //insert main data
        }
        
        //save main data to history
        foreach($arr as $column=>$value){
            $this->_saveToHistory($column, 'data', array_key_exists($column, $current_data) ? $current_data[$column] : '', $value, false, $row_id);
        }
        

        foreach($mtm_process as $fieldname=>$values){
            $field      = $this->fields[$fieldname];
            $table      = $field['values']['rel_table'];
            $this_id    = $field['values']['this_id'];
            $other_id   = $field['values']['other_id'];
            
            $mtm_delete = array();
            $mtm_create = array();
            
            
            foreach($values as $value){

                if ($value['type'] == 'mtm_add'){
                    unset($mtm_create[$value['new_value']]);
                    $mtm_delete[$value['new_value']] = $value['new_value'];
                }
                if ($value['type'] == 'mtm_delete'){
                    unset($mtm_delete[$value['old_value']]);
                    $mtm_create[$value['old_value']] = $value['old_value'];
                }
            }
            foreach($mtm_create as $mval){
                if ($this->mngrDB->mysqlGetCount($table, " `$this_id`='$row_id' AND `$other_id`='$mval' ") > 0) continue; //skip exists values
                $this->mngrDB->mysqlInsertArray($table, array($this_id=>$row_id, $other_id=>$mval), 1, null, 0);
                //add to the history
                $this->_saveToHistory($field['field'], 'mtm_add', '', $mval, false, $row_id);
            }
            foreach($mtm_delete as $mval){
                if ($this->mngrDB->mysqlGetCount($table, " `$this_id`='$row_id' AND `$other_id`='$mval' ") == 0) continue; //skip nonexists values
                mysql_query("DELETE FROM `$table` WHERE `$this_id`='$row_id' AND `$other_id`='$mval' ", $this->mngrDB->dbConn);
                //add this to the history
                $this->_saveToHistory($field['field'], 'mtm_delete', $mval, '', false, $row_id);
            }
        }
        
        
        foreach($lnk_process as $fieldname=>$values){
            $field = $this->fields[$fieldname];
            $lnk_create = array();
            $lnk_delete = array();
            
            $lnk_other_table = $field['values']['other_table'];
            $lnk_other_id    = $field['values']['other_value'];
            $lnk_other_lnk   = $field['values']['other_link'];
            
            foreach($values as $value){
                if ($value['type'] == 'link_add'){
                    unset($lnk_create[$value['new_value']]);
                    $lnk_delete[$value['new_value']] = $value['new_value'];
                }
                if ($value['type'] == 'link_delete'){
                    unset($lnk_delete[$value['old_value']]);
                    $lnk_create[$value['old_value']] = $value['old_value'];
                }
            }
            
            
            foreach($lnk_create as $lval){
                if ($this->mngrDB->mysqlGetCount($lnk_other_table, " `$lnk_other_id`='$lval' ") == 0) continue; //other row not found
                if ($this->mngrDB->mysqlGetCount($lnk_other_table, " `$lnk_other_id`='$lval' AND `$lnk_other_lnk`='$row_id' ") > 0) continue; //already exists
                $this->mngrDB->mysqlUpdateArray($lnk_other_table, array($lnk_other_lnk=>$row_id), " `$lnk_other_id`='$lval' ", 1, null, 0); //link to this item
                $this->_saveToHistory($field['field'], 'link_add', '', $lval, false, $row_id);
            }
            foreach($lnk_delete as $lval){
                if ($this->mngrDB->mysqlGetCount($lnk_other_table, " `$lnk_other_id`='$lval' ") == 0) continue; //other row not found
                if ($this->mngrDB->mysqlGetCount($lnk_other_table, " `$lnk_other_id`='$lval' AND `$lnk_other_lnk`='$row_id' ") == 0) continue; //already not set
                $this->mngrDB->mysqlUpdateArray($lnk_other_table, array($lnk_other_lnk=>0), " `$lnk_other_id`='$lval' ", 1, null, 0); //remove link
                $this->_saveToHistory($field['field'], 'link_delete', $lval, '', false, $row_id);
            }
            
            
        }
        
        $arr_ex = array_merge($arr, array());
        if (!array_key_exists($this->current['main_fld'], $arr_ex))
            $arr_ex[$this->current['main_fld']] = $row_id;

        
        foreach($ext_process as $k){
            $field = $this->fields[$k];
            $ext   = $field['externals'];

            $ext_data = $this->externals_get_data($field, $arr_ex);
            $ea    = array_merge(array(), $ext['values']);
            $ea[$ext['value_field']] = $this->_history_getlast($row_id, $k, $stamp_id);
            
            $ext_old = $ext_data ? $ext_data[$ext['value_field']] : false;
            if ($ext_old === false && $delete_stamp !== false && $ext['delete'])
                $ext_old = !empty ($current_data[$k]) ? $current_data[$k] : '';
            
            if ($ext_data){
                //update
                $ext_where = $this->externals_get_where($field, $arr_ex);
                $this->mngrDB->mysqlUpdateArray($ext['table'], $ea, $ext_where, 1, null, 0);
                $this->_saveToHistory($field['field'], 'data', $ext_old, $ea[$ext['value_field']], false, $row_id);
            }
            else{
                //insert
                $ext_id_inserted = false;
                if ($ext['this_id'])
                    $ea[$ext['this_id']] = $row_id;
                if ($ext['other_id'] && array_key_exists($ext['other_id'], $arr_ex) && $arr_ex[$ext['other_id']]){
                    $ext_id_inserted = true;
                    $ea[$ext['main_fld']] = $arr_ex[$ext['other_id']];
                }

                $this->mngrDB->mysqlInsertArray($ext['table'], $ea, 1, null);
                $this->_saveToHistory($field['field'], 'data', $ext_old, $ea[$ext['value_field']], false, $row_id);
                if (!$ext_id_inserted && $ext['other_id']){
                    $ext_id = mysql_insert_id($this->mngrDB->dbConn);
                    $this->mngrDB->mysqlUpdateArray($this->current['table'], array($ext['other_id']=>$ext_id), " `{$this->current['main_fld']}`='$row_id' ",1,null,0);
                }
            }
        }
        
        //delete info about delete
        if ($delete_stamp !== false){
            mysql_query("DELETE FROM adminhistory WHERE `date`='$delete_stamp'", $this->mngrDB->dbConn);
        }
        
        if (!empty($this->current['after_func']['history']) && function_exists($this->current['after_funcafter_fu']['history']))
            call_user_func ($this->current['after_func']['history'], $this, $row_id, 'undo', $stamp);

        $ret = $_REQUEST['fromurl'] ? $_REQUEST['fromurl'] : $_SERVER['PHP_SELF']."?adminaction=history&hist_action=trash";
        $this->getOutFromHere($ret);
        exit;
    }

    function history($main_id=null, $group=null){
        $main_id = !empty($_REQUEST['id']) ? mysql_real_escape_string($_REQUEST['id']) : null;
        $group   = !empty($_REQUEST['row_id']) ? $_REQUEST['row_id'] : null;
        $hist_action = !empty($_REQUEST['hist_action']) ? $_REQUEST['hist_action'] : 'list';

        if ( $hist_action == 'list' ){
            //show all changes for this ID
            $this->actiontype     = $this->ACTION_READ;
            $this->rightsCheckAction();
            $this->history_list($main_id);
            exit;
        }

        if ( $hist_action == 'show' ){
            //show history for one transaction (by time)
            $this->actiontype     = $this->ACTION_READ;
            $this->rightsCheckAction();
            $this->history_show($main_id, $group);
            exit;
        }


        if ( $hist_action == 'trash' ){
            //show tras for this table
            $this->actiontype     = $this->ACTION_READ;
            $this->rightsCheckAction();
            $this->history_showtrash();
            exit;
        }

        if ( $hist_action == 'undo' ){
            //revert changes down to this time
            $this->actiontype     = $this->ACTION_WRITE;
            $stamp = !empty($_REQUEST['stamp']) ? intval($_REQUEST['stamp']) : 0;
            $this->rightsCheckAction();
            $this->history_undo($main_id, $stamp);
        }

        if ($hist_action == 'full_delete'){
            $this->actiontype     = $this->ACTION_WRITE;
            $this->rightsCheckAction();
            $this->history_fulldelete($main_id);
        }

        exit;
    }

    function history_saveall($id){
        //save id
        $this->_saveToHistory($this->current['main_fld'], 'delete_all', $id, '', false, $id);
        $row = $this->mngrDB->mysqlGetOne("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='$id' LIMIT 1");

        $f   = array(); // old values for save
        $mtm = array();
        $lnk = array();
        $exts= array();
        //save all fields
        foreach($this->fields as $k=>$v){
            if ( $v['type'] == "user_text" )
                continue;

            if ( $v['type'] == "image" ){
                #for delete
                foreach($v['values']['resizer'] as $resizer){
                    if ( $resizer['field_url']  ) $f[ $resizer['field_url'] ]  = $row[ $resizer['field_url'] ];
                    if ( $resizer['field_path'] ) $f[ $resizer['field_path'] ] = $row[ $resizer['field_path'] ];
                }
                continue;
            }

            if ( $v['type'] == "ManyToMany" ){
                $mtm[$v['field']] = $this->mngrDB->mysqlGet($this->filter->createText("SELECT * FROM `{{rel_table}}` WHERE `{{this_id}}`='$id'", $v['values']));
                continue;
            }

            if ( $v['type'] == "file" ){
                if ( $v['values']['field_path'] ) $f[$v['values']['field_path']] = $row[$v['values']['field_path']];
                if ( $v['values']['field_size'] ) $f[$v['values']['field_size']] = $row[$v['values']['field_size']];
                continue;
            }

            if ( $v['type'] == "link" ){
                $table = $this->fields[$k]['values']['other_table'];
                $lnk[$v['field']] = $this->mngrDB->mysqlGet("SELECT * FROM `$table` WHERE `{$v['values']['other_link']}`='{$row[$this->current['main_fld']]}'");
                continue;
            }

            if ($v['externals']){
                $ext = $v['externals'];
                if ($ext['other_id']) $f[$ext['other_id']] = $row[$ext['other_id']];
                $ext['data'] = $this->externals_get_data($v, $row);
                $ext_value   = array_key_exists($ext['value_field'], $ext['data']) ? $ext['data'][$ext['value_field']] : '';
                $f[$v['field']] = $ext_value;
                continue;
            }

            $f[$v['field']] = $row[$v['field']];
        }

        if (!empty($this->current['updown'])){
            $f[$this->current['updown']] = $row[$this->current['updown']];
        }


        //save arrays
        foreach($f as $hkey=>$hvalue){
            $this->_saveToHistory($hkey, 'data', $hvalue, '', false, $id);
        }

        foreach($mtm as $column=>$hmtm){
            $mtm_other_id    = $this->fields[$column]['values']['other_id'];
            foreach($hmtm as $hvalue){
                $mtm_deleted_val = $hvalue[$mtm_other_id];
                $this->_saveToHistory($column, "mtm_delete", $mtm_deleted_val, '', false, $id);
            }
        }

        foreach($lnk as $column=>$hlink){
            $link_other_id = $this->fields[$column]['values']['other_value'];
            foreach($hlink as $hvalue){
                $link_deleted_val = $hvalue[$link_other_id];
                $this->_saveToHistory($column, "link_delete", $link_deleted_val, '', false, $id);
            }
        }
    }

    function CreateHistoryField($column, $rows=array()){
        if ( !array_key_exists($column['column'], $this->fields) ){
            if ($column['column'] == $this->current['main_fld']){
                //this is ID
                $id_old = $column['old_value'] ? $column['old_value'] : "#Не существует#";
                return array('name'=>sprintf("#Идентификатор# (%s)", $column['column']), 'old'=>$id_old, 'new'=>$column['new_value']);
            }
            return array('name'=>$column['column']."  #поле не найдено#", 'old'=>$column['old_value'], 'new'=>$column['new_value']);
        }
        $field = $this->fields[$column['column']];
        $type = $field['type'];
        $ret = array(); //array('name'=>'', 'old'=>'', 'new'=>'');

        /*
         * Для полей string, integer, float
         */
        if ( in_array($type, array('string', 'integer', 'float', "text", 'date')) ){
            //draw simple input

            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = nl2br(htmlspecialchars($column['old_value']));
            $ret['new']   = nl2br(htmlspecialchars($column['new_value']));
            return $ret;
        }

        /*
         * Для полей enum
         */
        if ($type == "enum"){
            $ret['name'] = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']  = !empty($field['values'][$column['old_value']]) ? $field['values'][$column['old_value']] : $column['old_value'];
            $ret['new']  = !empty($field['values'][$column['new_value']]) ? $field['values'][$column['new_value']] : $column['new_value'];
            return $ret;
        }

        /*
         * Для полей text_fck
         */
        if (  $type == "text_fck" ){
            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = $column['old_value'];
            $ret['new']   = $column['new_value'];
            return $ret;
        }

        /*
         * Для полей image
         */
        if ( $type == "image" ){
            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = htmlspecialchars($column['old_value']);
            $ret['new']   = htmlspecialchars($column['new_value']);
            
            $prev   = '';
            $prev   = '<img src="%s" style="%s" /><br />';
            if ( isset($field['values']['thumb_field']) ){
                $th  = $field['values']['thumb_field'];
                $size = isset($field['values']['thumb_size']) ? $field['values']['thumb_size'] : '';
                $src  = '';
                foreach($rows as $hr){
                    if ($hr['column'] != $th)
                        continue;
                    $src = $hr['column']['new_value'];
                    break;
                }
                $prev = sprintf($prev, $src, $size);
                if ($field['values']['resizer']){
                    foreach($field['values']['resizer'] as $resizer){
                        if ( strlen($resizer['field_url']) < 1 ) continue;
                        $href = '';
                        foreach($rows as $hr){
                            if ($hr['column'] != $resizer['field_url'])
                                continue;
                            $href = $hr['column']['new_value'];
                            break;
                        }
                        $prev .= sprintf('[<a href="%s" target="_blank">%s</a>] ', $href, $resizer['field_url']);
                    }
                    $prev .= '<br />';
                }
            }
            $ret['new'] = $prev.$ret['new'];
            return $ret;
        }

        /*
         * Для полей ManyToMany
         */
        if ( $type == "ManyToMany" ){
            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = htmlspecialchars($column['old_value']);
            $ret['new']   = htmlspecialchars($column['new_value']);

            $ret_value = '';
            if ($column['type'] == 'mtm_add')
                $ret_value = $column['new_value'];
            if ($column['type'] == 'mtm_delete')
                $ret_value = $column['old_value'];

            $ret_selected = false;

            $options = "";
            $sel = Array();
            $other_mainfld = trim($field['values']['value'], "{ }");
            $opt_query = "SELECT * FROM {{other_table}} WHERE `$other_mainfld`='$ret_value'";
            $o = $this->filter->createText($opt_query, $field['values']);
            $o = $this->mngrDB->mysqlGet($o);
            foreach($o as $row){
                $text     = $this->filter->createText($field['values']['text'],  $row);
                $ret_selected = $text;
            }

            if ($column['type'] == 'mtm_delete'){
                $ret['old'] = $ret_selected ? "Удалена связь: ".$ret_selected : "Удалена связь: ".$ret_value.' (конечная цель не найдена)';
                $ret['new'] = '';
            }
            if ($column['type'] == 'mtm_add'){
                $ret['old'] = '';
                $ret['new'] = $ret_selected ? "Добавлена связь: ".$ret_selected : "Добавлена связь: ".$ret_value.' (конечная цель не найдена)';
            }

            return $ret;
        }
        /*
         * Для полей ForeignKey
         */
        if ( $type == "ForeignKey" ){

            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = htmlspecialchars($column['old_value']);
            $ret['new']   = htmlspecialchars($column['new_value']);

            $ret_selected_old = false;
            $ret_selected_new = false;

            $opt_query = "SELECT * FROM {{other_table}} WHERE `{{other_id}}`='{$column['old_value']}'";
            $o = $this->mngrDB->mysqlGet($this->filter->createText($opt_query, $field['values']));
            foreach($o as $row)
                $ret_selected_old = $this->filter->createText($field['values']['text'],  $row);

            $opt_query = "SELECT * FROM {{other_table}} WHERE `{{other_id}}`='{$column['new_value']}'";
            $o = $this->mngrDB->mysqlGet($this->filter->createText($opt_query, $field['values']));
            foreach($o as $row)
                $ret_selected_new = $this->filter->createText($field['values']['text'],  $row);

            $ret['old'] = $ret_selected_old ? "Ссылка: ".$ret_selected_old : "Ссылка: ".$column['old_value'].' (конечная цель не найдена)';
            $ret['new'] = $ret_selected_new ? "Ссылка: ".$ret_selected_new : "Ссылка: ".$column['new_value'].' (конечная цель не найдена)';


            return $ret;
            
        }
        /*
         * Поле file
         */
        if ( $type == "file" ){
            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = htmlspecialchars($column['old_value']) . ' (старый файл был удалён)';
            $ret['new']   = htmlspecialchars($column['new_value']);

            
            $prev   = '';


            $path = '';
            foreach($rows as $hr){
                if ($hr['column'] != $field['values']['field_path'])
                    continue;
                $path = $hr['new_value'];
            }
            $path = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path);
            $fname = explode("/", $path);
            $fname = $fname[count($fname)-1];
            $prev   = 'Загруженный файл: <a href="%s" target="_blank">%s</a><br />';
            $prev   = sprintf($prev, $path, $fname);

            $ret['new'] = $prev;
            
            return $ret;
        }
        /*
         * link
         */
        if ( $type == "link"){

            $ret['name']  = $field['name'] ? $field['name'] : $field['field'];
            $ret['old']   = htmlspecialchars($column['old_value']);
            $ret['new']   = htmlspecialchars($column['new_value']);

            $ret_value = '';
            if ($column['type'] == 'link_add')
                $ret_value = $column['new_value'];
            if ($column['type'] == 'link_delete')
                $ret_value = $column['old_value'];

            $ret_selected = false;

            $options = "";
            $sel = Array();
            $opt_query = "SELECT * FROM {{other_table}} WHERE `{{other_value}}`='$ret_value'";
            $o = $this->filter->createText($opt_query, $field['values']);
            $o = $this->mngrDB->mysqlGet($o);
            foreach($o as $row){
                $text     = $this->filter->createText($field['values']['text'],  $row);
                $ret_selected = $text;
            }

            if ($column['type'] == 'link_delete'){
                $ret['old'] = $ret_selected ? "Удалена внешняя ссылка: ".$ret_selected : "Удалена внешняя ссылка: ".$ret_value.' (конечная цель не найдена)';
                $ret['new'] = '';
            }
            if ($column['type'] == 'link_add'){
                $ret['old'] = '';
                $ret['new'] = $ret_selected ? "Добавлена внешняя ссылка: ".$ret_selected : "Добавлена внешняя ссылка: ".$ret_value.' (конечная цель не найдена)';
            }

            return $ret;
        }

        return array('name'=>'error', 'old'=>'error', 'new'=>'error');
    }

    function GetAdminById($id){
        $user = $this->createUser($id);
        return $user ? $user->getEmail() : "#ERROR#";
    }

    public function DescribeField($name, $field, $type, $values, $edit, $extra_html='', $prehtml='', $afterhtml='', $externals=array()){
        $types = Array('string', 'integer', 'text', 'text_fck', 'enum', 'float', "image", "ManyToMany", 'ForeignKey', 'file', 'user_text', 'link', 'date');
        if ( !in_array($type, $types) )
                return;

        if ( $this->fields === null )
                $this->fields = Array();

        $f = Array();
        $f[  'name']     = $name;
        $f[ 'field']     = $field;
        $f[  'type']     = $type;
        $f['values']     = $values;
        $f[  'edit']     = $edit;
        $f['extra_html'] = $extra_html;
        $f[   'prehtml'] = $prehtml;
        $f[ 'afterhtml'] = $afterhtml;
        $f[ 'externals'] = $this->externals_prepare($externals, $type);

        $this->fields[$field] = $f;
    }

    function externals_prepare($ext, $type){
        if (!$ext){
            return array();
        }
        if (!in_array($type, array('string', 'integer', 'text', 'text_fck', 'enum', 'float', 'date'))){
            return array();
        }
        if (!$ext['this_id'] && !$ext['other_id']){
            return array();
        }
        return $ext;
    }

    function externals_get_data($field, $row=array()){
        $ext = $field['externals'];
        if (!$ext){
            return array();
        }
        if (empty($row)){
            return array();
        }
        $request_get  = "SELECT * FROM `{$ext['table']}` WHERE " . $this->externals_get_where($field, $row);
        $data = $this->mngrDB->mysqlGetOne($request_get);
        return $data;
    }
    
    function externals_get_where_search($field){
        $ext = $field['externals'];
        if (!$ext){
            return '';
        }
        $where_cond  = '';
        $extra_where = !empty($ext['extra_where']) ? $ext['extra_where'] : '';

        if (!empty($ext['values_in_request'])){
            foreach($ext['values'] as $key=>$value)
                $where_cond .= sprintf(" AND `%s`='%s' ", $key, $value);
        }
        $where_cond .= $extra_where;
        return $where_cond;
    }

    function externals_get_where($field, $row=array()){
        $ext = $field['externals'];
        if (!$ext){
            return array();
        }
        if (empty($row)){
            return array();
        }
        $where_cond  = '';
        $extra_where = !empty($ext['extra_where']) ? $ext['extra_where'] : '';

        if ($ext['mode'] == 'as_link'){
            $where_cond .= " `{$ext['this_id']}`='{$row[$this->current['main_fld']]}' ";
        }
        if ($ext['mode'] == 'as_foreign'){
            $where_cond .= " `{$ext['main_fld']}`='{$row[$ext['other_id']]}' ";
        }
        if (!empty($ext['values_in_request'])){
            foreach($ext['values'] as $key=>$value)
                $where_cond .= sprintf(" AND `%s`='%s' ", $key, $value);
        }
        $where_cond .= $extra_where;
        return $where_cond;
    }

    function log($type, $action){
        $t = array();
        $t['admin']   = $this->adminID;
        $t['type']    = $type;
        $t['action']  = $action;

        $this->mngrDB->mysqlInsertArray("adminlog", $t);
    }

    function error($string){
        $t    = Array();
        $t['error'] = $string;
        $t['from_url'] = isset($_POST['fromurl']) ? $_POST['fromurl'] : $this->path_to_admin.'/';
        $this->createContext($t);

        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/error.html";
        $body = $this->FillTemplate($file, $t);

        echo $body;
        exit;
    }

    function drawfilter(){
        //draw filter
        $this->_search_init_fields();
        if ($this->search_available && !empty($_REQUEST['admin_search_text'])) $this->search();
        
        $self = $_SERVER['PHP_SELF'];
        $this->filter->getFilters();
        $full = $_SERVER['REQUEST_URI'];//$this->filter->getLink(); //return if $_SERVER['REQUEST_URI'] causes redirects problem and recursions
        
        $a = '<form action="%s"  class="actionform" method="POST">
                <input type="hidden" name="adminaction" value="%s" />
                <input type="hidden" name="fromurl"     value="%s" />
                <input type="hidden" name="id"          value="{{'.$this->current['main_fld'].'}}" />
                <input type="image" src="'.$this->path_to_admin.'/common/templates/%s.gif" %s />
              </form>';

        $h = '<a href="'.$self.'?adminaction=history&id={{'.$this->current['main_fld'].'}}"><img src="'.$this->path_to_admin.'/common/templates/history.png" /></a>';

        $ad = '<form action="%s"  class="actionform" method="POST">
                <input type="hidden" name="adminaction" value="%s" />
                <input type="hidden" name="fromurl"     value="%s" />
                <input type="submit" value="%s" />
               </form>';
        $rf = '<form class="actionform">
                <input type="button" onclick="document.location=\''.$full.'\'" value="Обновить" />
               </form>';

        if ($this->mngrDB->mysqlGetCount('adminhistory', "`table`='{$this->current['table']}' AND `type`='delete_all'") > 0){
            $trash='<form action="'.$self.'" class="actionform" method="GET">
                  <input type="hidden" name="adminaction" value="history" />
                  <input type="hidden" name="hist_action" value="trash" />
                  <input type="submit" value="Корзина" />
                </form>';
        }
        else
            $trash = '';

        $ud = '<div style="display: inline-block;"><div>
               <form action="'.$self.'" class="actionform" method="POST">
                <input type="hidden" name="adminupdown" value="up" />
                <input type="hidden" name="fromurl"     value="'.$full.'" />
                <input type="hidden" name="id"          value="{{'.$this->current['main_fld'].'}}" />
                <input type="image" style=" margin-bottom:5px;" src="'.$this->path_to_admin.'/common/templates/up_arrow.gif" />
               </form></div><div>
               <form action="'.$self.'"  class="actionform" method="POST">
                <input type="hidden" name="adminupdown" value="down" />
                <input type="hidden" name="fromurl"     value="'.$full.'" />
                <input type="hidden" name="id"          value="{{'.$this->current['main_fld'].'}}" />
                <input type="image" src="'.$this->path_to_admin.'/common/templates/down_arrow.gif" />
               </form></div></div>';

        $deljs  = 'onclick="return confirm(\'Вы точно хотите удалить элемент с '.$this->current['main_fld'].' = {{'.$this->current['main_fld'].'}}?\')"';
        $add    = $this->current['add']     ? sprintf($ad, $self, "add",    $full,  "Добавить")    : '';
        $edit   = $this->current['change']  ? sprintf($a,  $self, "edit",   $full,  "edit", '')   : '';
        $delete = $this->current['delete']  ? sprintf($a,  $self, "delete", $full,  "delete", $deljs) : '';
        $updown = !empty($this->current['updown'])  ? $ud : '';


        $a = '<span style="white-space: nowrap;">'.$updown.$edit.$delete.'</span>';
        
        $this->filter->GetData($a, $this->filter->fgroup, $this->search_results);

        if ($this->current['history']){
            /*foreach($this->filter->result as $rkey=>$rval){
                $hist_rc = $this->mngrDB->mysqlGet("SELECT COUNT(*) as rc FROM adminhistory
                                                    WHERE `table`='{$this->current['table']}' AND row_id='{$rval[$this->current['main_fld']]}'");
                $hist_rc = $hist_rc ? $hist_rc[0]['rc'] : 0;
                if ($hist_rc){
                    $this->filter->result[$rkey]['adminactions'] .= $this->filter->createText(sprintf($h, $hist_rc), $rval);
                }
            }*/
            $hist_ids = array();
            foreach($this->filter->result as $rkey=>$rval)
                $hist_ids[] = $rval[$this->current['main_fld']];
            $hist_ids = "('".join("', '", $hist_ids). "')";
            $hist_rc  = "SELECT `row_id`, COUNT(`id`) as rc FROM adminhistory WHERE `table`='{$this->current['table']}' AND row_id IN {$hist_ids} group by row_id";
            $hist_rc  = $this->mngrDB->mysqlGet($hist_rc);
            $hist_counts = array();
            foreach($hist_rc as $rc){
                $hist_counts[$rc['row_id']] = $rc['rc'];
            }
            foreach($this->filter->result as $rkey=>$rval){
                if ( !array_key_exists($rval[$this->current['main_fld']], $hist_counts)) continue;
                $this->filter->result[$rkey]['adminactions'] .= $this->filter->createText(sprintf($h, $hist_counts[$rval[$this->current['main_fld']]]), $rval);
            }

        }

        $avdescr = false;
        foreach($this->filter->fields as $aval)
            $avdescr = $aval['value'] == "adminactions" ? true : $avdescr;
        if (!$avdescr)
            $this->filter->AddField("Actions", "adminactions", 0, '', 'adminactionfield', false);
        if ($this->search_results)
            $this->filter->AddField("Search",  "adminsearch",  0, '',  null, false);

        if (isset($this->UserDataFunc) && $this->UserDataFunc !== null)
            call_user_func ($this->UserDataFunc);//Call user func for prepare data!

        $title = "{$this->current['name']}";
        $fmenu = "<hr>\n<h2>Активные фильтры</h2><br>\n\n".
                    $this->filter->CreateActiveFilterLists().
                 "<hr>\n<h2>Доступные фильтры</h2><br>\n\n".
                    $this->filter->CreateAvailableFilterLists();
        
        $fpos  = $this->filter->GetPosLinks();


        $ftable= $this->filter->DrawTable();

        $context = array();
        $this->createContext($context);
        $context['search_available'] = $this->search_available;
        $context['search_results']   = $this->search_results;
        $context['search_link']      = $this->_search_create_link();

        $context['title'] = $title;
        $context['filter_menu'] = $fmenu;
        $context['filter_poslinks'] = $fpos;
        $context['filter_table'] = $ftable;
        
        $context['full'] = $full;
        $context['self'] = $self;
        
        $context['admin_buttons'] = array(
            'add'     => $this->current['add'] ? $add : "",
            'refresh' => $rf,
            'trash'   => $this->current['history'] ? $trash : '',
        );
        
        $context['images_fields'] = $this->prepareImagesFields();
        
        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/list.html";
        $body = $this->FillTemplate($file, $context);

        echo $body;
    }

    function delete($id){
        $id  = mysql_real_escape_string($id);
        $r   =  $this->mngrDB->mysqlGet("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='$id'");

        $to_del = array();
        if ($r){
            $r = $r[0];
            if ($this->current['history'])
                $this->history_saveall($id);
            foreach ($this->fields as $f){
                if ( $f['externals'] && $f['externals']['delete']){
                    mysql_query("DELETE FROM `{$f['externals']['table']}` WHERE ".$this->externals_get_where($f, $r), $this->mngrDB->dbConn);
                }
                if ( $f['type'] == "image" )
                    foreach($f['values']['resizer'] as $resizer)
                        if ( $resizer['field_path'] )
                            $to_del[] = $r[$resizer['field_path']];

                if ( $f['type'] == "file" )
                    if ($f['values']['field_path'])
                        $to_del[] = $r[$f['values']['field_path']];

                if ( $f['type'] == "ManyToMany" ){
                    $del_query = $this->filter->createText("DELETE FROM {{rel_table}} WHERE {{this_id}}=$id", $f['values']);
                    mysql_query($del_query);
                }
            }
        }

        if (!$this->current['delete'])
            $this->getOutFromHere($_POST['fromurl']);
        $query = "DELETE FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='{$id}'";
        mysql_query($query, $this->mngrDB->dbConn);
        foreach($to_del as $path){
            if ($this->current['history'])
                continue;
            # delete old files!
            try {
                @unlink($path);
            } catch (Exception $exc) {
                #echo $exc->getTraceAsString();
            }
        }
        $this->log("delete", "Удалена запись {$id} из {$this->current['table']}");
        if (!empty($this->current['after_func']['delete']))
            call_user_func ($this->current['after_func']['delete'], $this, (int)$_POST['id'], 'delete');
        $this->getOutFromHere($_POST['fromurl']);
    }

    function edit_drawform($errors = Array()){
        $t = Array();

        $t['title']       = "Изменить данные в '{$this->current['name']}' [`{$this->current['main_fld']}`={$_POST['id']}]";
        $t['fields']      = ""; //TODO
        //
        $this->createContext($t);
        //create post with exists data
        $r = $this->mngrDB->mysqlGet("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`={$t['id']}");
        if (!$r){
            $this->error("Не могу найти данные в {$this->current['table']} с `{$this->current['main_fld']}`='{$t['id']}'");
            return;
        }
        $r = $r[0];
        $this->row = $r;

        foreach($r as $k=>$v){
            if (isset($_POST[$k]))
                continue;
            $_POST[$k] = $v;
        }

        foreach($this->fields as $field){
            if ($field['externals']){
                //get data for "externals" field
                $externals = $field['externals'];
                $ext_value = false;
                $externals['data'] = $this->externals_get_data($field, $r);
                $this->fields[$field['field']]['externals']['data'] = $externals['data'];
                $ext_value = array_key_exists($externals['value_field'], $externals['data']) ? $externals['data'][$externals['value_field']] : false;
                if ($ext_value !== false){
                    $_POST[$field['field']] = $ext_value;
                }
            }
        }
        
        
        //create fields

        $s = '';
        foreach($this->fields as $k=>$v){
            $error = array_key_exists($v['field'], $errors) ? $errors[$v['field']] : '';
            $s    .= '<tr>'.$this->createField($v, $error).'</tr>';
            $s    .= "\n\n";
        }

        $t['fields'] = $s;
        
        //load template
        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.$this->templates['edit'];
        $body = $this->FillTemplate($file, $t);

        echo $body;
    }
    
    function edit(){
        $id = mysql_real_escape_string($_REQUEST['id']);
        $this->row = $this->mngrDB->mysqlGetOne("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='{$id}'");
        if ( !array_key_exists('submitbutton', $_POST) ){
            //first call
            $this->edit_drawform();
            return;
        }
        $errors = array();
        $f      = array(); // array to save to db
        $to_del = array();
        $history_mtm = array();
        $history_link= array();
        $exts        = array();
        $files       = array(); //files to save to fs
        
        foreach($this->fields as $k=>$v){
            if (isset($_REQUEST['xadmin_custom_req']) && $_REQUEST['xadmin_custom_req'] == 1 &&  !isset($_POST[$v['field']])){
                continue;
            }
            //if (!isset($_POST[$v['field']])) continue;
            if ( in_array($v['type'], array("user_text")) )
                    continue;
            //check value
            if (!$v['edit']) continue;
            $err = $this->checkField($v);

            if ($err){
                $errors[$v['field']] = $err;
                continue;
            }

            if ($v['externals']){
                $exts[] = $k;
                continue;
            }

            if ( !in_array($v['type'], array("image", "file", "ManyToMany", 'link')) ){
                $f[$v['field']] = $_POST[$v['field']];
                continue;
            }

            if ( $v['type'] == "image" ){
                if (!empty($_REQUEST[$v['field'].'_admin_clear_that_image'])){
                    //for clear image
                    foreach($v['values']['resizer'] as $resizer){
                        if ( $resizer['field_url'] ) $f[ $resizer['field_url'] ] = '';
                        if ( $resizer['field_path'] ){
                            $f[ $resizer['field_path'] ] = '';
                            $to_del[] = $this->row[$resizer['field_path']];
                        }
                    }
                }
                
                if ($_FILES[$v['field']]['size'] < 1)
                    continue;
                foreach($v['values']['resizer'] as $resizer){
                    $data = $this->resizer($v['field'], $resizer);
                    if ( $resizer['field_url'] )
                        $f[ $resizer['field_url'] ] = $data['url'];
                    if ( $resizer['field_path'] ){
                        $f[ $resizer['field_path'] ] = $data['path'];
                        $to_del[] = $this->row[$resizer['field_path']];
                    }
                }
            }
            if ( $v['type'] == "ManyToMany" ){
                #$id = (int)$_POST['id'];
                if ($this->current['history']){
                    $history_mtm[$v['field']] = array('old'=>array(), 'new'=>array());
                    $history_mtm[$v['field']]['old'] = $this->mngrDB->mysqlGet($this->filter->createText("SELECT * FROM {{rel_table}} WHERE {{this_id}}='$id'", $v['values']));
                }
                $del_query = $this->filter->createText("DELETE FROM {{rel_table}} WHERE {{this_id}}=$id", $v['values']);
                mysql_query($del_query);
                if (empty ($_POST[$v['field']]))
                    continue;
                foreach( $_POST[$v['field']] as $value ){
                    $table    = $v['values']['rel_table'];
                    $this_id  = $v['values']['this_id'];
                    $other_id = $v['values']['other_id'];
                    $insert_array            = array();
                    $insert_array[$this_id]  = $id;
                    $insert_array[$other_id] = $value;
                    $this->mngrDB->mysqlInsertArray($table, $insert_array, $skipSpecCh=1, $db=null, $skipEscape=0);
                }
                if ($this->current['history']){
                    $history_mtm[$v['field']]['new'] = $this->mngrDB->mysqlGet($this->filter->createText("SELECT * FROM {{rel_table}} WHERE {{this_id}}='$id'", $v['values']));
                }
            }
            if ( $v['type'] == "file" ){
                if (!empty($_REQUEST[$v['field'].'_admin_clear_that_file'])){
                    //for clear image
                    $to_del[] = $this->row[$v['values']['field_path']];
                    if (!empty($v['values']['field_path'])) $f[$v['values']['field_path']] = '';
                    if (!empty($v['values']['field_size'])) $f[$v['values']['field_size']] = '';
                    continue; //you cant upload new file when deleting current
                }
                
                if( !isset($_FILES[$v['field']]) )
                    continue;
                $file    = $_FILES[$v['field']];
                if ( $file['size'] == 0)
                    continue;
                //Start user func
                $check = call_user_func($v['values']['user_check'], $file, $v);
                if ($check === false){
                    $errors[$v['field']] = "Файл не прошёл проверку";
                    continue;
                }
                $file['saved_field'] = $v;
                $file['user_check']  = $check;
                $files[] = $file;
            }
            if ( $v['type'] == "link" ){
                #$id = (int)$_POST['id'];
                $r  = $this->mngrDB->mysqlGet("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`=$id");
                if ( $r )
                    $r = $r[0];
                $table    = $this->fields[$k]['values']['other_table'];
                $set = array();
                $set[$v['values']['other_link']]  = 0;
                $where = " `{$v['values']['other_link']}`='{$r[$this->current['main_fld']]}' ";
                if ($this->current['history'])
                    $history_link[$v['field']]['old'] = $this->mngrDB->mysqlGet("SELECT * FROM $table WHERE `{$v['values']['other_link']}`='{$r[$this->current['main_fld']]}'");
                $this->mngrDB->mysqlUpdateArray($table, $set, $where, $skipSpecCh=1);
                if( !empty($_POST[$v['field']]) ){
                    foreach( $_POST[$v['field']] as $value ){
                        $set = array();
                        $set[$this->fields[$k]['values']['other_link']]  = $r[$this->current['main_fld']];
                        $where = " `{$v['values']['other_value']}`='$value' ";
                        $this->mngrDB->mysqlUpdateArray($table, $set, $where, $skipSpecCh=1);
                    }
                }
                if ($this->current['history'])
                    $history_link[$v['field']]['new'] = $this->mngrDB->mysqlGet("SELECT * FROM $table WHERE `{$v['values']['other_link']}`='{$r[$this->current['main_fld']]}'");
            }
        }
        if ($errors){
            $this->edit_drawform($errors);
            return;
        }

        foreach($exts as $k){
            $field = $this->fields[$k];
            $ext   = $field['externals'];
            if (!$ext)
                continue;
            $old_value = false;
            $new_value = $_REQUEST[$k];

            $ext['data'] = $this->externals_get_data($field, $this->row);

            $ea = array_merge(array(), $ext['values']);
            $ea[$ext['value_field']] = $new_value;

            if (!$ext['data']){
                $old_value = '';
                //insert new value
                if ($ext['this_id'])
                    $ea[$ext['this_id']] = $id;
                //insert
                $this->mngrDB->mysqlInsertArray($ext['table'], $ea, 1, null);
                //update current row
                if ($ext['other_id']){
                    $ext_id = mysql_insert_id($this->mngrDB->dbConn);
                    $this->mngrDB->mysqlUpdateArray($this->current['table'], array($ext['other_id']=>$ext_id), " `{$this->current['main_fld']}`='$id' ",1,null,0);
                }
            }
            else{
                //update old value
                $old_value = $ext['data'][$ext['value_field']];
                $ext_where = $this->externals_get_where($field, $this->row);
                $this->mngrDB->mysqlUpdateArray($ext['table'], $ea, $ext_where, 1, null, 0);
            }

            //save external value to history
            $this->_saveToHistory($k, 'data', $old_value, $new_value);
        }

        //process files
        foreach($files as $file){
            $v = $file['saved_field'];
            $filename = $this->_safeFilename(stripslashes($file['name']),
                                            !empty($v['values']['prefix']) ? $v['values']['prefix'] : '',
                                            !empty($v['values']['custom']) ? $v['values']['custom'] : '' );
            $this->_safeDirectory($v['values']['folder']); //try create dirs
            $i = 0;
            while ( file_exists($path = rtrim($v['values']['folder'], '/ ') . '/'. $this->_filenameInc($filename, $i++)) ) ;

            copy($file['tmp_name'], $path);
            if ( $v['values']['field_path'] ){
                #$id = (int)$_POST['id'];
                $r  = $this->mngrDB->mysqlGet("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`=$id");
                if ( $r )
                    $r = $r[0];
                $to_del[] = $r[$v['values']['field_path']];
                $f[$v['values']['field_path']] = $path;
            }
            if ( $v['values']['field_size'] )
                $f[$v['values']['field_size']] = $file['size'];
            //add user fields to table
            if (is_array($file['user_check'])){
                foreach($file['user_check'] as $ch_k=>$ch_v)
                    $f[$ch_k] = $ch_v;
            }
        }
        
        //history
        if ($this->current['history']){
            $old = $this->mngrDB->mysqlGet("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='{$id}'");
            $old = $old ? $old[0] : array();
            $this->old_values['old'] = $old;
            $this->old_values['history_mtm'] = $history_mtm;
            $this->old_values['history_link'] = $history_link;
            foreach($f as $hkey=>$hvalue){
                $hist_type = "data";
                if (array_key_exists($hkey, $old) && $old[$hkey] != $hvalue){
                    $this->_saveToHistory($hkey, $hist_type, $old[$hkey], $hvalue);
                }
            }
            foreach($history_mtm as $column=>$hmtm){
                $mtm_other_id = $this->fields[$column]['values']['other_id'];
                foreach($hmtm['old'] as $hkey=>$hvalue){
                    $mtm_deleted = false;
                    $mtm_deleted_val = $hvalue[$mtm_other_id];
                    
                    foreach($hmtm['new'] as $knew=>$vnew){
                        if ( $hvalue[$mtm_other_id] == $vnew[$mtm_other_id] ){
                            unset($hmtm['old'][$hkey]);
                            unset($hmtm['new'][$knew]);
                            $mtm_deleted = true;
                            continue;
                        }
                    }
                    if (!$mtm_deleted){
                        $this->_saveToHistory($column, "mtm_delete", $mtm_deleted_val, '');
                    }
                }
                foreach($hmtm['new'] as $knew=>$vnew){
                    $this->_saveToHistory($column, "mtm_add", '', $vnew[$mtm_other_id]);
                }
            }

            foreach($history_link as $column=>$hlink){
                $link_other_id = $this->fields[$column]['values']['other_value'];
                foreach($hlink['old'] as $oldk=>$oldv){
                    $link_deleted = false;
                    $link_deleted_val = $oldv[$link_other_id];
                    foreach($hlink['new'] as $newk=>$newv){
                        if ($oldv[$link_other_id] == $newv[$link_other_id]){
                            unset($hlink['old'][$oldk]);
                            unset($hlink['new'][$newk]);
                            $link_deleted = true;
                        }
                    }
                    if (!$link_deleted)
                        $this->_saveToHistory($column, "link_delete", $link_deleted_val, '');
                }
                foreach($hlink['new'] as $knew=>$vnew){
                    $this->_saveToHistory($column, "link_add", '', $vnew[$link_other_id]);
                }
            }

        }

        //add to db (insert array);

        $rxx = $this->mngrDB->mysqlGet("SELECT * FROM `{$this->current['table']}` WHERE `{$this->current['main_fld']}`='{$_POST['id']}'");
        $this->row_buk = $rxx ? $rxx[0] : array();

        $where = "`{$this->current['main_fld']}`='{$_POST['id']}'";
        $this->mngrDB->mysqlUpdateArray($this->current['table'], $f, $where, $skipSpecCh=1, $db=null, $skipEscape=0);
        if (mysql_error($this->mngrDB->dbConn)){
            SAdminDebuger::logIt($this, 'Error while update row in DB', 1);
            SAdminDebuger::logIt($this, mysql_error(), 1);
        }
        foreach($to_del as $path){
            if ($this->current['history'])
                continue;
            # delete old files!
            try {
                @unlink($path);
            } catch (Exception $exc) {
                #echo $exc->getTraceAsString();
            }
        }
        $this->log("edit", "Изменены данные в '{$this->current['name']}' с `{$this->current['main_fld']}`={$_POST['id']}");
        if (!empty($this->current['after_func']['edit']))
            call_user_func ($this->current['after_func']['edit'], $this, (int)$_POST['id'], 'edit');
        $this->getOutFromHere($_POST['fromurl']);
        #exit;
    }

    function _saveToHistory($column, $type, $old_value, $new_value, $table=false, $row_id=false){
        if ($old_value === $new_value)
            return;
        if (!$old_value && !$new_value){
            return;
        }
        if($old_value === '0000-00-00' && !$new_value){
            return;
        }
        if (is_string($old_value) && is_string($old_value)){
            $x_old = stripslashes($old_value);
            $x_new = stripslashes($new_value);
            if ($x_new === $x_old) return;
        }

        if(!$this->history_timestamp)
            $this->history_timestamp = time();
        $a = array();
        $a['table']     = $table  === false ? $this->current['table'] : $table;
        $a['row_id']    = $row_id === false ? intval($_REQUEST['id']) : intval($row_id);
        $a['column']    = $column;
        $a['type']      = $type;
        $a['old_value'] = ''.$old_value;
        $a['new_value'] = ''.$new_value;
        $a['admin_id']  = $this->adminID;
        if ($this->history_timestamp)
            $a['date']  = date("Y-m-d H:i:s", $this->history_timestamp);
        $this->mngrDB->mysqlInsertArray('adminhistory', $a, $skipSpecCh=1);
        $this->history_last_id = mysql_insert_id($this->mngrDB->dbConn);
    }

    function _translit($string){
        $rus = array(' ', 'ї',  'ё', 'ж', 'ц', 'ч', 'ш', 'щ',  'ю', 'я', 'Ё', 'Ж', 'Ц', 'Ч', 'Ш', 'Щ',  'Ю', 'Я',  'Ї');
        $lat = array('-', 'yi', 'yo','zh','tc','ch','sh','sch','yu','ya','Yo','Zh','Tc','Ch','Sh','Sch','Yu','Ya', 'Yi');
        $string = str_replace($rus,$lat,$string);

        $patt_rus = "АБВГДЕЗИЙКЛМНОПРСТУФХЪЫЬЭЇЁабвгдезийклмнопрстуфхъыьэїё.";
        $patt_lat = "ABVGDEZIJKLMNOPRSTUFH I EIEabvgdezijklmnoprstufh i eie.";

        for($i=0; $i<mb_strlen($patt_lat, 'UTF-8'); $i++){
            $string = str_replace(mb_substr($patt_rus, $i, 1, 'UTF-8'), mb_substr($patt_lat, $i, 1, 'UTF-8'), $string);
        }
        $string = preg_replace("/[^a-zA-Z0-9\/_|+-]/", '', $string);
        $string = preg_replace("/[\/|+ -]+/", '-', $string);
        $string = preg_replace("/[_]+/", '_', $string);
        $string = preg_replace("/[\s]+/", '-', $string);
        $string = trim($string, '-');
        return($string);
    }

    function _safeFilename($filename, $prefix='', $custom=''){
        $ext = $this->getExtension($filename);
        //clear extension
        $i = mb_strrpos($filename, ".");
        if ($i) $filename = mb_substr($filename, 0, $i);

        $filename = $custom ? $custom : $filename;          // if set custom filename
        $filename = $this->_translit($filename);            // translit

        $filename = $filename ? $filename : 'unnamed-file'; //dont allow empty filenames
        $filename = $prefix . $filename . "." . $ext;       //append prefix and extension
        return $filename;
    }

    function _filenameInc($filename, $inc){
        if (!$inc) return $filename;
        $ext = $this->getExtension($filename);
        $i = mb_strrpos($filename,".");
        if ($i) $filename = mb_substr($filename, 0, $i);
        return $filename.'-'.$inc.".".$ext;
    }

    function _safeDirectory($path){
        $path = rtrim($path, '/\\ ');
        if (file_exists($path) && !is_writable($path)){
            try { chmod($path, 0777); } catch (Exception $exc) { }
        }
        if (file_exists($path)) return;
        //try create directorys

        try {
            if ( mkdir($path, 0777) ) return; // create one dyrectory because umask dont set for recurs
        } catch (Exception $exc) {
            //cant create directory
            //maybe permission denied
            ;
        }

        try {
            mkdir($path, 0777, true);
            chmod($path, 0777);
        } catch (Exception $exc) {
            //cant create directory
            //maybe permission denied
            ;
        }

    }

    function add(){
        if ( !array_key_exists('submitbutton', $_POST) ){
            //first call
            $this->add_drawform();
            return;
        }
        $errors = array();
        $f      = array(); // array to save in db (for mngrDB->mysqlInsertArray()
        $to_add = array(); // in this array we will store ManyToMany values
        $to_link= array(); // in this array we will store "link" values
        $exts   = array(); // externals
        $files  = array(); //files to save
        foreach($this->fields as $k=>$v){
            if (isset($_REQUEST['xadmin_custom_req']) && $_REQUEST['xadmin_custom_req'] == 1 &&  !isset($_POST[$v['field']])){
                continue;
            }
            if ( in_array($v['type'], array("user_text")) )
                    continue;
            //check value
            $err = $this->checkField($v);

            if ($err){
                $errors[$v['field']] = $err;
                continue;
            }
            if ($v['externals']){
                //save data for externals field
                $exts[] = $k;
                continue;
            }

            if ( !in_array($v['type'], array("image", "file", "ManyToMany", "link")) ){
                if ( array_key_exists($v['field'], $_POST) )
                    $f[$v['field']] = $_POST[$v['field']];
                continue;
            }
            if ( $v['type'] == "image" ){
                foreach($v['values']['resizer'] as $resizer){
                    $data = $this->resizer($v['field'], $resizer);
                    if ( $resizer['field_url'] )
                        $f[ $resizer['field_url'] ] = $data['url'];
                    if ( $resizer['field_path'] )
                        $f[ $resizer['field_path'] ] = $data['path'];
                }
            }
            if ( $v['type'] == "ManyToMany" ){
                //fuck! we dont have ID in this field yet!!! :-(
                if( !empty($_POST[$v['field']]) ){
                    $to_add[$k] = array();
                    foreach( $_POST[$v['field']] as $value )
                        $to_add[$k][] = $value;
                }
            }
            if ( $v['type'] == "file" ){
                $file    = $_FILES[$v['field']];
                if ( $file['size'] == 0)
                    continue;
                //Start user func
                $check = call_user_func($v['values']['user_check'], $file, $v);
                if ($check === false){
                    $errors[$v['field']] = "Файл не прошёл проверку";
                    continue;
                }
                $file['saved_field'] = $v;
                $file['user_check']  = $check;
                $files[] = $file;
            }
            if ( $v['type'] == "link" ){
                if( !empty($_POST[$v['field']]) ){
                    $to_link[$k] = array();
                    foreach( $_POST[$v['field']] as $value )
                        $to_link[$k][] = $value;
                }
            }
        }

        if ($errors){
            $this->add_drawform($errors);
            return;
        }
        foreach ($f as $k=>$v) {

        }
        
        //process files
        foreach($files as $file){
            $v = $file['saved_field'];
            $filename = $this->_safeFilename(stripslashes($file['name']),
                                                !empty($v['values']['prefix']) ? $v['values']['prefix'] : '',
                                                !empty($v['values']['custom']) ? $v['values']['custom'] : '' );
            $this->_safeDirectory($v['values']['folder']); //try create dirs
            $i = 0;
            while ( file_exists($path = rtrim($v['values']['folder'], '/ ') . '/'. $this->_filenameInc($filename, $i++)) ) ;

            copy($file['tmp_name'], $path);
            if ( $v['values']['field_path'] )
                $f[$v['values']['field_path']] = $path;
            if ( $v['values']['field_size'] )
                $f[$v['values']['field_size']] = $file['size'];
            //add user fields to table (returning by usercheck function))
            if (is_array($file['user_check'])){
                foreach($file['user_check'] as $ch_k=>$ch_v)
                    $f[$ch_k] = $ch_v;
            }
        }

        //sort field add
        if (!empty($this->current['updown']) && !isset($_REQUEST[$this->current['updown']])){
            $max = $this->mngrDB->mysqlGet("SELECT `{$this->current['updown']}` FROM `{$this->current['table']}` WHERE 1 ORDER BY `{$this->current['updown']}` DESC LIMIT 1");
            $max = $max ? $max[0][$this->current['updown']]+1 : 0;
            $f[$this->current['updown']] = $max;
        }
        //add to db (insert array);
        $this->mngrDB->mysqlInsertArray($this->current['table'], $f, $skipSpecCh=1, $db=null, $skipEscape=0);
        $id = mysql_insert_id();
        //ManyToMany
        foreach($to_add as $k=>$v){
            $table    = $this->fields[$k]['values']['rel_table'];
            $this_id  = $this->fields[$k]['values']['this_id'];
            $other_id = $this->fields[$k]['values']['other_id'];
            foreach($v as $value){
                $insert_array            = array();
                $insert_array[$this_id]  = $id;
                $insert_array[$other_id] = $value;
                $this->mngrDB->mysqlInsertArray($table, $insert_array, $skipSpecCh=1, $db=null, $skipEscape=0);
            }
        }
        foreach($to_link as $k=>$v){
            $table    = $this->fields[$k]['values']['other_table'];
            foreach($v as $value){
                $set = array();
                $set[$this->fields[$k]['values']['other_link']]  = $id;
                $where = " `{$this->fields[$k]['values']['other_value']}`='$value' ";
                $this->mngrDB->mysqlUpdateArray($table, $set, $where, $skipSpecCh=1);
            }
        }
        if ( $this->current['history'] ){
            $this->_saveToHistory($this->current['main_fld'], 'add_new', '', $id, false, $id);
        }

        foreach($exts as $k){
            $field = $this->fields[$k];
            $ext   = $field['externals'];
            if (!$ext)
                continue;
            //create "row" for externals needs
            $add_rowx = array_merge($f, array($this->current['main_fld']=>$id));
            mysql_query("DELETE FROM `{$ext['table']}` WHERE {$this->externals_get_where($field, $add_rowx)}"); //remove exists data for this row
            //prepare data
            $ea = array_merge(array(), $ext['values']);
            if ($ext['this_id'])
                $ea[$ext['this_id']] = $id;
            $ea[$ext['value_field']] = $_POST[$k];
            //insert
            $this->mngrDB->mysqlInsertArray($ext['table'], $ea, 1, null);
            //update current row
            if ($ext['other_id']){
                $ext_id = mysql_insert_id($this->mngrDB->dbConn);
                $this->mngrDB->mysqlUpdateArray($this->current['table'], array($ext['other_id']=>$ext_id), " `{$this->current['main_fld']}`='$id' ",1,null,0);
            }
        }
        
        

        $this->log("add" ,"Добавлены данные в {$this->current['table']}");
        if (!empty($this->current['after_func']['add'])){
            call_user_func ($this->current['after_func']['add'], $this, $id, 'add');
        }
        $fromurl = $_POST['fromurl'];
        if ( strpos($fromurl, "#new_id") !== false )
            $fromurl = str_replace("#new_id", $id, $fromurl);
        $this->getOutFromHere($fromurl);
        #exit;
    }

    function resizer($name, $resizer, $filepath = false){
        $image    = null;
        $filename = '';
        
        if ($filepath === false){
            $filepath = $_FILES[$name]['tmp_name'];
            if (!$filepath && empty($this->fields[$name]['values']['required']))
                    return array("path"=>'', "url"=>'');
            $filename = $_FILES[$name]['name'];
        }
        else{
            $filename = basename($filepath);
        }
        
        
        $image_info = getimagesize($filepath);
        $image_type = $image_info[2];

        if (empty($resizer['size']) || !array_filter($resizer['size'])){
            $tmpname  = $filepath;
            $newname  = join(".", array(time() . "_" . rand(1, 100), $this->getExtension($filename)));
            $filepath = join("/", array($resizer['path'], $newname));
            $fileurl  = join("/", array($resizer['url'] , $newname));
            copy($tmpname, $filepath);
            return array("path"=>$filepath, "url"=>$fileurl);
        }

        if( $image_type == IMAGETYPE_JPEG )
            $image = imagecreatefromjpeg($filepath);
        if( $image_type == IMAGETYPE_GIF )
            $image = imagecreatefromgif($filepath);
        if( $image_type == IMAGETYPE_PNG )
            $image = imagecreatefrompng($filepath);


        if (true){
            $width   = imagesx($image);
            $height  = imagesy($image);

            $new_w  = $width;
            $new_h  = $height;

            if ( $resizer['size'] && ($resizer['size'][0] < $width || $resizer['size'][1] < $height) ){


                if ($width >= $height || $resizer['size'][1]/$height*$width > $resizer['size'][0]){
                    $new_w = $resizer['size'][0];
                    $ratio = $new_w / $width;
                    $new_h = $height * $ratio;
                }
                else{
                    $new_h = $resizer['size'][1];
                    $ratio = $new_h / $height;
                    $new_w = $width * $ratio;
                }
            }

            $new_image = imagecreatetruecolor($new_w, $new_h);
            if(($image_type == 1) OR ($image_type==3)){
                imagealphablending($new_image, false);
                imagesavealpha($new_image,true);
                $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
                imagefilledrectangle($new_image, 0, 0, $new_w, $new_h, $transparent);
            }
            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
            $image = $new_image;


        }

        $newname  = join(".", array(time() . "_" . rand(1, 100), $this->getExtension($filename)));

        
        $inc = 1;
        while(file_exists(join("/", array($resizer['path'], $newname)))) $newname = $this->_filenameInc ($newname, $inc++);
        
        $filepath = join("/", array($resizer['path'], $newname));
        $fileurl  = join("/", array($resizer['url'] , $newname));

        $x = false;
        if( $image_type == IMAGETYPE_JPEG )
            $x = imagejpeg($image,$filepath, 75);
        if( $image_type == IMAGETYPE_GIF )
            $x = imagegif($image,$filepath);
        if( $image_type == IMAGETYPE_PNG )
            $x = imagepng($image,$filepath);
        return array("path"=>$filepath, "url"=>$fileurl);

    }
    
    function prepareImagesFields(){
        $fields_data = array();
        foreach($this->fields as $field_key=>$field) {
            if ($field['type'] != 'image') continue;
            foreach($field['values']['resizer'] as $resizer_key=>$resizer){
                $this->fields[$field_key]['values']['resizer'][$resizer_key]['resizer_name'] 
                        = !empty($resizer['field_path']) ? $resizer['field_path'] : $resizer['field_url'];
            }
            $__field = $this->fields[$field_key];
            $__field['serialized'] = base64_encode(serialize($__field));
            $fields_data[] = $__field;
        }
        return $fields_data;
    }

    function getExtension($str) {
         $i = mb_strrpos($str,".");
         if (!$i) { return ""; }
         $l = mb_strlen($str) - $i;
         $ext = mb_substr($str,$i+1,$l);
         $ext = mb_strtolower($ext);
         return $ext;
    }

    function checkField($field){
        $errors = array();
        $type   = $field['type'];

        if ( in_array($type, Array('string', 'integer', 'text', 'text_fck', 'enum', 'float')) ){
            if (!isset($_POST[$field['field']]))
                    return "Вы не ввели значение";
        }

        if ( $type == "image" || $type == "file" ){
            if($_POST['adminaction'] == "add" && !isset($_FILES[$field['field']]) && !empty($field['values']['required'])){
                return "Вы не выбрали файл";
            }
        }

        $data   = isset($_POST[$field['field']]) ? $_POST[$field['field']] : "";
        $values = $field['values'];

        if ($type == "string"){
            if ($values[0] && mb_strlen($data, 'UTF-8') < $values[0])
                $errors[] = "Строка слишком короткая!";
            if ($values[1] && mb_strlen($data, 'UTF-8') > $values[1])
                $errors[] = "Строка слишком длинная!";
        }

        if ( in_array($type, array('integer', 'float')) ){
            if ($values[0] && $data < $values[0])
                $errors[] = "Число слишком маленькое";
            if ($values[1] && $data > $values[1])
                $errors[] = "Число слишком большое";
        }

        if ($type == "enum"){
            if (!array_key_exists($data, $field['values']))
                $errors[] = "Неверное значение";
        }

        if ( $type == "text" || $type == "text_fck" ){
            if ($values[0] && mb_strlen($data, 'UTF-8') < $values[0])
                $errors[] = "Слишком короткий текст.. Аффтар пишы есчо!!1";
            if ($values[1] && mb_strlen($data, 'UTF-8') > $values[1])
                $errors[] = "Слишком много текста.. Краткость - сестра таланта!";

            if ($type == "text_fck" && !empty($values['cool_wysiwyg']) && $this->row !== null){
                if ( strpos($data, '##hello_from_shevayura_and_no_changes_made##') !== false ){
                    $old_data = array_key_exists($field['field'], $this->row) ? $this->row[$field['field']] : '';
                    if ($field['externals']){
                        $old_data = $this->externals_get_data($field, $this->row);
                        $old_data = array_key_exists($field['externals']['value_field'], $old_data) ? $old_data[$field['externals']['value_field']] : '';
                    }
                    $_REQUEST[$field['field']] = $_POST[$field['field']] = $_GET[$field['field']] = $old_data;
                }
                else
                    $this->fields[$field['field']]['values']['cool_wysiwyg'] = false;
            }
        }

        if ( $type == "image" ){
            $image    = $_FILES[$field['field']];
            if ($_POST['adminaction'] == "edit" && $image['size'] == 0)
                return False;
            if ($_POST['adminaction'] == "add" && $image['size'] == 0 && empty($field['values']['required']))
                return False;
            $filename = stripslashes($image['name']);
            if ( !$filename ){
                $errors[] = "Плохое имя файла.";
            }
            $ext = strtolower($this->getExtension($filename));
            if ( !in_array($ext, array('jpg', 'jpeg', 'png', 'gif')) )
                $errors[] = "Неверное расширение.";
            $image_info = getimagesize($image['tmp_name']);
            if ( empty($image_info) )
                $errors[] = "Это не картинка!";
        }

        if ( $type == "ForeignKey" ){
            if (!empty($field['values']['required'])){
                $dt = mysql_real_escape_string($data);
                if (!$dt)
                    $errors[] = "Пустое значение!";
                $res = $this->mngrDB->mysqlGet($this->filter->createText("SELECT * FROM {{other_table}} WHERE `{{other_id}}`='$dt'", $values));
                $safe_field = mysql_real_escape_string(trim($field['values']['value'], "{ }"));
                $res = $res ? $res : $this->mngrDB->mysqlGet($this->filter->createText("SELECT * FROM {{other_table}} WHERE `$safe_field`='$dt'", $field['values']));
                if (!$res)
                    $errors[] = 'Нету таких значений';
                if (count($res) > 1)
                    $errors[] = 'Ошибка при добавлении! Таких значений больше чем одно!';
            }
        }

        if ( $type == "file" ){
            $file    = $_FILES[$field['field']];
            if ($_POST['adminaction'] == "edit" && $file['size'] == 0)
                return False;
            if ($_POST['adminaction'] == "add" && $file['size'] == 0 && empty($field['values']['required']))
                return False;
            if ( $file['size'] == 0)
                $errors[] = "Пустой файл.";
            $filename = stripslashes($file['name']);
            if ( !$filename ){
                $errors[] = "Плохое имя файла.";
            }
            $ext = strtolower($this->getExtension($filename));
            if (!empty($field['values']['allow_ext']) && !in_array($ext, $field['values']['allow_ext']) )
                $errors[] = "Неверное расширение.";
        }

        if ( $type == "date" ){
            if ( $values[0] || $values[1] ){
                if ( empty($data) )
                    $errors[] = "Не ввели дату";
            }
            $chk_date = -1;
            if (!empty($data)){
                try {
                    $chk_date = strtotime($data);
                } catch (Exception $exc) {
                    $errors[] = "Неверный формат";
                }
                if (strlen($data) != strlen("YYYY-MM-DD"))
                    $errors[] = "Неверный формат (длинна строки не совпадает)";
            }
            if ($values[0] && $chk_date < $values[0])
                $errors[] = "Слишком малая дата";
            if ($values[1] && $chk_date > $values[1])
                $errors[] = "Слишком большая дата";
        }

        if (is_array($values) && array_key_exists('custom_check', $values) && function_exists($values['custom_check'])){
            $custom_errors = call_user_func($values['custom_check'], $field, $data);
            if ($custom_errors) $errors = array_merge($errors, $custom_errors);
        }

        return join("<br>\n", $errors);

    }

    function add_drawform($errors = Array()){
        $t = Array();

        $t['title']       = "Добавить новую запись в '{$this->current['name']}'";
        $t['fields']      = ""; //TODO

        $this->createContext($t);

        //create fields

        $s = '';
        foreach($this->fields as $k=>$v){
            $error = array_key_exists($v['field'], $errors) ? $errors[$v['field']] : '';
            $s    .= '<tr>'.$this->createField($v, $error).'</tr>';
            $s    .= "\n\n";
        }

        $t['fields'] = $s;

        //load template
        $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin.$this->templates['add'];
        $body = $this->FillTemplate($file, $t);

        echo $body;
        exit;
    }

    function createAddButton($file){
        return '<a class="xhref" href="'.$file.'?type=showform" target="_blank"><img src="'.$this->path_to_admin.'/common/templates/plus.png" class="ximage" /></a>';
    }

    public function createField($field, $error){

        $type = $field['type'];
        if ( $_POST['adminaction'] == 'edit' && !$field['edit'] ){
            return sprintf('<td> %s </td><td> %s </td>', $field['name'], $_POST[$field['field']]);
        }

        $prehtml = $field['prehtml'];
        $afterhtml = $field['afterhtml'];
        /*
         * Для полей string, integer, float
         */
        if ( in_array($type, array('string', 'integer', 'float')) ){
            //draw simple input
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $type   = "text";
            $name   = $field['field'];
            $value  = isset($_POST[$name]) ? htmlspecialchars($_POST[$name]) : "";
            $extra  = $field['extra_html'];
            $lsize  = $field['type'] == 'string' ? 'size="75"' : '';
            
            $a = '<td class="%s"> %s </td><td class="%s"> %s <input type="%s" name="%s" %s value="%s" %s/> %s</td>';
            $a = sprintf($a, $class, $label, $class, $prehtml, $type, $name, $lsize, $value, $extra, $afterhtml);
            return $a;
        }

        /*
         * Для полей enum
         */
        if ($type == "enum"){
            $class = $error ? "err_fld" : "fld";
            $name  = $field['field'];
            $lbl   = $field['name'];
            $lbl  .= $error ? '<br>'.$error : '';
            $extra  = $field['extra_html'];

            #<option disabled>Select one</option>
            $f =
            '<td class="%s"> %s </td><td class="%s">
                %s
                <select name="%s" %s>
                %s
             </select> %s </td>';
            $a = '<option %s value="%s">%s</option>';
            $aa = '';
            foreach($field['values'] as $k=>$v){
                $selected = (isset($_POST[$name]) && $_POST[$name] == $k) ? 'selected' : '';
                $value    = $k;
                $label    = $v;
                $aa .= sprintf($a, $selected, $value, $label);
            }

            $f = sprintf($f, $class, $lbl, $class, $prehtml, $name, $extra, $aa, $afterhtml);
            return $f;
        }

        /*
         * Для полей text, text_fck
         */
        if ( $type == "text" || $type == "text_fck" ){
            $st = $type == "text_fck" ? 'style="width: 1000px;"' : '';
            
            $class = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $name   = $field['field'];
            $extra  = $field['extra_html'];
            $value  = (isset($_POST[$name]) && $_POST[$name]) ? $_POST[$name] : '';
            $cwyg   = !empty($field['values']['cool_wysiwyg']) ? 'admin_wysiwyg_add(ev.sender);' : '';

            $fckid = '';//$type == "text_fck" ? sprintf(' id="id_%s" ',$name) : '';
            $f  = '<td colspan="2" '.$st.' class="%s"> %s <br> %s
                     <textarea rows="10" cols="45" name="%s" '.$fckid.' %s>%s</textarea>
                     %s %s
                   </td>';

            //* FOR CKEdiror WITH AjexFileManager
            $contentCss = $this->wysiwyg_css ? "'".join("','", $this->wysiwyg_css)."'" : '';
            $contentCss = $contentCss ? "contentsCss: [".$contentCss."]," : '';
            $js     = $type == "text_fck" ? sprintf('<script type="text/javascript"> 
                      var %s_ckeditor = CKEDITOR.replace(\'%s\', {%s});
                      AjexFileManager.init({returnTo: \'ckeditor\', editor: %s_ckeditor, path: \'%s/common/templates/AjexFileManager/\'});
                      %s_ckeditor.on( \'instanceReady\', function( ev ){
                          var writer = ev.editor.dataProcessor.writer;
                          var dtd = CKEDITOR.dtd;
                          for ( var e in CKEDITOR.tools.extend( {}, dtd.$block, dtd.$inline ) )
                          {
                             ev.editor.dataProcessor.writer.setRules( e, {
                                indent: false,
                                breakBeforeOpen : false,
                                breakAfterOpen : false,
                                breakAfterClose : false,
                                breakBeforeClose : false
                             });
                          }
                          %s
                      } );
                      </script>
                      ',
                      $name, $name, $contentCss, $name, $this->path_to_admin, $name, $cwyg)
                : '';
             //*/
            #$js     = $type == "text_fck" ? sprintf('<script>tinyMCE.execCommand("mceAddControl",false,"%s");</script>', 'id_'.$name) : '';
            
            #$value  = $type == "text_fck" ? stripcslashes($value) : $value;
            $f = sprintf($f, $class, $label, $prehtml, $name, $extra, $value, $js, $afterhtml);
            return $f;
        }

        /*
         * Для полей image
         */
        if ( $type == "image" ){
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $type   = "file";
            $name   = $field['field'];
            $extra  = $field['extra_html'];
            $prev   = '';
            $iclear = '';
            if ($_POST['adminaction'] == 'edit'){
                $prev   = '<img src="%s" style="%s" /><br />';
                if ( isset($field['values']['thumb_field']) ){
                    $th  = $field['values']['thumb_field'];
                    $size = isset($field['values']['thumb_size']) ? $field['values']['thumb_size'] : '';
                    $prev = sprintf($prev, $this->row[$th], $size);
                    if ($field['values']['resizer']){
                        foreach($field['values']['resizer'] as $resizer){
                            if ( strlen($resizer['field_url']) < 1 ) continue;
                            $prev .= sprintf('[<a href="%s" target="_blank">%s</a>] ', $this->row[$resizer['field_url']], $resizer['field_url']);
                        }
                        $prev .= '<br />';
                    }
                    $iclear = sprintf('<br/><input type="checkbox" value="1" name="%s_admin_clear_that_image" /> Очистить<br/>', $name);
                }
                else
                    $prev = '';
            }


            $f = '<td class="%s"> %s </td><td class="%s"> %s %s <input type="%s" name="%s" %s/> %s %s </td>';
            $f = sprintf($f, $class, $label, $class, $prev, $prehtml, $type, $name, $extra, $iclear, $afterhtml);
            return $f;
        }

        /*
         * Для полей ManyToMany
         */
        if ( $type == "ManyToMany" ){
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $name   = $field['field'];
            $extra  = $field['extra_html'];

            if ( !$field['values']['subtype'] ){
                //Если подтип поля не определён тогда рисуем простой селект
                $opt = "\n\t".'<option value="%s" %s>%s</option>';
                $options = "";
                $sel = Array();
                $o = $this->filter->createText($field['values']['opt_query'], $field['values']);
                $o = $this->mngrDB->mysqlGet($o);
                foreach($o as $row){
                    $value    = $this->filter->createText($field['values']['value'], $row);
                    $text     = $this->filter->createText($field['values']['text'],  $row);
                    $selected = "";
                    if ( $_POST['adminaction'] == "edit" && empty($_POST[$name]) ){
                        if (!$sel){
                            $sel = "SELECT {{other_id}} FROM {{rel_table}} WHERE {{this_id}}='{$_POST['id']}'";
                            $sel = $this->filter->createText($sel, $field['values']);
                            $sel = $this->mngrDB->mysqlGet($sel);
                        }
                        foreach($sel as $s)
                            if ( $s[$field['values']['other_id']] == $value )
                                $selected = "selected";
                    }
                    if (!empty($_POST[$name])){
                        foreach($_POST[$name] as $pval){
                            if ($pval == $value)
                                $selected = "selected";
                        }
                    }
                    $options .= sprintf($opt, $value, $selected, $text);
                }
                $f = '<td class="%s">%s</td><td class="%s"> %s <select class="ManyToMany_select" name="%s[]" multiple %s>%s</select> %s </td>';
                return sprintf($f, $class, $label, $class, $prehtml, $name, $extra, $options, $afterhtml);
            }
            if ( $field['values']['subtype']['name'] == "xselect" ){
                $context   = array();
                $context['name'] = $name;
                $context['other_table']  = $field['values']['other_table'];
                $context['search_field'] = $field['values']['subtype']['search_field'];
                $context['value_field']  = $field['values']['subtype']['value_field'];
                $context['image_field']  = $field['values']['subtype']['image_field'];
                $context['format']       = $field['values']['text'];
                $context['addform']      = empty($field['values']['subtype']['toadd']) ? '' : $this->createAddButton($field['values']['subtype']['toadd']);

                $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/autofill.html";
                $body = $this->FillTemplate($template, $context);

                $options = '';
                $opt = '\n\t<option value="%s" selected>%s</option>';
                if ($_POST['adminaction'] == 'edit'){
                    $sel = "SELECT `{$field['values']['other_id']}` FROM {$field['values']['rel_table']} WHERE {$field['values']['this_id']}='{$_POST['id']}'";
                    $sel = $this->mngrDB->mysqlGet($sel);
                    $in = array();
                    foreach($sel as $s)
                        $in[] = "'".$s[$field['values']['other_id']]."'";
                    $in = join(", ", $in);
                    $sel = "SELECT * FROM {$field['values']['other_table']} WHERE {$field['values']['subtype']['value_field']} IN ({$in})";
                    $sel = $this->mngrDB->mysqlGet($sel);
                    foreach($sel as $row){
                        $value    = $this->filter->createText($field['values']['value'], $row);
                        $text     = $this->filter->createText($field['values']['text'],  $row);
                        $options .= sprintf($opt, $value, $text);
                    }

                }
                $f = '<td class="%s">%s</td><td class="%s">
                        %s
                        <table><tr><td>%s</td><td> =&gt; <select class="xselect" id="%s" name="%s[]" multiple %s>%s</select></td></tr></table>
                        %s
                      </td>';
                return sprintf($f, $class, $label, $class, $prehtml, $body, $name, $name, $extra, $options, $afterhtml);
            }

            if ( $field['values']['subtype']['name'] == "xself" ){
                $context   = array();
                $context['name'] = $name;
                $context['search_field'] = $field['values']['subtype']['search_field'];
                $context['format']       = $field['values']['text'];
                $context['field']        = $field['field'];
                $context['addform']      = empty($field['values']['subtype']['toadd']) ? '' : $this->createAddButton($field['values']['subtype']['toadd']);

                $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/autofill_self.html";
                $body = $this->FillTemplate($file, $context);

                $opt = "\n\t<option value=\"%s\" selected>%s</option>";
                $options = '';
                if (empty($field['values']['required']))
                    $options .= sprintf('\n\t<option value="%s">%s</option>', '0', "#Ничего не выбирать#");

                if ($_POST['adminaction'] == 'edit'){
                    $sel = "SELECT `{$field['values']['other_id']}` FROM {$field['values']['rel_table']} WHERE {$field['values']['this_id']}='{$_POST['id']}'";
                    $sel = $this->mngrDB->mysqlGet($sel);
                    $in = array();
                    foreach($sel as $s)
                        $in[] = "'".$s[$field['values']['other_id']]."'";
                    $in = join(", ", $in);
                    $sel = "SELECT * FROM {$field['values']['other_table']} WHERE {$field['values']['subtype']['value_field']} IN ({$in})";
                    $sel = $this->mngrDB->mysqlGet($sel);
                    foreach($sel as $row){
                        $value    = $this->filter->createText($field['values']['value'], $row);
                        $text     = $this->filter->createText($field['values']['text'],  $row);
                        $options .= sprintf($opt, $value, $text);
                    }

                }
                $f = '<td class="%s">%s</td><td class="%s">
                        %s
                        <table><tr><td>%s</td><td> =&gt; <select size="10" class="xselect" id="%s" name="%s[]" multiple %s>%s</select></td></tr></table>
                        %s
                      </td>';
                return sprintf($f, $class, $label, $class, $prehtml, $body, $name, $name, $extra, $options, $afterhtml);
            }
        

            if ( $field['values']['subtype']['name'] == "xjava" ){
                $f = '';
                if (!$this->xjava_added){
                    $file = fopen($_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/xjava.html", "r");
                    $body = fread($file, 20000);
                    fclose($file);
                    $f .= $body;
                }
                $opt = '\n\t<option value="%s" %s>%s</option>';
                $options = "";
                $sel = Array();
                $o = $this->filter->createText($field['values']['opt_query'], $field['values']);
                $o = $this->mngrDB->mysqlGet($o);
                foreach($o as $row){
                    $value    = $this->filter->createText($field['values']['value'], $row);
                    $text     = $this->filter->createText($field['values']['text'],  $row);
                    $selected = "";
                    if ( $_POST['adminaction'] == "edit" ){
                        if (!$sel){
                            $sel = "SELECT {{other_id}} FROM {{rel_table}} WHERE {{this_id}}='{$_POST['id']}'";
                            $sel = $this->filter->createText($sel, $field['values']);
                            $sel = $this->mngrDB->mysqlGet($sel);
                        }
                        foreach($sel as $s)
                            if ( $s[$field['values']['other_id']] == $value )
                                $selected = "selected";
                    }
                    $options .= sprintf($opt, $value, $selected, $text);
                }
                $xjlink = empty($field['values']['subtype']['link']) ? "" : $field['values']['subtype']['link'];
                $f .= '
                    <td class="%s">%s</td>
                    <td class="%s">
                    %s
                    <div class="xjava_label_added">Выбранные:</div>
                    <div class="xjava_added" id="xjava_added_%s"></div>
                    <div class="xjava_label_available">Добавить:</div>
                    <div class="xjava_available" id="xjava_available_%s"></div>
                    <select class="xjava_main_list" style="display: none;" id="%s" name="%s[]" multiple>%s</select>
                    %s
                    <script>
                        xjava_setlink("%s", \'%s\');
                        xjava_init("%s");
                    </script>
                    %s
                    </td>';
                $f = sprintf($f, $class, $label, $class, $prehtml, $name, $name, $name, $name, $options, $extra, $name, $xjlink, $name, $afterhtml);
                return $f;
            }
        }

        /*
         * Для полей ForeignKey
         */
        if ( $type == "ForeignKey" ){
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $name   = $field['field'];
            $extra  = $field['extra_html'];

            if ( !$field['values']['subtype'] ){
                //Если подтип поля не определён тогда рисуем простой селект
                $opt = '\n\t<option value="%s" %s>%s</option>';
                $options = '';
                if (empty($field['values']['required']))
                    $options .= sprintf($opt, '0', '', "#Ничего не выбирать#");
                $sel = Array();
                $o = $this->filter->createText($field['values']['opt_query'], $field['values']);
                $o = $this->mngrDB->mysqlGet($o);
                foreach($o as $row){
                    $value    = $this->filter->createText($field['values']['value'], $row);
                    $text     = $this->filter->createText($field['values']['text'],  $row);
                    $selected = "";
                    if ( $_POST['adminaction'] == "edit" ){
                        $sel = $this->row[$field['field']];
                        if ( $sel == $value )
                            $selected = "selected";
                    }
                    else{
                        if (isset($_POST[$name]) && $_POST[$name] == $value)
                            $selected = "selected";
                    }
                    $options .= sprintf($opt, $value, $selected, $text);
                }
                $f = '<td class="%s">%s</td><td class="%s"> %s <select size="10" class="ManyToMany_select" name="%s" %s>%s</select> %s </td>';
                return sprintf($f, $class, $label, $class, $prehtml, $name, $extra, $options, $afterhtml);
            }
            if ( $field['values']['subtype']['name'] == "xselect" ){
                $context   = array();
                $context['name'] = $name;
                $context['other_table']  = $field['values']['other_table'];
                $context['search_field'] = $field['values']['subtype']['search_field'];
                $context['value_field']  = $field['values']['subtype']['value_field'];
                $context['image_field']  = $field['values']['subtype']['image_field'];
                $context['format']       = $field['values']['text'];
                $context['addform']      = empty($field['values']['subtype']['toadd']) ? '' : $this->createAddButton($field['values']['subtype']['toadd']);

                $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/autofill.html";
                $body = $this->FillTemplate($file, $context);

                $opt = '\n\t<option value="%s" selected>%s</option>';
                $options = '';
                if (empty($field['values']['required']))
                    $options .= sprintf('\n\t<option value="%s">%s</option>', '0', "#Ничего не выбирать#");
                if ($_POST['adminaction'] == 'edit'){
                    $sel = $this->row[$field['field']];
                    $sel = "SELECT * FROM {$field['values']['other_table']} WHERE `{$field['values']['subtype']['value_field']}`='{$sel}'";
                    $sel = $this->mngrDB->mysqlGet($sel);
                    foreach($sel as $row){
                        $value    = $this->filter->createText($field['values']['value'], $row);
                        $text     = $this->filter->createText($field['values']['text'],  $row);
                        $options .= sprintf($opt, $value, $text);
                    }

                }
                $f = '<td class="%s">%s</td><td class="%s">
                        %s
                        <table><tr><td>%s</td><td> =&gt; <select size="10" class="xselect" id="%s" name="%s" %s>%s</select></td></tr></table>
                        %s
                      </td>';
                return sprintf($f, $class, $label, $class, $prehtml, $body, $name, $name, $extra, $options, $afterhtml);
            }
            if ( $field['values']['subtype']['name'] == "xself" ){
                $context   = array();
                $context['name'] = $name;
                $context['search_field'] = $field['values']['subtype']['search_field'];
                $context['format']       = $field['values']['text'];
                $context['field']        = $field['field'];
                $context['addform']      = empty($field['values']['subtype']['toadd']) ? '' : $this->createAddButton($field['values']['subtype']['toadd']);

                $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/autofill_self.html";
                $body = $this->FillTemplate($file, $context);

                $opt = '\n\t<option value="%s" selected>%s</option>';
                $options = '';
                if (empty($field['values']['required']))
                    $options .= sprintf('\n\t<option value="%s">%s</option>', '0', "#Ничего не выбирать#");

                if ($_POST['adminaction'] == 'edit'){
                    $sel = $this->row[$field['field']];
                    $sel = "SELECT * FROM {$field['values']['other_table']} WHERE `{$field['values']['subtype']['value_field']}`='{$sel}'";
                    $sel = $this->mngrDB->mysqlGet($sel);
                    foreach($sel as $row){
                        $value    = $this->filter->createText($field['values']['value'], $row);
                        $row_q    = $this->filter->createText($field['values']['opt_query'], $field['values']);
                        $row_q   .= " AND `{$field['values']['subtype']['value_field']}`='$value'";
                        $row_q      = $this->mngrDB->mysqlGet($row_q);
                        $row = $row_q ? $row_q[0] : $row;
                        $text     = $this->filter->createText($field['values']['text'],  $row);
                        $options .= sprintf($opt, $value, $text);
                    }

                }
                $f = '<td class="%s">%s</td><td class="%s">
                        %s
                        <table><tr><td>%s</td><td> =&gt; <select size="10" class="xselect" id="%s" name="%s" %s>%s</select></td></tr></table>
                        %s
                      </td>';
                return sprintf($f, $class, $label, $class, $prehtml, $body, $name, $name, $extra, $options, $afterhtml);
            }
        }
        /*
         * Поле file
         */
        if ( $type == "file" ){
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $type   = "file";
            $name   = $field['field'];
            $extra  = $field['extra_html'];
            $prev   = '';
            if ($_POST['adminaction'] == 'edit'){
                $path   = $this->row[$field['values']['field_path']];
                $path   = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path);
                $fname  = explode("/", $path);
                $fname  = $fname[count($fname)-1];
                $lpath  = !empty($field['values']['custom_download']) && function_exists($field['values']['custom_download']) ? call_user_func($field['values']['custom_download'], $field) : $path;
                $prev   = 'Загруженный файл: <a href="%s" target="_blank">%s</a><br /><input type="checkbox" value="1" name="%s_admin_clear_that_file" /> Очистить<br/>';
                $prev   = sprintf($prev, $lpath, $fname, $name);
            }
            $f = '<td class="%s"> %s </td><td class="%s"> %s %s <input type="%s" name="%s" %s /> %s </td>';
            $f = sprintf($f, $class, $label, $class, $prev, $prehtml, $type, $name, $extra, $afterhtml);
            return $f;
        }
        /*
         * user_text
         */
        if ( $type == "user_text" ){
            $id = 0;
            if ($_POST['adminaction'] == "edit"){
                $id= $this->row[$this->current['main_fld']];
            }
            if (function_exists($field['values']['func'])){
                $str = call_user_func($field['values']['func'], $_POST['adminaction'], $id);
            }
            else{
                $str = !empty($field['values']['text']) ? $field['values']['text'] : '';
            }
            if (!$str) return '';
            $ret = '';
            if ($field['name'])
                $ret = sprintf('<td> %s </td><td> %s </td>', $field['name'], $str);
            else
                $ret = sprintf('<td colspan="2"> %s </td>', $str);
            return $ret;

        }

        /*
         * link
         */
        if ( $type == "link"){
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $type   = "file";
            $name   = $field['field'];
            $extra  = $field['extra_html'];
            $context   = array();
            $context['name'] = $name;
            $context['search_field'] = $field['values']['search_field'];
            $context['field']        = $field['field'];
            $context['addform']      = empty($field['values']['toadd']) ? '' : $this->createAddButton($field['values']['toadd']);
            //read and fill template
            $file = $_SERVER['DOCUMENT_ROOT'].$this->path_to_admin."/common/templates/autofill_self.html";
            $body = $this->FillTemplate($file, $context);

            //create list of options
            $opt = '\n\t<option value="%s" selected>%s</option>';
            $options = '';

            if ($_POST['adminaction'] == 'edit'){
                $id = mysql_real_escape_string($_POST['id']);
                $sel = "SELECT * FROM {$field['values']['other_table']} WHERE `{$field['values']['other_link']}`='{$id}'";
                $sel = $this->mngrDB->mysqlGet($sel);
                foreach($sel as $row){
                    $value    = $this->filter->createText($field['values']['value'],  $row);
                    $text     = $this->filter->createText($field['values']['text'],  $row);
                    $options .= sprintf($opt, $value, $text);
                }

            }

            $f = '<td class="%s">%s</td><td class="%s">
                    %s
                     <table>
                        <tr>
                        <td>%s</td>
                        <td> =&gt; <select class="xselect" id="%s" name="%s[]" multiple %s >%s</select></td>
                        </tr>
                     </table>
                    %s
                  </td>';
            return sprintf($f, $class, $label, $class, $prehtml, $body, $name, $name, $extra, $options, $afterhtml);
        }
        /*
         * date
         */
        if ( $type == "date"){
            $class  = $error ? "err_fld" : "fld";
            $label  = $field['name'];
            $label .= $error ? '<br>'.$error : '';
            $type   = "date";
            $name   = $field['field'];
            $extra  = $field['extra_html'];
            $value  = isset($_POST[$name]) ? $_POST[$name] : "";
            $value  = preg_match("/\s*\d+:\d+:\d+\s*/", $value) ? preg_filter("/\s*\d+:\d+:\d+\s*/", '', $value) : $value;
            $value  = $value == "0000-00-00" ? "" : $value;
            
            

            $a = '<td class="%s"> %s </td><td class="%s"> %s <input class="date" type="%s" name="%s" value="%s" %s />
                    <span style="font-size: 10px; color:gray;">ГГГГ-ММ-ДД</span> %s </td>';
            $a = sprintf($a, $class, $label, $class, $prehtml, $type, $name, $value, $extra, $afterhtml);
            return $a;
        }
    }

    public function UpDown_up($id){
        $table   = $this->current['table'];
        $updown  = $this->current['updown'];
        $fid     = $this->current['main_fld'];

        $c = $this->mngrDB->mysqlGet("SELECT * FROM `$table` WHERE `$fid`='$id'");
        if (!$c) return;
        $c = $c[0];

        $ud_add = '';

        if (!empty($this->current['updown_additional'])){

            $context = array();
            $context['id'] = $id;
            $context['updown'] = $updown;
            $context['table']  = $table;
            $context['main_fld'] = $fid;
            $context['current']  = $c;
            $loader = hash_loader(array( "substr.html" => $this->current['updown_additional']));
            $udh2o = new H2o('substr.html', array('loader' => $loader));
            $ud_add = $udh2o->render($context);
        }

        $current = $c[$updown];

        $count_c = $this->mngrDB->mysqlGetCount($table, "`$updown`='{$c[$updown]}' $ud_add " );
        $count_n = $this->mngrDB->mysqlGetCount($table, "`$updown`>'{$c[$updown]}' $ud_add " );

        if (  $count_c > 1 && $count_n > 0 ){
            $q = "UPDATE `$table` SET `$updown`=`$updown`+1 WHERE `$updown` > '$current' $ud_add ";
            mysql_query($q, $this->mngrDB->dbConn);
            $current +=1;
        }

       

        $n = $this->mngrDB->mysqlGet("SELECT * FROM `$table` WHERE `$updown`>'$current'  $ud_add order by `$updown`  LIMIT 1");
        $next = $n ? (int)$n[0][$updown] : $current+1;

        if ($n) mysql_query("UPDATE `$table` SET `$updown`='$current' WHERE `$updown` = '$next' $ud_add ");
        mysql_query("UPDATE `$table` SET `$updown`='$next' WHERE `$fid` = '$id' ");
    }

    public function UpDown_down($id){
        $table   = $this->current['table'];
        $updown  = $this->current['updown'];
        $fid     = $this->current['main_fld'];


        $c = $this->mngrDB->mysqlGet("SELECT * FROM `$table` WHERE `$fid`='$id'");
        if (!$c) return;
        $c = $c[0];

        $ud_add = '';
        if (!empty($this->current['updown_additional'])){
            $context = array();
            $context['id'] = $id;
            $context['updown'] = $updown;
            $context['table']  = $table;
            $context['main_fld'] = $fid;
            $context['current']  = $c;
            $loader = hash_loader(array( "substr.html" => $this->current['updown_additional']));
            $udh2o = new H2o('substr.html', array('loader' => $loader));
            $ud_add = $udh2o->render($context);
        }

        $current = $c[$updown];

        $count_c = $this->mngrDB->mysqlGetCount($table, "`$updown`='{$c[$updown]}' $ud_add " );
        $count_n = $this->mngrDB->mysqlGetCount($table, "`$updown`<'{$c[$updown]}' $ud_add " );

        if (  $count_c > 1 && $count_n > 0 ){
            $q = "UPDATE `$table` SET `$updown`=`$updown`+1 WHERE `$updown` >= '$current' $ud_add ";
            mysql_query($q, $this->mngrDB->dbConn);
        }



        $n = $this->mngrDB->mysqlGet("SELECT * FROM `$table` WHERE `$updown`<'$current'  $ud_add order by `$updown` DESC LIMIT 1");
        $next = $n ? (int)$n[0][$updown] : $current-1;

        if ($n) mysql_query("UPDATE `$table` SET `$updown`='$current' WHERE `$updown` = '$next'  $ud_add ");
        mysql_query("UPDATE `$table` SET `$updown`='$next' WHERE `$fid` = '$id' ");
    }

    public function UpDown(){
        $goto = $_REQUEST['fromurl'];
        if (empty($this->current['updown']))
                $this->getOutFromHere ($goto);

        $current = (int)$_POST['id'];
        $dir     = $_POST['adminupdown'];



        if (!$this->current['updown_invert'])
            strtolower($dir) == "up" ? $this->UpDown_up($current) : $this->UpDown_down($current);
        else
            strtolower($dir) == "up" ? $this->UpDown_down($current) : $this->UpDown_up($current);
        $this->getOutFromHere ($goto);

    }

    public function SetUpDown($fieldname, $invert=false, $additional=''){
        $this->current['updown'] = $fieldname;
        $this->current['updown_invert'] = $invert;
        $this->current['updown_additional']  = $additional;
    }

    public function Menu(){
        $menujs = '<script type="text/javascript">
                        jsHover = function() {
                          var hEls = document.getElementById("nav").getElementsByTagName("LI");
                          for (var i=0, len=hEls.length; i<len; i++) {
                            hEls[i].onmouseover=function() { this.className+=" jshover"; }
                            hEls[i].onmouseout=function() { this.className=this.className.replace(" jshover", ""); }
                          }
                        }
                        if (window.attachEvent && navigator.userAgent.indexOf("Opera")==-1)
                            window.attachEvent("onload", jsHover);
                    </script>';
        $menus = $this->mngrDB->mysqlGet("SELECT * FROM adminmenu ORDER BY priority");
        /* precheck menu for selected items */
        if (empty($this->menu_bind)){
            foreach($menus as $mkey=>$menu){
                $url = explode("?", $menu['url']);
                $url = $url[0];
                if ($url == $_SERVER['PHP_SELF']){
                    $menus[$mkey]['this_selected'] = true;
                    if ($menu['parent']>0)
                        foreach($menus as $skmenu=>$smenu)
                            if($smenu['id']==$menu['parent'] && empty($smenu['this_selected'])){
                                $menus[$skmenu]['has_selected'] = true;
                                break;
                            }
                    continue;
                }
            }
        }
        else{
            foreach($menus as $mkey=>$menu){
                if ($menu['id'] == $this->menu_bind){
                    $menus[$mkey]['this_selected'] = true;
                    if ($menu['parent']>0)
                        foreach($menus as $skmenu=>$smenu)
                            if($smenu['id']==$menu['parent'] && empty($smenu['this_selected'])){
                                $menus[$skmenu]['has_selected'] = true;
                                break;
                            }
                    continue;
                }
            }
        }
        /* end precheck */
        $s = '<ul id="nav">';
        foreach($menus as $menu){
            if ($menu['parent'] > 0) continue;
            $class = !empty($menu['has_selected'])  ? ' class="adminmenu_has_selected" '  : '';
            $class = !empty($menu['this_selected']) ? ' class="adminmenu_this_selected" ' : $class;
            $s .= sprintf('<li %s><a href="%s" title="%s" mce_href="%s">%s</a>',
                    $class, $menu['url'], $menu['descr'], $menu['url'], $menu['name']);
            $sm = array();
            foreach($menus as $smenu){
                if ($smenu['parent'] != $menu['id']) continue;
                $sclass = !empty($smenu['has_selected'])  ? ' class="adminmenu_has_selected" '  : '';
                $sclass = !empty($smenu['this_selected']) ? ' class="adminmenu_this_selected" ' : $sclass;
                $sm[] = sprintf('<li %s><a href="%s" title="%s" mce_href="%s">%s</a></li>',
                                $sclass, $smenu['url'], $smenu['descr'], $smenu['url'], $smenu['name']);
            }
            if ($sm)
                $s .= "\n<ul>" . join('', $sm). "</ul>";

            $s .= "\n</li>";
        }
        $s .= "</ul>";
        return $menujs . "\n\n".$s;
    }

    public function xself(){
        $q = trim( stripslashes($_GET["q"]) );
        $q = mysql_real_escape_string($q);

        $for_field = mysql_real_escape_string($_GET['field']);
        $search = mysql_real_escape_string($_GET['search']);
        $fields = explode("|", $search);
        $name  = mysql_real_escape_string($_GET['name']);

        $current = null;
        foreach($this->fields as $f)
            if ( $f['field'] == $for_field )
                $current = $f;

        if ( $current === null )
            return '##ERROR##';

        $where = array();
        foreach($fields as $field){
            $where[] = " `$field` LIKE '%$q%' ";
        }
        $where = join(" OR ", $where);

        $ord = '';
        if ($current['type'] == "ManyToMany"){
            $ord = trim($current['values']['value'], "{ }");
            $ord = " ORDER BY `$ord` DESC ";
        }
        else{
            $ord = !empty($current['values']['other_value']) ? "ORDER BY `{$current['values']['other_value']}` DESC" : '';
            $ord = !empty($current['values']['other_id']) ? "ORDER BY `{$current['values']['other_id']}` DESC" : $ord;
            $ord = !empty($current['values']['other_id']) ? "ORDER BY `{$current['values']['other_id']}` DESC" : $ord;
        }
        $ord = $ord ? $ord : 'ORDER BY `id` DESC';
        $query = $current['values']['opt_query'] . ' AND ' . $where . " $ord LIMIT 0 , 30";
        if ( strlen($q) < 4 )
            $query = $current['values']['opt_query']." $ord LIMIT 0 , 30";
        $query = $this->filter->createText($query, $current['values']);

        $x = $this->mngrDB->mysqlGet($query);

        $hint=array();

        foreach ($x as $k=>$v){

            $hvalue = addslashes($this->filter->createText($current['values']['text'], $v));
            $img = "";
            $value = $this->filter->createText($current['values']['value'], $v);
            if (!empty($current['values']['subtype']['image_field'])){
                $image = $current['values']['subtype']['image_field'];
                $img = '<a href="javascript: add(\'%s\', \'%s\', \'%s\');" ><img src="%s" style="height:50px;" /></a>';
                $img = sprintf($img, $name, $value, $hvalue, $v[$image]);
            }
            $f = '<li>%s<a href="javascript: add(\'%s\', \'%s\', \'%s\');" >%s</a></li>';
            
            $hint[] = sprintf($f, $img, $name, $value, $hvalue, $hvalue);
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
    }
    
    function xself_extended(){
        //
        //params:
        //  current fieldname
        //  search table
        //  search where additional
        //  search with morhy or simple %like%
        //  column to return 
        //
        
        $field = !empty($this->fields[$_REQUEST['field']]) ? $this->fields[$_REQUEST['field']] : false;
        
        
    }
}

class SAdminDebuger{
    static protected $instance = null;    
    protected function __construct($admin){
        $this->admin  = $admin;
        $this->mngrDB = $admin->mngrDB;
    }
    private function __clone()    { /* ... @return Singleton */ }  // Защищаем от создания через клонирование
    private function __wakeup()   { /* ... @return Singleton */ }  // Защищаем от создания через unserialize
    public static function getInstance($admin) {    // Возвращает единственный экземпляр класса. @return Singleton
        if (is_null(self::$instance)) {
            self::$instance = new self($admin);
        }
        return self::$instance;
    }
    
    public static function logIt($admin, $text, $error=false){
        $ins = self::getInstance($admin);
        $ins->log($text, $error);
    }
    
    public    $admin  = null;
    public    $mngrDB = null;
    protected $table  = 'admindebug';
    protected $id     = false;
    
    protected $cache  = '';
    
    protected function getStamp(){
        $usec = explode(' ', microtime());
        $usec = intval(($usec[0]*1000)%1000);
        return date('[Y-m-d H:i:s:'.$usec.']');
    }
    public function log($text, $error=false){
        $old = $this->getCurrent();
        $arr = array();
        $arr['text'] = $old . $this->getStamp() . ' ' . $text . "\n";
        if ($error) $arr['error'] = 1;
        
        $this->cache = $arr['text'];
        $this->mngrDB->mysqlUpdateArray($this->table, $arr, " `id`='{$this->id}' ", true);
    }
    
    protected function getCurrent(){
        if (empty($this->id)) 
            return $this->createCurrent();
        $text = $this->cache; //$this->mngrDB->mysqlGetOne("SELECT `text` FROM `{$this->table}` WHERE `id`='{$this->id}' LIMIT 1");
        //$text = $text ? $text['text'] : '';
        return $text;
    }
    
    protected function createCurrent(){
        if ($this->id) return '';
        $this->checkTable();
        
        $this->mngrDB->mysqlInsertArray($this->table, array('text'=>'', 'error'=>0), true);
        $this->id = mysql_insert_id($this->mngrDB->dbConn);
        return '';
    }
    
    protected function checkTable(){
        //create table for debug
        $query = "CREATE TABLE IF NOT EXISTS `admindebug` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `text` longtext NOT NULL,
                    `error` tinyint(1) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;";
        mysql_query($query, $this->mngrDB->dbConn);
    }
}

$SADMIN_UPDATER_ENABLED = true;

class SAdminUpdater{
    /*
     * Check:
     *    1. Check cURL
     *    2. Check is update available
     *    3. Get current version
     *    4. Compare versions
     *    5. Check write permissions
     *    6. Render page
     * Update:
     *    1. Download file and check it md5 with data from update
     *    2. Create buckup (compress ./common to ./temporal/yyyymmddHHiiss.tar.gz)
     *    3. Copy whitelisted files to temporal files
     *    4. Remove all files from ./common
     *    5. Unpack files from downloaded archive
     *    6. Copy whitelisted files
     *    7. Start afterupdate functions 
     *    8. Render page
     */
    
    public  $enabled         = true;
    private $canBeUpdated    = null;
    private $update          = array(); //current available update
    private $downloaded      = ''; //path to downloaded archive with new admin
    private $bukuped         = ''; //path to buckup archive
    private $unpacked        = ''; //unpacked files from archive
    
    public  $update_server   = 'http://update.computers.net.ua/';               //url to update server
    public  $admin           = null;                                            //instance of admin class (caller)
    public  $adminPath       = '';                                              //path to admin folder, like '/admin'
    public  $deleteWhiteList = array(                                           //relative to adminpath
        '/common/admin_fnc.php', //dont delete admin config file
    ); 
    
    public  $errors    = array(); //list errors
    public  $checker   = array(); //list messages from check
    
    private $templateName = 'update.html';
    
    public function __construct($admin) {
        $this->admin = $admin;
        $this->adminPath = $admin->path_to_admin;
        
        SAdminDebuger::logIt($this->admin, "Updater: initialized");
    }
    
    private function checkPermission(){
        $res = true;
        $res = $this->recursivePerm($this->pathJoin($this->getFullPath(), 'common'))   ? $res : false; //check permission on "common" folder
        $res = $this->recursivePerm($this->pathJoin($this->getFullPath(), 'bukups'))   ? $res : false; //check permission on "bukups" folder
        $res = $this->recursivePerm($this->pathJoin($this->getFullPath(), 'temporal')) ? $res : false; //check permission on "temporal" folder
        return $res;
    }
    
    private function check($text, $color){
        SAdminDebuger::logIt($this->admin, "Updater say: $text [$color]");
        return $this->checker[] = array('message'=>$text, 'color'=>$color);
    }
    
    private function error($text){
        SAdminDebuger::logIt($this->admin, "Updater error: ".$text, 1);
        return $this->errors[] = array('message'=>$text);
    }
    
    private function recursivePerm($path){
        if (!is_writeable($path)){
            $this->error("Невозможна запись в директорию ".$path);
            return false;
        }
        $data = $this->listDir($path);
        //files
        $error = false;
        foreach($data['files'] as $file){
            if (is_writeable($file['path'])) continue; //this is good - go to next
            $this->error("Невозможна запись по пути ".$file['path']);
            $error = true;
        }
        foreach($data['dirs'] as $dir){
            if (is_writeable($dir['path'])){
                if ( !$this->recursivePerm($dir['path']) ) $error = true; //error in childs dirs/files
                continue;
            }
        }
        
        return !$error;
    }
    
    
    private function buckup(){
        $archiveName = $this->pathJoin($this->getFullPath(), 'bukups', date("YmdHis").'.zip');
        
        SAdminDebuger::logIt($this->admin, "Updater: Buckup will be saved to ".$archiveName);
        try{
            $commondir = $this->pathJoin($this->getFullPath(), 'common');
            $zip = new ZipArchive();
            $zip->open($archiveName, ZIPARCHIVE::CREATE);
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($commondir));
            $removepath = rtrim($this->getFullPath(), '/\\ ').'/';
            foreach ($iterator as $key=>$value) {
                $basename = basename($key);
                if ($basename == '.' || $basename == '..') continue;
                $zip->addFile($key, str_replace($removepath, '', $key));
            }
            $zip->close();
        }
        catch (Exception $ex){
            SAdminDebuger::logIt($this->admin, "Updater: Error while compress: ".$ex->getMessage());
            $this->error("Ошибки при сохранении резервной копии: ".$ex->getMessage());
            return false;
        }
        SAdminDebuger::logIt($this->admin, "Updater: file was compressed");
        $this->bukuped = $archiveName;
        return true;
    }
    
    private function checkUpdate(){
        //get content
        $fromv = $this->version_time();
        $fromv = $fromv ? "?from=".$fromv : '';
        $ch = curl_init(rtrim($this->update_server, '/ ').'/getit.php'.$fromv);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        
        SAdminDebuger::logIt($this->admin, "Updater: get update data: ".$data);
        $update = json_decode($data, true);
        $this->update = $update;
        return $update;
    }
    
    public function version_time(){
        return strtotime(trim(file_get_contents($this->pathJoin($this->getFullPath(), 'common/_create_date.txt'))));
    }
    
    public function version(){
        $data = trim(file_get_contents($this->pathJoin($this->getFullPath(), 'common/_create_date.txt')));
        $version = date("Y-m-d H:i:s", strtotime($data));
        SAdminDebuger::logIt($this->admin, "Updater: get current version: ".$version);
        return $version;
    }
    
    private function checkCurl(){
        $exists = function_exists("curl_init");
        SAdminDebuger::logIt($this->admin, "Updater: cURL is ".($exists?"":"not ")."exists", !$exists);
        return $exists;
    }
    
    private function checkPhar(){
        $res = false;
        try{
            $res = Phar::canCompress(Phar::GZ);
        }catch (Exception $ex){
            SAdminDebuger::logIt($this->admin, "Updater: Phar exceprion: ".$ex->getMessage());
            $res = false;
        }
        
        return $res;
    }
    
    private function download(){
        //location for downloaded file
        $loc = $this->pathJoin($this->getFullPath(), 'temporal', date("YmdHis", $this->update['time']).'.tar.gz');
        SAdminDebuger::logIt($this->admin, "Updater: Archive save location: ".$loc);
        
        $file = fopen($loc, "w+b");
        if ($file === false){
            SAdminDebuger::logIt($this->admin, "Updater: Error - cant create file ".$loc, 1);
            $this->error("Невозможно создать файл для записи архива по пути: ".$loc);
            return false;
        }
        
        $ch = curl_init(rtrim($this->update_server, '/ ').'/getit.php?getit=1');
        curl_setopt($ch, CURLOPT_FILE, $file); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_exec($ch);
        curl_close($ch);
        
        //check md5
        if ($this->update['md5'] != md5_file($loc)){
            $this->error("Ошибка скачивания файла. Несовпадение контрольных сумм");
            return false;
        }
        
        SAdminDebuger::logIt($this->admin, "Updater: File downloaded to ".$loc);
        
        $this->downloaded = $loc;
        
        return $loc;
    }
    
    private function clearTemporal(){
        $items = $this->listDir($this->pathJoin($this->getFullPath(), 'temporal'));
        foreach($items['files'] as $file){
            $this->_delete($file['path']);
        }
        foreach($items['dirs'] as $dir){
            $this->recursiveDelete($dir['path']);
        }
    }
    
    private function buildWhiteList(){
        $whitelist = array();
        foreach($this->deleteWhiteList as $item)
            $whitelist[] = $this->pathJoin ($this->getFullPath (), $item);
        return array_filter(array_unique($whitelist));
    }
    
    
    private function deleteFiles(){
        SAdminDebuger::logIt($this->admin, "Updater: Start remove files");
        //create fullpath whitelist
        
        $result = $this->recursiveDelete($this->pathJoin($this->getFullPath(), 'common'), $this->buildWhiteList());
    }
    
    private function _delete($path){
        if (is_dir($path)){
            if (!@rmdir($path)){
                //$this->error("Неудачная попытка удалить папку {$path}");
                return false;
            }
        }
        else{
            try{ unlink($path); }
            catch(Exception $ex){
                $this->error("Неудачная попытка удалить файл {$path} потому что: {$ex->getMessage()}");
                return false;
            }
        }
        return true;
    }
    
    private function recursiveDelete($path, $whitelist=array()){
        if (in_array($path, $whitelist)) 
                return true; // this folder is in white list. skip it with files within
        $data = $this->listDir($path);
        //files
        $error = false;
        foreach($data['files'] as $file){
            if (in_array($file['path'], $whitelist)) continue; //skip whitelisted files
            if (!$this->_delete($file['path'])) $error = true;
        }
        foreach($data['dirs'] as $dir){
            if ( !$this->recursiveDelete($dir['path'], $whitelist) ) $error = true; //error in childs dirs/files
        }
        
        //delete this folder
        if (!$this->_delete($path)) $error = true;
        return !$error;
    }
    
    private function unpack(){
        SAdminDebuger::logIt($this->admin, "Updater: Start unpack archive");
        $file = $this->downloaded;
        $path = $this->pathJoin($this->getFullPath(),'temporal', date('YmdHis'));
        mkdir($path);
        
        SAdminDebuger::logIt($this->admin, "Updater: Unpack from $file to $path");
        
        $phar = new PharData($file);
        $res  = $phar->extractTo($path, null, true); //extract all files to $path (temporal folder) with overwrite exists files
        
        if (!$res){
            $this->error("Ошибка при распаковке");
            return false;
        }
        
        $this->unpacked = $path;
        return $path;
    }
    
    private function copyNew($unpacked){
        $from = $this->pathJoin($unpacked, 'common');
        $to   = $this->pathJoin($this->getFullPath(), 'common');
        $result = $this->recursiveCopy($from, $to);
        return $result;
    }
    
    private function _copy($from, $to, $overwrite=false){
        if (!is_file($from)){
            SAdminDebuger::logIt($this->admin, "Updater: Copy file failed. This is folder: $from", 1);
            return false;
        }
        if (is_dir($to)){
            $to = $this->pathJoin($to, basename($from));
        }
        if (!file_exists($from)){
            SAdminDebuger::logIt($this->admin, "Updater: Copy file failed. File not found: $from", 1);
            return false; //file not exists
        }
        if (!$overwrite && file_exists($to)){
            SAdminDebuger::logIt($this->admin, "Updater: Skip file copy ( Exists $to )");
            return true;
        }
        
        if (!@copy($from, $to)){
            SAdminDebuger::logIt($this->admin, "Updater: Copy file failed. $from");
            return false;
        }
        
        return true;
    }
    
    private function recursiveCopy($from, $to, $overwtire=false){
        if (is_file($from)) 
            return $this->_copy ($from, $to, $overwtire); //one file copy
        $items = $this->listDir($from);
        
        $result = true; 
        
        //copy files
        foreach($items['files'] as $file){
            if (!$this->_copy($file['path'], $to)){
                SAdminDebuger::logIt($this->admin, "Updater: Create file failed. {$file['path']}", 1);
                $result = false;
            }
        }
        
        foreach($items['dirs'] as $dir){
            $dirfull = $this->pathJoin($to, $dir['name']);
            if (!file_exists($dirfull))
                if (!@mkdir($dirfull)){
                    SAdminDebuger::logIt($this->admin, "Updater: Create dir failed. $dirfull", 1);
                    $result = false;
                }
            if (!$this->recursiveCopy($dir['path'], $dirfull, $overwtire)){
                SAdminDebuger::logIt($this->admin, "Updater: Copy dir failed. {$dir['path']}", 1);
                $result = false; //copy directory
            }
        }
        
        return $result;
        
    }
    
    //get full path to admin folder
    private function getFullPath(){
        return $this->pathJoin($_SERVER['DOCUMENT_ROOT'], $this->adminPath);
    }
    
    /**
     * Join parts of path to one
     * @param String $_ parts of path
     * @return String Results path
     */
    private function pathJoin($_){
        $trim = '/\\ ';
        $path = '';
        foreach(func_get_args() as $arg){
            $path = rtrim($path, $trim).'/'.ltrim($arg, $trim);
        }
        return $path;
    }
    
    private function listDir($path){
        $dir   = dir($path);
        $dirs  = array();
        $files = array();
        while (false !== ($entry = $dir->read())){
            if ($entry == '.' || $entry == '..') continue;
            $curpath = $this->pathJoin($path, $entry);
            if (is_dir($curpath))
                $dirs[]  = array('name'=>$entry, 'path'=>$curpath, 'type'=>'dir');
            else
                $files[] = array('name'=>$entry, 'path'=>$curpath, 'type'=>'file');
        }
        $ret = array('dirs'=>$dirs, 'files'=>$files);
        return $ret;
    }
    
    private function context(){
        $c = array();
        $c['errors'] = $this->errors;
        $c['check']  = $this->checker;
        $c['canBeUpdated'] = $this->canBeUpdated;
        $c['update'] = $this->update;
        
        return $c;
    }
    
    private function render(){
        $template = $this->pathJoin($this->getFullPath(), 'common/templates', $this->templateName);
        $h2o = new H2o($template);
        $context = $this->context();
        $context['x'] = 'xx';
        echo $h2o->render($context);
        exit();
    }
    
    private function isCanBeUpdated(){
        if (!is_null($this->canBeUpdated)) return $this->canBeUpdated;
        $this->canBeUpdated = true;
        
        $version  = $this->version();
        $vertime  = strtotime($version);
        
        $curl     = $this->checkCurl();
        
        if (!$curl){
            $this->check("cURL не доступен. Без него обновления не будет.", 'red');
            $this->canBeUpdated = false;
        }
        else{
            $this->check("cURL доступен", 'green');
        }
        
        if (!$this->checkPhar()){
            $this->check("Ваш PHP не поддерживает расширение Phar. Продолжение невозможно.", 'red');
            $this->canBeUpdated = false;
        }
        else{
            $this->check("Phar (gz) поддерживается", 'green');
        }
        
        if (!$vertime){
            $this->check("Версия вашего программного обеспечения неизвестна", 'orange');
        }
        else{
            $this->check("Версия вашего программного обеспечения: ".$version, 'green');
        }
        
        
        $update   = $this->checkUpdate();
        if (!$update || empty($update['date'])){
            $this->check("Невозможно получить информацию о доступных обновлениях", 'red');
            $this->canBeUpdated = false;
        }
        else {
            $this->check("Последняя доступная версия: ".$update['date'], 'green');
        }
        
        if ($update['time'] <= $vertime){
            $this->check("Ваша версия не нуждается в обновлении", 'green');
            $this->canBeUpdated = false;
        }
        
        //check permissions
        if (!$this->checkPermission()){
            $this->check("Ваша система не готова к обновлениям. Отсутствуют необходимые права на запись в директории.", 'red');
            $this->canBeUpdated = false;
        }
        else{
            $this->check("Права доступа к директориям корректны", 'green');
        }
        
        SAdminDebuger::logIt($this->admin, "Updater: PreUpdate check is complete. System is ".($this->canBeUpdated ? "" : "not ")."ready to update");
        return $this->canBeUpdated;
    }
    
    private function update(){
        //start update sequence
        if (!$this->enabled){
            $this->error("Обновление отключено");
            return false;
        }
        
        if (!$this->isCanBeUpdated()){
            $this->error("Продолжение обновления не возможно до устранения проблем выявленных при проверке.");
            return false;
        }
        
        if (!$this->update || empty($this->update['date'])){
            $this->error("Не получены сведения о доступном обновлении.");
            return false;
        }
        
        
        $archive = $this->download();
        if (!$archive){
            $this->error("Загрузка новой копии не удалась. Прерывание.");
            return false;
        }
        
        
        if (!$this->buckup()){
            $this->error("Сохранение резервной копии не удалось. Прерывание.");
            return false;
        }
        
        $unpacked = $this->unpack();
        if (!$unpacked){
            $this->error("Распаковка архива не удалась.");
            return false;
        }
        
        $this->deleteFiles();
        
        $copied = $this->copyNew($unpacked);
        if (!$copied){
            $this->error("Копирование новых файлов завершилось с ошибкой! Это плохо. Возможно административный интерфейс теперь не работает.");
        }
        
        SAdminDebuger::logIt($this->admin, "Try execute afterfunc...");
        require_once ($this->pathJoin($this->getFullPath(), 'common', 'update_afterfnc.php'));
                
        SAdminDebuger::logIt($this->admin, "Update done..\n\n");
        return true;
    }
    
    private function actionUpdate(){
        $this->isCanBeUpdated();
        $result = $this->update();
        
        if (!$result){
            $this->error("При обновлении произошли ошибки!");
        }
        
        //clear temporal files
        $this->clearTemporal();
        
        $this->checker = array();
        
        $this->canBeUpdated = null;
        $this->isCanBeUpdated();
        
        $this->render();
    }
    
    private function actionCheck(){
        $this->isCanBeUpdated();
        $this->render();
    }
    
    private function actionSync(){
        $this->isCanBeUpdated();
        SAdminDebuger::logIt($this->admin, "Try execute afterfunc from sync option...");
        require_once ($this->pathJoin($this->getFullPath(), 'common', 'update_afterfnc.php'));
        $this->render();
    }
    
    public function DoAction(){
        if (!$this->enabled){
            echo "Updates are disabled!";
            exit();
        }
        
        $action = !empty($_REQUEST['updateaction']) ? $_REQUEST['updateaction'] : '';
        $this->action = $action; // for render
        
        if (!$action){
            //check for update only
            $this->actionCheck();
        }
        
        if ($action == 'update'){
            //check and update
            $this->actionUpdate();
        }
        
        if ($action == 'sync'){
            //start autosync
            $this->actionSync();
        }
    }
}

class SAdminUser{
    public $h2o_safe = true;
    
    protected $data     = null;
    protected $group    = null;
    protected $mngrDB;
    
    protected $id       = null;
    protected $email    = null;
    
    public $table_users  = 'adminusers';
    public $table_groups = 'adminugroups';
    
    public $column_id    = 'id';
    public $column_email = 'email';
    public $column_group = 'group_id';
    public $column_gr_id = 'id';
    public $column_gr_al = 'alias';
    
    public function __construct($mngrDBInstance=null) {
        if (is_null($mngrDBInstance)){
            global $mngrDB;
            $mngrDBInstance = $mngrDB;
        }
        
        $this->mngrDB = $mngrDBInstance;
    }
    
    public function load($id){
        $id = mysql_real_escape_string($id);
        $this->data = $this->mngrDB->mysqlGetOne("SELECT * FROM `{$this->table_users}` WHERE `{$this->column_id}`='$id' LIMIT 1");
        if (!$this->data) return;
        
        $this->id = $this->data[$this->column_id];
        
        $this->loadGroup();
    }
    
    public function loadByEmail($email){
        $email = mysql_real_escape_string($email);
        $this->data = $this->mngrDB->mysqlGetOne("SELECT * FROM `{$this->table_users}` WHERE `{$this->column_email}`='$email' LIMIT 1");
        if (!$this->data) return;
        
        $this->id = $this->data[$this->column_id];
        
        $this->loadGroup();
    }
    
    protected function loadGroup(){
        if (!$this->isValid()) return; //user is not loaded
        $group_id = mysql_real_escape_string($this->data[$this->column_group]);
        $this->group = $this->mngrDB->mysqlGetOne("SELECT * FROM `{$this->table_groups}` WHERE `{$this->column_gr_id}`='{$group_id}' LIMIT 1");
        
        $this->data['user_group_data'] = $this->group;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getEmail(){
        return $this->isValid() ? $this->data[$this->column_email] : null;
    }
    
    public function getData($key){
        if (!$this->isValid()) 
            return null;
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }
    
    public function getDataGroup($key){
        if (!$this->isValid()) 
            return null;
        return array_key_exists($key, $this->group) ? $this->group[$key] : null;
    }
    
    public function getDataAll(){
        if (!$this->isValid()) 
            return null;
        return $this->data;
    }
    
    public function getDataGroupAll(){
        if (!$this->isValid()) 
            return null;
        return $this->group;
    }
    
    public function getGroupAlias(){
        return $this->getDataGroup($this->column_gr_al);
    }
    
    public function isValid(){
        return $this->data ? true : false;
    }
}

class SAdminRights{
    
    public static $WRITE = 2;
    public static $READ  = 1;
    public static $NONE  = 0;
    
    protected $mngrDB;
    protected $dump = array();
    
    public function __construct($mngrDBInstance=null) {
        if (is_null($mngrDBInstance)){
            global $mngrDB;
            $mngrDBInstance = $mngrDB;
        }
        
        $this->mngrDB = $mngrDBInstance;
    }
    
    public function valueRead(){
        return self::$READ;
    }
    
    public function valueWrite(){
        return self::$WRITE;
    }
    
    public function valueNone(){
        return self::$NONE;
    }
    
    public function setRights($group_alias, $rigths, $additional=null){
        $rigths = intval($rigths);
        if (!in_array($rigths, array(self::$WRITE, self::$READ, self::$NONE)))
            $rigths = self::$NONE; //bad rights id.. set to default "0"
        $this->dump[$group_alias] = array('rights'=>$rigths, 'additional'=>$additional);
    }
    
    
    /**
     * Set multiple rights with one argument
     * @param <Array> $map - array( array('groupalias', SAdminRights::level, '?additional') )
     */
    public function setRightsMap($map){
        foreach($map as $arr){
            if (count($arr) < 1) continue;
            $alias  = $arr[0];
            $rights = count($arr) > 1 ? $arr[1] : $this->rights->valueRead();
            $data   = count($arr) > 2 ? $arr[2] : null;
            
            $this->setRights($alias, $rights, $data);
        }
    }
    
    public function getRights($group_alias){
        if (empty($this->dump)) return self::$WRITE; //return full access if rights not configured for current instance
        return array_key_exists($group_alias, $this->dump) ? $this->dump[$group_alias]['rights'] : self::$NONE;
    }
    
    public function isCanRead($group_alias){
        $r = $this->getRights($group_alias);
        return in_array($r, array(self::$WRITE, self::$READ));
    }
    
    public function isCanWrite($group_alias){
        $r = $this->getRights($group_alias);
        return $r === self::$WRITE;
    }
    
    public function getAdditional($group_alias){
        return array_key_exists($group_alias, $this->dump) ? $this->dump[$group_alias]['additional'] : self::$NONE;
    }
    
    protected function isEmptyRights(){
        return empty($this->dump);
    }
}



require_once 'functions.php';
require_once 'phpmorphy/common.php';

#classes
require_once 'classes/SAdminMassResizer.php';