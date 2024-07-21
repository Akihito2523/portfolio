<?php
session_start();
require_once("../config/variable.php");
require_once('../lib/functions.php');
require_once('../admin/DataAccessUser.php');
require_once("../includes/header.php");


// CSRFトークンを生成
$csrf_token = setToken();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$error = [];

// POSTリクエストの場合、フォームが送信されたとして処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // $_POSTがセットされている場合その値を、セットされていない場合は空の文字列を返す
  $data = [
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'tel' => h($_POST['tel'] ?? ''),
    'email' => h($_POST['email'] ?? ''),
    'email_confirm' => h($_POST['email_confirm'] ?? ''),
    'gender' => h($_POST['gender'] ?? ''),
    // $_POST['genre'] が設定かつ配列の場合、array_map関数を使って $_POST['genre'] の各要素をエスケープをし$data['genre']に格納、設定されていない場合は空の配列 [] を格納
    'genre' => isset($_POST['genre']) && is_array($_POST['genre']) ? array_map('h', $_POST['genre']) : [],
    'pref' => h($_POST['pref'] ?? ''),
    'textarea' => h($_POST['textarea'] ?? ''),
    'password' => h($_POST['password'] ?? ''),
    'password_confirm' => h($_POST['password_confirm'] ?? ''),
    'checkbox_name' => h($_POST['checkbox_name'] ?? '')
  ];

  // バリデーション関数を呼び出し
  $error = validateUserForm($data);

  // エラーがなければ確認ページに遷移
  if (empty($error)) {
    $user = new User();
    $result = $user->UserDbDetail($data['id']);

    // $result = $user->UserDbUpdate($data);

    if (!$result) {
      header('Location: user_form_update.php');
      exit();
    }
    $_SESSION['data'] = $data;
    header("Location: user_form_thanks.php");
    exit;
  }
} else {
  // セッションがセットされている場合その値を、セットされていない場合は空の値を持つ連想配列を$dataに代入
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'tel' => '',
    'email' => '',
    'email_confirm' => '',
    'gender' => '',
    'genre' => [],
    'checkbox' => '',
    'pref' => '',
    'textarea' => '',
    'password' => '',
    'password_confirm' => '',
    'checkbox_name' => ''
  ];
}

?>

<main class="">
  <h2 class="contents-title">ユーザー情報更新</h2>

  <form action="" method="post" name="form" class="form container">

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
      <label for="js-tel" class="form_input_title">電話番号</label>
      <span class="need form_input_need">必須</span>
      <input type="tel" name="tel" class="form_input_value" id="js-tel" placeholder="例）09012345678" value="<?php echo h($data['tel']); ?>">
      <?php if (isset($error['tel'])) : ?>
        <p class="form_input_error_message"><?php echo $error['tel']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-telMessage"></p>
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

    <!-- $data配列内に'gender'キーが存在しかつvalue値と等しければ、trueを返しchecked属性を出力 -->
    <div class="form_input_block" id="js-radio">
      <fieldset>
        <legend class="form_input_title">性別<span class="need form_input_need"> 【必須】</span></legend>
        <label class="form_input_label">
          <input type="radio" name="gender" class="form_input_value_radio" value="man" <?php if (isset($data['gender']) && $data['gender'] === 'man') echo 'checked'; ?> />男性
        </label>
        <label class="form_input_label">
          <input type="radio" name="gender" class="form_input_value_radio" value="woman" <?php if (isset($data['gender']) && $data['gender'] === 'woman') echo 'checked'; ?> />女性
        </label>
        <label class="form_input_label">
          <input type="radio" name="gender" class="form_input_value_radio" value="others" <?php if (isset($data['gender']) && $data['gender'] === 'others') echo 'checked'; ?> />その他
        </label>
      </fieldset>
      <?php if (isset($error['gender'])) : ?>
        <p class="form_input_error_message radio_error_message"><?php echo $error['gender']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form_input_block">
      <label for="js-select" class="form_input_title">都道府県</label>
      <span class="need form_input_need">必須</span>
      <select name="pref" id="js-select" class="form_input_value">
        <option value="">▼選択してください</option>
        <?php foreach ($prefectures as $region => $prefs) : ?>
          <optgroup label="<?= h($region) ?>">
            <?php foreach ($prefs as $pref) : ?>
              <option value="<?= h($pref) ?>" <?php if (isset($data['pref']) && $data['pref'] === $pref) echo "selected"; ?>>
                <?= h($pref) ?></option>
            <?php endforeach; ?>
          </optgroup>
        <?php endforeach; ?>
      </select>

      <?php if (isset($error['pref'])) : ?>
        <p class="form_input_error_message radio_error_message"><?php echo $error['pref']; ?></p>
      <?php endif; ?>
    </div>

    <?php if ($error_message) : ?>
      <div class="form_input_error_message dberror_message"><?php echo h($error_message); ?></div>
    <?php endif; ?>

    <input type="submit" value="確認" class="el_btn el_btn_submit">

  </form>
</main>

<?php require_once("../includes/footer.php"); ?>
