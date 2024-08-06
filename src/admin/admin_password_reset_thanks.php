<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

$token = filter_input(INPUT_POST, 'csrf_token');

?>

<?php if (isset($_SESSION['dbsuccess_message'])) { ?>
    <div class="dbsuccess_message "><span class="dbsuccess_check">✔︎</span><?php echo $_SESSION['dbsuccess_message']; ?></div>
  <?php unset($_SESSION['dbsuccess_message']);
  } ?>
  
<div class="thanks_message">メール送信されました。<br>メールにあるパスワード再登録ページのURLから、パスワードを変更してください。</div>
<a class="el_btn el_btn_top" href="admin_signin.php">ログインページ</a>

<?php require_once("../includes/footer.php"); ?>
