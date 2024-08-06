<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

// CSRFトークンの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRFトークンの検証
    $submitted_token = filter_input(INPUT_POST, '_csrf_token');
    if ($submitted_token !== $_SESSION['_csrf_token']) {
        die("不正なリクエストです。");
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $admin = new Admin();
    // メールアドレスに対応するレコードが存在し、トークンを生成
    $token = $admin->AdminDbPassReset($email);

    if ($token) {
        // メールアドレスが存在し、かつ退会日時かNULLでないトークンの送信処理
        $expiry = 900; // 15分（秒単位）
        $isSent = $admin->sendPasswordResetEmail($email, $token, $expiry);
        if ($isSent) {
            header('Location: admin_password_reset_thanks.php');
            exit();
        } else {
            echo "メールの送信に失敗しました。";
        }
    } else {
        // メールアドレスが存在しないか、退会している場合
        echo "指定されたメールアドレスは存在しません。";
    }
}

?>

<main class="">
    <h2 class="contents-title">パスワード再設定手続き</h2>

    <form action="" method="post" name="form" class="form container">
        <!-- CSRFトークンをフォームに埋め込む -->
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <div class="form_input_block">
            <label for="js-email" class="form_input_title">メールアドレス</label>
            <span class="need form_input_need">必須</span>
            <input type="email" name="email" class="form_input_value" id="js-email" value="">
            <p class="form_input_error_message" id="js-emailMessage"></p>
        </div>

        <div class="form_btn_block">
            <a class="el_btn el_btn_back" href="admin_signin.php">戻る</a>
            <input type="submit" value="パスワードリセット" class="el_btn el_btn_submit">
        </div>

    </form>
</main>

<?php require_once("../includes/footer.php"); ?>
