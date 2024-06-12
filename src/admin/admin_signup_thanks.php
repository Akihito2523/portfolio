<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

$token = filter_input(INPUT_POST, 'csrf_token');

// // CSRFトークンがない、もしくは一致しない場合、処理を中止
// if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
//     $_SESSION['error'] = '不正なリクエストです。';
//     header('Location: user_signup.php');
//     exit();
// }

?>

<!-- <div class="thanks_message"><?php echo h($_SESSION['message']); ?></div> -->

<div class="thanks_message">ユーザー登録完了しました。</div>
<a class="el_btn el_btn_top" href="admin_login.php">ログインページ</a>

<?php require_once("../includes/footer.php"); ?>
