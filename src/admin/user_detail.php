<?php
session_start();
require_once('../lib/functions.php');
require_once('../config/env.php');
require_once("DataAccessUser.php");
require_once("../includes/admin_header.php");

$user = new User();
$result = $user->UserDbDetail($_GET['id']);

?>

<main class="">
<h2 class="contents-title">ユーザー詳細</h2>
  <form class="form container detail">
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">氏名</dt>
      <dd class="form_confirm_value"><?php echo h($result['name']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">電話番号</dt>
      <dd class="form_confirm_value"><?php echo h($result['tel']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">メールアドレス</dt>
      <dd class="form_confirm_value"><?php echo h($result['email']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">性別</dt>
      <dd class="form_confirm_value"><?php echo h($result['gender']); ?></dd>
    </dl>
    <dl class="form_confirm_block">  
      <dt class="form_input_title form_confirm_title">チェックボックス</dt>
      <dd class="form_confirm_value"><?php echo h($result['genre']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">都道府県</dt>
      <dd class="form_confirm_value"><?php echo h($result['pref']); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">写真</dt>
      <dd class="form_confirm_value">
        <img src="<?php echo h($result['image_path']); ?>" alt="">
      </dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">テキストエリア</dt>
      <dd class="form_confirm_value"><?php echo nl2br(h($result['textarea'])); ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">パスワード</dt>
      <dd class="form_confirm_value">*****</dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">利用規約</dt>
      <dd class="form_confirm_value"><?php echo h($result['checkbox_name']); ?></dd>
    </dl>
    <a class="el_btn el_btn_back" href="admin_top.php">戻る</a>

  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
