<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");

$id = $_SESSION['id'];
$name = $_SESSION['name'];

// ユーザーがログインしているか確認
if (!$id) {
  header('Location: admin_signin.php');
  exit();
}

// CSRFトークンを生成
$csrf_token = setToken();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = [
    'id' => $id,
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'email' => h($_POST['email'] ?? ''),
    'email_confirm' => h($_POST['email_confirm'] ?? ''),
  ];

  $error = validateAdminUpdate($data);

  if (empty($error)) {
    $admin = new Admin();

    $result = $admin->AdminDbUpdate($data);

    if ($result) {
      unset($_SESSION['data']);
      // 更新処理が成功した場合
      $_SESSION['dbsuccess_message'] = "会員情報の更新が完了しました";
      header("Location: admin_detail.php");
      exit;
    } else {
      header('Location: admin_update.php');
      exit();
    }
  }
} else {
  // $admin = new Admin();
  // $result = $admin->AdminDbDetail($id);
  // セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'id' => $name,
    'name' => '',
    'email' => '',
    'email_confirm' => '',
  ];
}
?>

<?php //echo h($id); 
?>
<main class="">
  <h2 class="contents-title">会員情報変更</h2>

  <form action="" method="post" name="demoForm" class="form">

    <!-- CSRFトークンをフォームに埋め込む -->
    <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>">

    <div class="form_input_block">
      <label for="js-text" class="form_input_title">氏名</label>
      <span class="need form_input_need">必須</span>
      <input type="text" name="name" class="form_input_value" id="js-text" maxlength="20" autofocus value="<?php echo h($data['name']); ?>">
      <?php if (isset($error['name'])) : ?>
        <p class="form_input_error_message"><?= $error['name']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-textMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email" class="form_input_title">メールアドレス</label>
      <span class="need form_input_need">必須</span>
      <input type="email" name="email" class="form_input_value" id="js-email" value="<?php echo h($data['email']); ?>">
      <?php if (isset($error['email'])) : ?>
        <p class="form_input_error_message"><?php echo $error['email']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage"></p>
    </div>

    <div class="form_input_block">
      <label for="js-email-confirm" class="form_input_title">メールアドレス(確認用)</label>
      <span class="need form_input_need">必須</span>
      <input type="email" name="email_confirm" class="form_input_value" id="js-email-confirm" value="<?php echo isset($_POST['email_confirm']) ? h($_POST['email_confirm']) : ''; ?>">
      <?php if (isset($error['email_confirm'])) : ?>
        <p class="form_input_error_message"><?php echo $error['email_confirm']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-emailMessage-confirm"></p>
    </div>

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?php echo h($error_message); ?></div>
    <?php endif; ?>

    <div class="form_confirm_btn_block">
      <a class="el_btn el_btn_back" href="admin_detail.php">戻る</a>
      <input type="submit" value="更新" class="el_btn el_btn_submit">
    </div>

  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
