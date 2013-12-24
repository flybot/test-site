<?php
/* ! --       shevayura       -- ! */

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/common/admin_fnc.php';

/*
 * Опишем таблицу.
 */
$admin->filter_query = "SELECT comments_messages.*, comments_users.name, comments_users.provider, comments_users.photo, comments_users.profile
    FROM comments_messages LEFT JOIN comments_users ON comments_messages.user_id=comments_users.id  WHERE 1";
$admin->DescribeTable($name     ="Комментарии - сообщения",   //Имя. Просто имя.
                      $table    = "comments_messages",  //Таблица. Нужна для создания запросов.
                      $change   = true,     //Массив полей доступных для изменения. Если пуст - менять ничего нельзя.
                      $delete   = true,     //Возможность удаления строк
                      $add      = true,     //Возможность добавления строк
                      $main_fld = 'id',      //Поле. Что-то типа ИД. Первичный ключ в таблице. Не повторяющийся.
                      $history  = true
        );
$admin->history_name = 'id';
$admin->filter->def_order = " ORDER BY date DESC ";



$admin->DescribeField("Идентификатор страницы",  "page_id",     "string",    array(0, 255), true );
$admin->DescribeField("URL страницы",            "url",         "string",    array(0, 255), true );
$admin->DescribeField("Название страницы",       "page_name",   "string",    array(0, 255), true );
$admin->DescribeField("Родительский комментарий","parent",      "string",    array(0, 255), true );
$admin->DescribeField("Пользователь",            "user_id",     "ForeignKey",
                      array(
                          'other_table'=>'comments_users',
                          'other_id'   =>'id',
                          'opt_query'  => "SELECT * FROM {{other_table}} WHERE 1",
                          'value'      =>"{{id}}",
                          'text'       =>"[{{provider}}] {{name}}",
                          'subtype'    => array('name'=>'xself', 'search_field'=>"name", "value_field"=>"id", "image_field"=>'photo', 'toadd'=>"/admin/comments/users.php"),
                          'required'   => false,
                      ), true);
$admin->DescribeField("Сообщение",               "text",        "text",      array(0,   0), true );
$admin->DescribeField("Дата создания",           "date",        "string",    array(0, 255), false );
$admin->DescribeField("Постмодерация",           "moderate",    "enum",    array(0=>'Не промодерировано', 1=>'Промодерировано'), true );



$admin->filter->AddAvailable("Пользователь", "user_id", "list", "SELECT *                 FROM `comments_users`    WHERE 1 ORDER BY provider, name", "id",       "[{{provider}}] {{name}}", 20);
$admin->filter->AddAvailable("Страница",     "page_id", "list", "SELECT DISTINCT page_id  FROM `comments_messages` WHERE 1 ORDER BY page_id",        "page_id",  "[{{page_id}}]",           20);
$admin->filter->AddAvailable("Провайдер",    "provider","list", "SELECT DISTINCT provider FROM `comments_users`    WHERE 1 ORDER BY provider",       "provider", "[{{provider}}]",          20);
$admin->filter->AddAvailable("Постмодерация","moderate","list_enum", "", $admin->fields['moderate']['values'], "{{value}}");

//user functions
function username($r, $f){
    return sprintf('<a href="/admin/comments/users.php?id=%s">%s</a>', $r['id'], $r['name']);
}

function userphoto($r, $f){
    return sprintf('<a href="%s"><img src="%s" style="max-width:50px; max-height:50px;"/></a>', $r['profile'], $r['photo']);
}

function pageurl($r, $f){
    $sstr = 'comments_show='.$r['id'];
    $url  = $r['url'];
    $name = $r['page_name'] ? $r['page_name'] : $r['page_id'];
    $name = mb_substr($name, 0, 20, 'UTF-8'). (mb_strlen($name, 'UTF-8')>20 ? '...' : '');
    if (!$url)
        return $name;
    $url  = strpos($url, '#') !== false && strpos($url, "?") !== false ? str_replace("#", "&$sstr#", $url) : $url;
    $url  = strpos($url, '#') !== false && strpos($url, "?") === false ? str_replace("#", "?$sstr#", $url) : $url;
    $url  = strpos($url, '#') === false && strpos($url, "?") !== false ? str_replace("?", "?$sstr&", $url) : $url;
    $url  = strpos($url, '#') === false && strpos($url, "?") === false ? "$url?$sstr" : $url;
    return sprintf('<a href="%s">%s</a>', $url, $name);
}

$header_printed = false;
function moderate_form($r, $f){
    global $header_printed;
    $h2o = new H2o($_SERVER['DOCUMENT_ROOT'].'/admin/comments/templates/moderate.html');
    $context = array_merge($r, array());
    $context['header_printed'] = $header_printed;
    $header_printed = true;
    return $h2o->render($context);
}

$admin->filter->AddField("ID",            'id',         1, '', null,   False);
$admin->filter->AddField("Provider",      'provider',   1, '', null,   False);
$admin->filter->AddField("Фото",          'photo',      0, '', 'userphoto',  False);
$admin->filter->AddField("Пользователь",  'name',       1, '', 'username',   False);
$admin->filter->AddField("Текст",         'text',       1, '', null,   False);
$admin->filter->AddField("Посмотреть",    'page_name',  1, '', 'pageurl', False);
$admin->filter->AddField("Постмодерация", 'moderate',   1, ' align="center" ', 'moderate_form', False);
$admin->filter->AddField("Дата",          'date',       1, '', null,   False);
$admin->filter->AddField("Страница (ид)", 'page_id',    1, '', null,   False, 1, 1);
$admin->filter->AddField("Родитель",      'parent',     1, '', null,   False, 1, 1);

if (isset($_REQUEST['showcommentstate'])){
    $id = intval($_REQUEST['showcommentstate']);
    if (!$id) exit;
    $comment = $admin->mngrDB->mysqlGetOne("SELECT * FROM comments_messages WHERE id='$id' LIMIT 1");
    if (!$comment) exit;
    echo json_encode(array('id'=>$comment['id'], 'moderate'=>$comment['moderate']));
    exit;
}


$admin->DoAction();

?>
