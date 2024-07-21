<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

$id = $_SESSION['id'];

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
// メッセージを一度表示したらセッションから削除
unset($_SESSION['error']);

$error = [];

// POSTリクエストの場合、フォームが送信されたとして処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = [
    'id' => $id,
    'email' => h($_POST['email'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
  ];

  $error = validateAdminLogin($data);

  if (empty($error)) {
    $admin = new Admin();
    $result = $admin->AdminDbUpdateDeleted($data);

    if ($result) {
      unset($_SESSION['data']);
      unset($_SESSION['id']);
      header('Location: admin_delete_account_thanks.php');
      exit();
    } else {
      header('Location: admin_delete_account.php');
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
  <h2 class="contents-title">管理者用退会ページ</h2>
  <p class="form_input_caution">現在のメールアドレスとパスワードを入力してください</p>

  <form action="" method="post" name="form" class="form container">

    <div class="form_input_block">
      <label for="js-email" class="form_input_title">メールアドレス</label>
      <input type="email" name="email" class="form_input_value" id="js-email" value="">
      <?php if (isset($error['email'])) : ?>
        <p class="form_input_error_message"><?php echo $error['email']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-password" class="form_input_title">パスワード</label>
      <input type="password" name="password" class="form_input_value" id="js-password" value="">
      <?php if (isset($error['password'])) : ?>
        <p class="form_input_error_message"><?php echo $error['password']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordMessage"></p>
    </div>

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?php echo h($error_message); ?></div>
    <?php endif; ?>

    <div class="form_btn_block ">
      <a class="el_btn el_btn_back" href="admin_detail.php">戻る</a>
      <input type="submit" value="退会する" class="el_btn el_btn_submit js-btndeleteadmin ">
    </div>

  </form>

</main>

<?php require_once("../includes/footer.php"); ?>
