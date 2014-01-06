<?php

//require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/h2o/h2o.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/comments/config.php'; //hybrydauth config here
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/comments/hybridauth/Hybrid/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/common/mail.php';



class Comments{
    public    $hybridauth = null;
    protected $mngrDB;
    protected $provider   = null;
    public    $user       = array();
    public    $profile    = array();
    protected $config     = array();
    public    $page_id    = '';
    public    $page_name  = '';
    public    $forcejquery= false;
    public    $delete     = false;

    //
    public    $xerrors    = array();
    public    $xnotify    = array();

    public    $reload_delay = 30;


    function __construct($page_id, $page_name='', $config=false, $forcejquery=false){
        global $mngrDB, $HYBRIDAUTH_CONFIG;
        $this->page_id    = $page_id;
        $this->mngrDB     = $mngrDB;
        $this->forcejquery= $forcejquery;
        $this->page_name  = $page_name;
        if (!$config){
            global $HYBRIDAUTH_CONFIG;
            $config = $HYBRIDAUTH_CONFIG;
        }
        $this->config     = $config;
        $this->hybridauth = new Hybrid_Auth($this->config);
        $stored_data = $this->sessionRestore();
        if (unserialize($stored_data)){
            $this->hybridauth->restoreSessionData( $stored_data );
            $providers = $this->hybridauth->getConnectedProviders();
            if ($providers) $this->prepareProvider($providers[0]);
        }
        if (!empty($config['reload_delay']))
            $this->reload_delay = intval($config['reload_delay']);
    }

    public function getJqueryString(){
        return '<script src="/modules/comments/templates/jquery-1.8.0.min.js"></script>';
    }
    public function getCssString(){
        return '<link rel="stylesheet" type="text/css" href="/modules/comments/templates/style.css">';
    }

    protected function prepareUser($provider, $identifier){
        $provider = mysql_real_escape_string($provider);
        $identifier = mysql_real_escape_string($identifier);
        $user = $this->mngrDB->mysqlGetOne("SELECT * FROM comments_users WHERE `provider`='$provider' AND `identifier`='$identifier' LIMIT 1");
        return $user ? $user : array();
    }

    public function prepareProvider($provider){
        if (!$this->isProviderExists($provider)){
            $this->sessionStore(serialize(array()));
            return;
        }
        if (!$this->hybridauth->isConnectedWith($provider)){
            return;
        }
        $adapter = null;
        $profile = null;

        try{
            $adapter = $this->hybridauth->getAdapter($provider);
            $profile = $adapter->getUserProfile();
        }
        catch(Exception $ex){
            $this->sessionStore(serialize(array()));
            return;
        }
        
        $this->profile = $profile;


        //get user
        $this->user = $this->prepareUser($provider, $profile->identifier);
        $displayName = $profile->displayName ? $profile->displayName : $profile->firstName." ".$profile->lastName;
        if (!$this->user){
            //user not exists
            //create virtual user
            $user = array();
            $user['provider']   = $provider;
            $user['identifier'] = $profile->identifier;
            $user['photo']      = $profile->photoURL;
            $user['name']       = $displayName;
            $user['profile']    = $profile->profileURL;
            $this->user = $user;
            return;
        }

        //update user info
        $update = array();
        if ($profile->photoURL != $this->user['photo'])
                $update['photo'] = $profile->photoURL;
        if ($displayName != $this->user['name'])
                $update['name'] = $displayName;
        if ($profile->profileURL != $this->user['profile'])
                $update['profile'] = $profile->profileURL;

        $e_provider   = mysql_real_escape_string($provider);
        $e_identifier = mysql_real_escape_string($this->user['identifier']);
        if ($update)
            $this->mngrDB->mysqlUpdateArray( 'comments_users', $update, " `provider`='$e_provider' AND `identifier`='$e_identifier' ");

        //reload user
        $this->user = $this->prepareUser($provider, $profile->identifier);
    }
    
