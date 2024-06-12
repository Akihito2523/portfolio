<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

if (!$logout = filter_input(INPUT_POST, 'logout')) {
    exit('不正なリクエストです。');
}

// ログアウト処理
// Admin::AdminDblogout();
$admin = new Admin();
$admin->AdminDblogout();

// セッション変数を破棄して、セッションクッキーの有効期限を過去に設定
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
?>

<div class="thanks_message">ログアウトしました</div>
<a class="el_btn el_btn_top" href="admin_login.php">ログインページに戻る</a>
