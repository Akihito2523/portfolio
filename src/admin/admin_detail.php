<?php
session_start();
require_once('../lib/functions.php');
require_once('../config/env.php');
require_once("DataAccessAdmin.php");
require_once("../includes/admin_header.php");

// セッションから会員idを取得
// $id = $_SESSION['id'];

$admin = new Admin();
$result = $admin->AdminDbDetail($id);

// ユーザーがログインしているか確認
if (!$_SESSION['id']) {
    header('Location: admin_top.php');
    exit();
}

$_SESSION['data'] = $result;
?>

<main class="">
  <h2 class="contents-title">管理者詳細</h2>

<!-- 会員情報変更完了メッセージ -->
  <?php if (isset($_SESSION['dbsuccess_message'])) { ?>
    <div class="dbsuccess_message"><span class="dbsuccess_check">✔︎</span><?php echo $_SESSION['dbsuccess_message']; ?></div>
  <?php unset($_SESSION['dbsuccess_message']);
  } ?>

  <form class="form container detail">
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">氏名</dt>
      <dd class="form_confirm_value"><?php echo h($result['name']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">メールアドレス</dt>
      <dd class="form_confirm_value"><?php echo h($result['email']); ?></dd>
    </dl>

    <div class="form_btn_block">
      <a class="el_btn el_btn_back" href="admin_top.php">戻る</a>
      <a class="el_btn" href="admin_update.php">会員情報変更</a>
    </div>
    <p class="form_input_link"><a href="admin_delete_account.php" ontouchstart="">※退会はこちら</a></p>
    <!-- <p class="form_input_link"><a href="admin_password_update.php" ontouchstart="">※パスワード変更はこちら</a></p> -->

  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
