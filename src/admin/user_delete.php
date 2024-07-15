<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessUser.php');
require_once("../includes/admin_header.php");

$user = new User();
$user->UserDbDelete($_GET['id']);
?>

<div class="thanks_message">ユーザーIDを削除しました。</div>
<a class="el_btn el_btn_top" href="admin_top.php">Topに戻る</a>

<?php require_once("../includes/footer.php"); ?>
