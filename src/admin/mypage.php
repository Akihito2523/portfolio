<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/header.php");
?>

<div class="thanks_message">ユーザー登録完了しました。</div>
<a class="el_btn el_btn_top" href="login.php">ログインページ</a>

<?php require_once("../includes/footer.php"); ?>
