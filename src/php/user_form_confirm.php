<?php
session_start();
require_once('../lib/functions.php');
require_once('../admin/DataAccessUser.php');
require_once("../includes/header.php");

// CSRFトークンを生成
$csrf_token = setToken();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
// $error_message_image_path = isset($_SESSION['image_path']) ? $_SESSION['image_path'] : '';
// unset($_SESSION['image_path']);

$error = [];

// セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tel =  h($_POST['tel'] ?? '');
  // 電話番号のハイフンと空白文字を取り除く
  $tel_without_hyphen = preg_replace('/[\-\s]+/', '', $tel);

  $data = [
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'tel' => $tel_without_hyphen,
    'email' => h($_POST['email'] ?? ''),
    'email_confirm' => h($_POST['email_confirm'] ?? ''),
    'gender' => h($_POST['gender'] ?? ''),
    // $_POST['genre'] が設定かつ配列の場合、array_map関数を使って $_POST['genre'] の各要素をエスケープをし$data['genre']に格納、設定されていない場合は空の配列 [] を格納
    'genre' => isset($_POST['genre']) && is_array($_POST['genre']) ? array_map('h', $_POST['genre']) : [],
    'pref' => h($_POST['pref'] ?? ''),
    'image_path' => $_SESSION['data']['image_path'] ?? '',
    'textarea' => h($_POST['textarea'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
    'password_confirm' => h($_POST['password_confirm'] ?? ''),
    'checkbox_name' => h($_POST['checkbox_name'] ?? '')
  ];

  $user = new User();
  $result = $user->UserDbCreate($data);

  if ($result) {
    unset($_SESSION['data']);
    header("Location: user_form_thanks.php");
    exit;
  } else {
    header('Location: user_form_confirm.php');
    exit();
  }
} else {
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'tel' => '',
    'email' => '',
    'email_confirm' => '',
    'gender' => '',
    'genre' => [],
    'pref' => '',
    'image_path' => '',
    'textarea' => '',
    'password' => '',
    'password_confirm' => '',
    'checkbox_name' => ''
  ];
  if ($data['gender'] === 'man') {
    $data['gender'] = '男性';
  } elseif ($data['gender'] === 'woman') {
    $data['gender'] = '女性';
  } elseif ($data['gender'] === 'others') {
    $data['gender'] = 'その他';
  }
}

?>

<main class="">
  <form action="" method="post" name="form" class="form form_confirm container" enctype="multipart/form-data">
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">氏名</dt>
      <dd class="form_confirm_value"><?= h($data['name'] ?? '') ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">電話番号</dt>
      <dd class="form_confirm_value"><?= h($data['tel'] ?? '') ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">メールアドレス</dt>
      <dd class="form_confirm_value"><?= h($data['email'] ?? '') ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">性別</dt>
      <dd class="form_confirm_value"><?= h($data['gender'] ?? '') ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">チェックボックス</dt>
      <dd class="form_confirm_value">
        <?php foreach ($data['genre'] as $item) : ?>
          <?= h($item) ?> <br>
        <?php endforeach; ?>
      </dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">都道府県</dt>
      <dd class="form_confirm_value"><?= h($data['pref'] ?? '') ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">写真</dt>
      <dd class="form_confirm_value">
        <?php if (!empty($data['image_path']['name'])) : ?>
          <?= h($data['image_path']['name']) ?>
        <?php else : ?>
          画像がアップロードされていません
        <?php endif; ?>
      </dd>
    </dl>

    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">テキストエリア</dt>
      <dd class="form_confirm_value"><?= h($data['textarea'] ?? '') ?></dd>
    </dl>
    <dl class="form_confirm_block">
      <dt class="form_input_title form_confirm_title">利用規約</dt>
      <dd class="form_confirm_value"><?= h($data['checkbox_name'] ?? '') ?></dd>
    </dl>

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?php echo h($error_message); ?></div>
    <?php endif; ?>
    <?php //if ($error_message_image_path) : 
    ?>
    <div class="form_input_error_message dberror_message"><?php //echo h($$error_message_image_path); 
                                                          ?></div>
    <?php //endif; 
    ?>
    <div class="form_btn_block">
      <a class="el_btn el_btn_back" href="user_form_regist.php">戻る</a>
      <input type="submit" value="送信" class="el_btn el_btn_submit">
    </div>

    <!-- hiddenパラメータ -->
    <input type="hidden" name="name" value="<?= h($data['name'] ?? '') ?>">
    <input type="hidden" name="tel" value="<?= h($data['tel'] ?? '') ?>">
    <input type="hidden" name="email" value="<?= h($data['email'] ?? '') ?>">
    <input type="hidden" name="gender" value="<?= h($data['gender'] ?? '') ?>">
    <?php foreach ($data['genre'] as $item) : ?>
      <input type="hidden" name="genre[]" value="<?= h($item) ?>">
    <?php endforeach; ?>
    <input type="hidden" name="pref" value="<?= h($data['pref'] ?? '') ?>">
    <input type="hidden" name="image_path" value="<?= h($data['image_path']['name'] ?? '') ?>">
    <input type="hidden" name="textarea" value="<?= h($data['textarea'] ?? '') ?>">
    <input type="hidden" name="checkbox_name" value="<?= h($data['checkbox_name'] ?? '') ?>">
  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
