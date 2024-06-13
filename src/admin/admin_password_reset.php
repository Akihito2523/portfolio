<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email');

    $admin = new Admin();
    $result = $admin->AdminDbPassReset($email);
   
    if ($result) {

        $admin = new Admin();
        $isSent = $admin->AdminDbEmail($email);
        if($isSent){
            echo 'メール送信完了';
        }else {
            echo 'メール送信末完了';
        }

        // header('Location: admin_top.php');
        exit();
    } else {
        header('Location: admin_password_reset_thanks.php');
        exit();
    }
}


?>

<main class="">
    <h2 class="contents-title">パスワードリセット</h2>

    <form action="" method="post" name="demoForm" class="form">
        <!-- CSRFトークンをフォームに埋め込む -->
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <div class="form_input_block">
            <label for="js-email" class="form_input_title">メールアドレス</label>
            <span class="need form_input_need">必須</span>
            <input type="email" name="email" class="form_input_value" id="js-email" value="">
            <p class="form_input_error_message" id="js-emailMessage"></p>
        </div>

        <div class="form_confirm_btn_block">
            <a class="el_btn el_btn_back" href="admin_login.php">戻る</a>
            <input type="submit" value="パスワードリセット" class="el_btn el_btn_submit">
        </div>

    </form>
</main>

<?php require_once("../includes/footer.php"); ?>ï
