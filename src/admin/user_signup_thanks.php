<?php require_once("../includes/header.php"); ?>

<?php

session_start();
require_once('../lib/functions.php');
require_once('DataAccessUser.php');


$token = filter_input(INPUT_POST, 'csrf_token');

// // CSRFトークンがない、もしくは一致しない場合、処理を中止
// if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
//     $_SESSION['error'] = '不正なリクエストです。';
//     header('Location: user_signup.php');
//     exit();
// }


// if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] != $_SESSION['csrf_token']) {
//   echo "不正なリクエストです";
//   exit();
// }


$data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'email' => '',
    'password' => '',
];

$admin = new Admin();
$admin->AdminCreate($data);

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

if ($admin) {
    echo '登録成功';
} else {
    echo '登録失敗';
}






?>

<!-- <div class="thanks_message"><?php echo h($_SESSION['message']); ?></div> -->

<div class="thanks_message">ユーザー登録完了しました。</div>
<a class="el_btn el_btn_top" href="login.php">ログインページ</a>

<?php require_once("../includes/footer.php"); ?>
