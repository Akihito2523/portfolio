<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

// CSRFトークンを生成
$csrf_token = setToken();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$error = [];

// POSTリクエストの場合、フォームが送信されたとして処理
// $_POSTがセットされている場合その値を、セットされていない場合は空の文字列を返す
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = [
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'email' => h($_POST['email'] ?? ''),
    'email_confirm' => h($_POST['email_confirm'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
    'password_confirm' => h($_POST['password_confirm'] ?? ''),
  ];

  $error = validateAdminSignup($data);

  if (empty($error)) {
    $admin = new Admin();
    $result = $admin->AdminDbCreate($data);
    if ($result) {
      $_SESSION['dbsuccess_message'] = "会員登録が完了しました";
      unset($_SESSION['data']);
      header("Location: admin_signin.php");
      exit();
    } else {
      $_SESSION['data'] = $data;
      header('Location: admin_signup.php');
      exit();
    }
  }
} else {
  // セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'email' => '',
    'email_confirm' => '',
    'password' => '',
    'password_confirm' => '',
  ];
}

?>

<main class="">
  <h2 class="contents-title">会員登録</h2>

  <form action="" method="post" name="form" class="form container" enctype="multipart/form-data">

    <!-- CSRFトークンをフォームに埋め込む -->
    <input type="hidden" name="csrf_token" value="<?= h($csrf_token); ?>">

    <div class="form_input_block">
      <label for="js-text" class="form_input_title">氏名</label>
      <span class="need form_input_need">【必須】</span>
      <input type="text" name="name" class="form_input_value" id="js-text" maxlength="20" value="<?= h($data['name'] ?? ''); ?>">
      <?php if (isset($error['name'])) : ?>
        <p class="form_input_error_message" id="js-textMessage"><?= $error['name']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-textMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email" class="form_input_title">メールアドレス</label>
      <span class="need form_input_need">【必須】</span>
      <input type="email" name="email" class="form_input_value" id="js-email" value="<?= h($data['email'] ?? ''); ?>">
      <?php if (isset($error['email'])) : ?>
        <p class="form_input_error_message" id="js-emailMessage"><?= $error['email']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email-confirm" class="form_input_title">メールアドレス (確認用)</label>
      <span class="need form_input_need">【必須】</span>
      <input type="email" name="email_confirm" class="form_input_value" id="js-email-confirm" value="<?= isset($_POST['email_confirm']) ? h($_POST['email_confirm']) : ''; ?>">
      <?php if (isset($error['email_confirm'])) : ?>
        <p class="form_input_error_message"><?= $error['email_confirm']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage-confirm"></p>
    </div>

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
      <a class="el_btn el_btn_back" href="admin_signin.php">戻る</a>
      <input type="submit" value="アカウント新規作成" class="el_btn el_btn_submit">
    </div>

  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
