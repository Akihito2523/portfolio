<?php
require_once('../lib/functions.php');
session_start();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
// メッセージを一度表示したらセッションから削除
unset($_SESSION['error']);

$error = [];

// POSTリクエストの場合、フォームが送信されたとして処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = [
    'email' => h($_POST['email'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
  ];

  $error = validateLogin($data);

  // エラーがなければ確認ページに遷移
  if (empty($error)) {
    $_SESSION['data'] = $data;
    header("Location: mypage.php");
    exit;
  }
} else {
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'email' => '',
    'password' => '',
  ];
}


?>

<?php require_once("../includes/admin_header.php"); ?>


<main class="">

    <form action="" method="post" name="demoForm" class="form_input">

        <div class="form_input_block">
            <label for="js-email" class="form_input_title">メールアドレス</label>
            <input type="email" name="email" class="form_input_value" id="js-email" value="<?php echo h($data['email']); ?>">
            <?php if (isset($error['email'])) : ?>
                <p class="form_input_error_message"><?php echo $error['email']; ?></p>
            <?php endif; ?>
            <p class="form_input_error_message" id="js-emailMessage"></p>
        </div>

        <div class="form_input_block">
            <label for="js-password" class="form_input_title">パスワード</label>
            <input type="password" name="password" class="form_input_value" id="js-password" value="<?php echo h($data['password']); ?>">
            <?php if (isset($error['password'])) : ?>
                <p class="form_input_error_message"><?php echo $error['password']; ?></p>
            <?php endif; ?>
            <p class="form_input_error_message" id="js-passwordMessage"></p>
        </div>

        <input type="submit" value="ログイン" class="el_btn el_btn_submit" id="js-submit">
        <p class="form_input_link"><a href="">パスワードを忘れた場合はこちら</a></p>
        <p class="form_input_link"><a href="user_signup.php">アカウント新規登録</a></p>

    </form>

</main>

<?php //require_once("../includes/footer.php"); ?>
