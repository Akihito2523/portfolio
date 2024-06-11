<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

if (!$logout = filter_input(INPUT_POST, 'logout')) {
    exit('不正なリクエストです。');
}

//ログアウトする
Admin::logout();
// $form = new Dbc();
// $result = $form->Delete($_GET['id']);
?>


<div class="thanks_message">ログアウトしました</div>
<a class="el_btn el_btn_top" href="login.php">ログインページに戻る</a>
