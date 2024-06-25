<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

$token = filter_input(INPUT_POST, 'csrf_token');

?>

<div class="thanks_message">メール送信されました。</div>
<a class="el_btn el_btn_top" href="admin_signin.php">ログインページ</a>

<?php require_once("../includes/footer.php"); ?>