    public function getFullPage(){
        $context = array();
        $context['form']        = $this->getForm();
        $context['list']        = $this->getList();
        $context['forcejquery'] = $this->forcejquery;
        $context['page_id']     = $this->page_id;
        $context['page_name']   = $this->page_name;
        $context['reload_delay']= $this->reload_delay;
        
        $h2o = new H2o($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/base.html');
        $ret = $h2o->render($context);
        return $ret;
    }
    public function getForm(){
        $form = '<b style="color: red;">error</b>';
        if ($this->user){
            //create text area
            $context = array();
            $context['user'] = $this->user;
            $context['provider'] = $this->config['providers'][$this->user['provider']];
            $context['provider']['name'] = $this->user['provider'];
            $h2o = new H2o($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/form.html');
            return $h2o->render($context);
        }
        else{
            //create login form
            $context = array();
            $context['providers'] = array();
            foreach($this->config['providers'] as $key=>$value){
                if (!$value['enabled']) continue;
                $provider = array();
                $provider['name']   = $key;
                $provider['icon']   = $value['icon'];
                $provider['button'] = $value['button'];
                //
                $context['providers'][] = $provider;
            }

            $h2o = new H2o($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/login.html');
            return $h2o->render($context);
        }
        return $form;
    }
    public function getList(){
        $page_id  = mysql_real_escape_string($this->page_id);
        $messages = $this->mngrDB->mysqlGet("SELECT m.*, u.profile, u.photo, u.identifier, u.provider, u.name
                                             FROM comments_messages as m, comments_users as u
                                             WHERE m.page_id='$page_id' AND u.id=m.user_id ORDER BY m.date");
        foreach($messages as $key=>$value){
            if (empty($value['photo'])) 
                $messages[$key]['photo'] = '/modules/comments/images/no_avatar.png';
        }
        $context = array();
        $context['messages'] = $this->_message_tree(0, $messages);
        $context['messages_count'] = count($messages);
        $h2o = new H2O($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/list.html');
        return $h2o->render($context);

    }
    public function getNotify(){
        $context = array();
        $context['errors'] = $this->xerrors;
        $context['notify'] = $this->xnotify;
        $h2o = new H2O($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/notify.html');
        return $h2o->render($context);
    }

    private function _message_tree($parent, &$messages){
        $ret = array();
        foreach($messages as $m){
            if ($m['parent'] != $parent) continue;
            //create message context
            $mc = array_merge($m, array());
            $mc['logo']    = !empty($this->config['providers'][$m['provider']]['icon']) ? $this->config['providers'][$m['provider']]['icon'] : '';
            $mc['childs']  = $this->_message_tree($m['id'], $messages);
            $mc['xdate']   = date('d.m.Y | H:i', strtotime($mc['date']));
            $mc['user']    = $this->user;
            $mc['delete']  = $this->delete;
            $h2o   = new H2O($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/message.html');
            $ret[] = $h2o->render($mc);
        }
        return join('<br/>', $ret);
    }

    public function userGetSid(){
        $sid = empty($_COOKIE['comments_id']) ? "" : mysql_real_escape_string($_COOKIE['comments_id']);
        return $sid ? $sid : '';

    }
    public function userSetSid($seed=''){
        $sid = md5(time().rand(1000, 999999).getmygid().$seed);
        setcookie('comments_id', $sid, time()+60*60*24*365, '/');
        return $sid;
    }

    protected function isProviderExists($provider){
        return array_key_exists($provider, $this->config['providers']) && $this->config['providers'][$provider]['enabled'];
    }

    public function login(){
        //check user
        if ($_REQUEST['comments_action'] == 'login_ok'){
            //last step login (save session)
            $this->sessionStore($this->hybridauth->getSessionData());
            return;
        }
        if ($this->user){
            return;
        }
        //check provider exists
        $provider = $_REQUEST['provider'];
        if (!$this->isProviderExists($provider)){
            return;
        }
        try{
            $sid     = $this->userGetSid();
            if ($sid) mysql_query("DELETE FROM comments_sessions WHERE `sid`='$sid'");
            $adapter = $this->hybridauth->authenticate($provider,
                    array('hauth_return_to'=>'http://'.$_SERVER['HTTP_HOST'].'/index.php?type=comments&comments_action=login_ok'));
        }
        catch (Exception $e){
            echo "Error!";
            exit;
        }

    }

    public function logout(){
        if (!$this->user)
                return;
        try{
            $this->hybridauth->logoutAllProviders();
            $this->sessionStore($this->hybridauth->getSessionData());
        }
        catch (Exception $e){
            echo "Logout error";
        }
    }
    
    protected function sessionStore($data){
        $sid = $this->userGetSid();
        if (!$sid)
            $sid = $this->userSetSid($data);

        if (!$sid)
            return; //error! i cant create sid (why?)

        if (!unserialize($data)){
            mysql_query("DELETE FROM comments_sessions WHERE `sid`='$sid'");
            return;
        }

        if ($this->mngrDB->mysqlGetCount('comments_sessions', " `sid`='$sid' ")>0){
            $this->mngrDB->mysqlUpdateArray( 'comments_sessions', array('data'=>$data), " `sid`='$sid' ", 1);
        }
        else{
            $arr = array();
            $arr['sid']  = $sid;
            $arr['data'] = $data;
            $this->mngrDB->mysqlInsertArray('comments_sessions', $arr, 1);
        }
    }
    protected function sessionRestore(){
        $sid = $this->userGetSid();
        if (!$sid) return '';
        $ret = $this->mngrDB->mysqlGetOne("SELECT * FROM `comments_sessions` WHERE `sid`='$sid' LIMIT 1");
        return $ret ? $ret['data'] : '';
    }

    public function notify($text){
        $this->xnotify[] = $text;
    }
    public function error($text){
        $this->xerrors[] = $text;
    }

    public function createComment(){
        //check is user logged in
        if (!$this->user){
            $this->error("Сначала авторизуйтесь");
            return;
        }
        //get params
        $parent = !empty($_REQUEST['parent']) ? intval($_REQUEST['parent']) : 0;
        $text   = !empty($_REQUEST['text'])   ? strip_tags($_REQUEST['text']) : '';

        if (!$text){
            $this->error("Пустой комментарий");
            return;
        }
        if (mb_strlen($text, 'UTF-8') > 3000){
            $this->error("Слишком длинный комментарий");
            return;
        }

        //check parent
        if( $parent && ($this->mngrDB->mysqlGetCount('comments_messages', " `id`='$parent' ") < 1) ){
            $this->error("Не обнаружен комментарий для ответа");
            return;
        }

        //create text
        $text = nl2br($text);
        //create user
        if (!array_key_exists('id', $this->user)){
            //we dont have this user
            $this->mngrDB->mysqlInsertArray('comments_users', $this->user, 1);
            $new_id = mysql_insert_id($this->mngrDB->dbConn);
            if (!$new_id){
                $this->error("Ошибка сохранения пользователя");
                return;
            }
            $this->user['id'] = $new_id;
        }

        //save data
        $arr = array();
        $arr['page_id']   = $this->page_id;
        $arr['page_name'] = $this->page_name;
        $arr['parent']    = $parent;
        $arr['user_id']   = $this->user['id'];
        $arr['text']      = $text;
        $arr['url']       = !empty($_REQUEST['page_url']) ? preg_replace("{.comments_show=\d+}xui", '', $_REQUEST['page_url']) : '';

        $this->mngrDB->mysqlInsertArray('comments_messages', $arr, 1);
        $this->notify("Сообщение добавлено успешно");
        $new_comment_id = mysql_insert_id($this->mngrDB->dbConn);
        
        $this->notificate($new_comment_id, $arr);
        
        return $new_comment_id;
    }
    
    protected function notificate($new_comment_id, $comment_data){

        $context = array();
        $context['host']       = $_SERVER['HTTP_HOST'];
        $context['comment']    = $comment_data;
        $context['comment_id'] = $new_comment_id;

        $h2o = new H2O($_SERVER['DOCUMENT_ROOT'].'/modules/comments/templates/comments_mail.html');

        $body = $h2o->render($context);
        $to = array('comment@computers.net.ua');
        $sender = 'comments@computers.net.ua';
        $sendername = 'Система комментирования Computers.net.ua';
        $subject = 'Добавлен новый комментарий к записи!';

        sendmail($sender, $sendername, $to, $subject, $body);
    }

    public function deleteComment(){
        if (!$this->delete){
            $this->error("Удаление комментариев отключено");
            return;
        }
        if (!$this->user || !isset($this->user['id'])){
            $this->error("Сначала авторизуйтесь");
            return;
        }
        $comment_id = !empty($_REQUEST['comment_id']) ? intval($_REQUEST['comment_id']) : 0;
        if (!$comment_id){
            $this->error("Невозможно найти комментарий");
            return;
        }
        $comment = $this->mngrDB->mysqlGetOne("SELECT m.*, u.profile, u.photo, u.identifier, u.provider, u.name
                                             FROM comments_messages as m, comments_users as u
                                             WHERE m.id='$comment_id' LIMIT 1");
        if (!$comment){
            $this->error("Невозможно найти комментарий.");
            return;
        }
        if ($comment['user_id'] != $this->user['id']){
            $this->error("Вы не имеете прав на изменение этого комментария");
            return;
        }

        //get childs
        $ids = $this->mngrDB->mysqlGet("SELECT m.id, m.parent FROM comments_messages as m WHERE m.parent!=0");
        $to_delete   = $this->_ids_tree($comment['id'], $ids);
        $to_delete[] = $comment['id'];

        $to_delete   = "'".join("', '", $to_delete)."'";
        mysql_query("DELETE FROM `comments_messages` WHERE `id` IN ($to_delete)", $this->mngrDB->dbConn);
        $this->notify("Сообщение удалено успешно");
    }

    private function _ids_tree($parent, &$ids){
        $ret = array();
        foreach($ids as $m){
            if ($m['parent'] != $parent) continue;
            $ret[]  = $m['id'];
            $childs = $this->_ids_tree($m['id'], $ids);
            if ($childs) $ret = array_merge($ret, $childs);
        }
        return $ret;
    }
}