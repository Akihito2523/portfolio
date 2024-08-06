<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

$id = $_SESSION['id'];

// CSRFトークンの生成
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['_csrf_token'] = $csrf_token;

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$error = [];

// URLからトークンを取得
$url_token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // CSRFトークンの検証
  // $submitted_token = filter_input(INPUT_POST, '_csrf_token');
  // if ($submitted_token !== $_SESSION['_csrf_token']) {
  //   die("Invalid CSRF token.");
  // }

  $data = [
    'email' => h($_POST['email'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
    'password_confirm' => h($_POST['password_confirm'] ?? ''),
    'token' => h($_POST['token'] ?? ''),
  ];

  // トークンの検証
  // if ($data['token'] !== $url_token) {
  //   die("Invalid token.");
  // }

  $error = validateAdminPasswordUpdate($data);

  if (empty($error)) {
    $admin = new Admin();

    $result = $admin->AdminDbPasswordUpdate($data, $url_token);
    if ($result) {
      // パスワード変更通知の送信
      $result = $admin->sendPasswordChangeEmail($_SESSION['email']);
      if ($result) {
        $_SESSION['dbsuccess_message'] = "パスワードの変更が完了しました";
        unset($_SESSION['data']);
        unset($_SESSION['email']);
        header("Location: admin_signin.php");
        exit();
      } else {
        $_SESSION['dbsuccess_message'] = "パスワードの変更に失敗しました";
      }
    } else {
      $_SESSION['dbsuccess_message'] = 'メールの送信に失敗しました。';
      $_SESSION['data'] = $data;
      header('Location: admin_signin.php');
      exit();
    }
  }
} else {
  unset($_SESSION['data']);
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'password' => '',
    'password_confirm' => '',
  ];
}


?>

<main class="">
  <h2 class="contents-title">パスワード再設定</h2>

  <form action="" method="post" name="form" class="form container" enctype="multipart/form-data">

    <!-- CSRFトークンをフォームに埋め込む -->
    <input type="hidden" name="_csrf_token" value="<?= h($_SESSION['_csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">


    <div class="form_input_block">
      <label for="js-password" class="form_input_title">パスワード</label>
      <span class="need form_input_need">【必須】</span>
      <div class="progress-container">
        <div class="js-passwordProgress" id="js-passwordProgress"></div>
        <div class="js-circle js-circle-active">1</div>
        <div class="js-circle">2</div>
        <div class="js-circle">3</div>
        <div class="js-circle">4</div>
      </div>
      <div class="form_input_caution" id="js-password-strength"></div>

      <div class="password-wrapper">
        <input type="password" name="password" class="form_input_value" id="js-password-admin" value="<?= h($data['password'] ?? ''); ?>">
        <span id="js-passwordButtonEye" class="fa fa-eye"></span>
      </div>
      <?php if (isset($error['password'])) : ?>
        <p class="form_input_error_message"><?= $error['password']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordMessage"></p>
      <span class="form_input_caution">※半角英数記号8文字以上16文字以下</span>
    </div>

    <div class="form_input_block">
      <label for="js-password-confirm" class="form_input_title">パスワード (確認用)</label>
      <span class="need form_input_need">【必須】</span>
      <input type="password" name="password_confirm" class="form_input_value" id="js-password-confirm">
      <?php if (isset($error['password_confirm'])) : ?>
        <p class="form_input_error_message"><?= $error['password_confirm']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordConfirmMessage"></p>
    </div>

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?= h($error_message); ?></div>
    <?php endif; ?>

    <div class="form_btn_block">
      <input type="submit" value="パスワード更新" class="el_btn el_btn_submit">
    </div>

  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
