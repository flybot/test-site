<?php


//search comments action param
$action    = $_REQUEST['comments_action'];
$page_id   = isset($_REQUEST['page_id']) ? mysql_real_escape_string($_REQUEST['page_id']) : '';
$page_name = isset($_REQUEST['page_name']) ? $_REQUEST['page_name'] : '';

$comments = new Comments($page_id, $page_name);

if ($action=='login'){
    $comments->login();
    exit;
}
if ($action=='logout'){
    $comments->logout();
    echo "ok";
    echo "<script>window.close();</script>";
    exit;
}
if ($action=='comment'){
    $new_comment_id = $comments->createComment();
    $arr = array();
    $arr['form']   = $comments->getForm();
    $arr['list']   = $comments->getList();
    $arr['notify'] = $comments->getNotify();
    if ($new_comment_id)
        $arr['scrollToComment'] = $new_comment_id;
    echo json_encode($arr);
}

if ($action=='delete'){
    $comments->deleteComment();
    $arr = array();
    $arr['form']   = $comments->getForm();
    $arr['list']   = $comments->getList();
    $arr['notify'] = $comments->getNotify();

    echo json_encode($arr);
}

if ($action == 'login_ok'){
    $comments->login();
    echo "ok";
    echo "<script>window.close();</script>";
}

if ($action == 'update'){
    $arr = array();
    $arr['form'] = $comments->getForm();
    $arr['list'] = $comments->getList();

    echo json_encode($arr);
    exit;
}

if ($action == 'updatelist'){
    $arr = array();
    $arr['list'] = $comments->getList();
    echo json_encode($arr);
    exit;
}


exit;

?>
