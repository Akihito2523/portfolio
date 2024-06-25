<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");
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

  if (empty($error)) {
    $admin = new Admin();
    $result = $admin->AdminDbLogin($data);

    if ($result) {
      $_SESSION['data'] = $data;
      header('Location: admin_top.php');
      exit();
    } else {
      $_SESSION['error'] = 'ログイン認証に失敗しました';
      header('Location: admin_signin.php');
      exit();
    }
  }
} else {
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'email' => '',
    'password' => '',
  ];
}

?>

<main class="">

  <form action="" method="post" name="demoForm" class="form">

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

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?php echo h($error_message); ?></div>
    <?php endif; ?>

    <div class="form_login_btn_block">
      <input type="submit" value="ログイン" class="el_btn el_btn_submit">
      <p class="form_input_link"><a href="admin_password_reset.php" ontouchstart="">パスワードを忘れた場合はこちら</a></p>
      <p class="form_input_link"><a href="admin_signup.php" ontouchstart="">アカウント新規登録</a></p>
    </div>

  </form>

</main>

<?php require_once("../includes/footer.php"); ?>
