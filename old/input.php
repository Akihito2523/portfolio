<?php
require_once("functions.php");
session_start();

$error = [];

// POSTリクエストの場合、フォームが送信されたとして処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // サーバーサイドのバリデーション
  $data = [
    'name' => isset($_POST['name']) ? h($_POST['name']) : '',
    'tel' => isset($_POST['tel']) ? h($_POST['tel']) : '',
    'email' => isset($_POST['email']) ? h($_POST['email']) : '',
    'email_confirm' => isset($_POST['email_confirm']) ? h($_POST['email_confirm']) : '',
    'gender' => isset($_POST['gender']) ? h($_POST['gender']) : '',
    'pref' => isset($_POST['pref']) ? h($_POST['pref']) : '',
    'password' => isset($_POST['password']) ? h($_POST['password']) : '',
    'password_confirm' => isset($_POST['password_confirm']) ? h($_POST['password_confirm']) : '',
    'checkbox_name' => isset($_POST['checkbox_name']) ? h($_POST['checkbox_name']) : ''
  ];

  // バリデーション関数を呼び出し
  $error = validateInputFormData($data);

  // エラーがなければ確認ページに遷移
  if (empty($error)) {
    //入力値をセッションに保存
    //$_SESSION["name"] = $data["name"];
    // 入力値をセッションに保存
    $_SESSION['data'] = $data;
    header("Location: user_form_confirm.php");
    // リダイレクト後にスクリプトの実行を終了する
    exit;
  }
} else {
  // セッションからデータを取得
  $data = isset($_SESSION['data']) ? $_SESSION['data'] : [
    'name' => '',
    'tel' => '',
    'email' => '',
    'email_confirm' => '',
    'gender' => '',
    'pref' => '',
    'password' => '',
    'password_confirm' => '',
    'checkbox_name' => ''
  ];
}

echo '都道府県は' . h($data['pref']);
?>


<?php require_once("header.php"); ?>

<main class="">
  <h2 class="contents-title">contact</h2>

  <form action="" method="post" name="demoForm" class="form">

    <div class="form_input_block">
      <label for="js-text" class="form_input_title">氏名</label>
      <span class="need form_input_need">必須</span>
      <input type="text" name="name" class="form_input_value" id="js-text" maxlength="20" autofocus value="<?php echo h($data['name']); ?>">
      <?php if (isset($error['name'])) : ?>
        <p class="form_input_error_message"><?php echo $error['name']; ?></p>
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

    <div id="js-radio">
      <fieldset>
        <legend class="form_input_title">性別</legend>
        <span class="need form_input_need">必須</span>
        <label class="form_input_label"><input type="radio" name="gender" value="man" <?php if (isset($data['gender']) && $data['gender'] === 'man') echo 'checked'; ?> />男性</label>
        <label class="form_input_label"><input type="radio" name="gender" value="woman" <?php if (isset($data['gender']) && $data['gender'] === 'woman') echo 'checked'; ?> />女性</label>
        <label class="form_input_label"><input type="radio" name="gender" value="others" <?php if (isset($data['gender']) && $data['gender'] === 'others') echo 'checked'; ?> />その他</label>
        <?php if (isset($error['gender'])) : ?>
          <p class="form_input_error_message radio_error_message"><?php echo $error['gender']; ?></p>
        <?php endif; ?>
      </fieldset>
      <fieldset>
        <legend class="form_input_title">ラジオボタン（ドリンク）</legend>
        <label class="form_input_label"><input type="radio" name="drink" value="coke" checked />Coke</label>
        <label class="form_input_label"><input type="radio" name="drink" value="wine" />Wine</label>
      </fieldset>
    </div>

    <div id="js-checkbox">
      <label for="js-checkbox" class="form_input_title">チェックボックス</label>
      <label class="form_input_label"><input type="checkbox" name="checkbox" value="箸">箸</label>
      <label class="form_input_label"><input type="checkbox" name="checkbox" value="手拭き">手拭き</label>
      <label class="form_input_label"><input type="checkbox" name="checkbox" value="爪楊枝">爪楊枝</label>
    </div>

    <div class="form_input_block">
      <label for="js-select" class="form_input_title">都道府県</label>
      <span class="need form_input_need">必須</span>
      <select name="pref" id="js-select" class="form_input_value">
        <option value="">▼都道府県を選択</option>
        <optgroup label="北海道・東北">
          <option value="北海道" <?php if (isset($data['pref']) && $data['pref'] === "北海道") {
                                echo "selected";
                              } ?>>北海道</option>
          <option value="青森県">青森県</option>
          <option value="岩手県">岩手県</option>
          <option value="宮城県">宮城県</option>
          <option value="秋田県">秋田県</option>
          <option value="山形県">山形県</option>
          <option value="福島県">福島県</option>
        </optgroup>
        <optgroup label="関東">
          <option value="茨城県">茨城県</option>
          <option value="栃木県">栃木県</option>
          <option value="群馬県">群馬県</option>
          <option value="埼玉県">埼玉県</option>
          <option value="千葉県">千葉県</option>
          <option value="東京都">東京都</option>
          <option value="神奈川県">神奈川県</option>
        </optgroup>
        <optgroup label="中部">
          <option value="新潟県">新潟県</option>
          <option value="富山県">富山県</option>
          <option value="石川県">石川県</option>
          <option value="福井県">福井県</option>
          <option value="山梨県">山梨県</option>
          <option value="長野県">長野県</option>
          <option value="岐阜県">岐阜県</option>
          <option value="静岡県">静岡県</option>
          <option value="愛知県">愛知県</option>
        </optgroup>
        <optgroup label="近畿">
          <option value="三重県">三重県</option>
          <option value="滋賀県">滋賀県</option>
          <option value="京都府">京都府</option>
          <option value="大阪府">大阪府</option>
          <option value="兵庫県">兵庫県</option>
          <option value="奈良県">奈良県</option>
          <option value="和歌山県">和歌山県</option>
        </optgroup>
        <optgroup label="中国">
          <option value="鳥取県">鳥取県</option>
          <option value="島根県">島根県</option>
          <option value="岡山県">岡山県</option>
          <option value="広島県">広島県</option>
          <option value="山口県">山口県</option>
        </optgroup>
        <optgroup label="四国">
          <option value="徳島県">徳島県</option>
          <option value="香川県">香川県</option>
          <option value="愛媛県">愛媛県</option>
          <option value="高知県">高知県</option>
        </optgroup>
        <optgroup label="九州・沖縄">
          <option value="福岡県">福岡県</option>
          <option value="佐賀県">佐賀県</option>
          <option value="長崎県">長崎県</option>
          <option value="熊本県">熊本県</option>
          <option value="大分県">大分県</option>
          <option value="宮崎県">宮崎県</option>
          <option value="鹿児島県">鹿児島県</option>
          <option value="沖縄県">沖縄県</option>
        </optgroup>
      </select>
      <?php if (isset($error['pref'])) : ?>
        <p class="form_input_error_message radio_error_message"><?php echo $error['pref']; ?></p>
      <?php endif; ?>
    </div>

    <div class="form_input_block">
      <label for="js-start-time" class="form_input_title">開始時間</label>
      <input type="time" id="js-start-time" name="start-time" class="form_input_value">
    </div>

    <div class="form_input_block">
      <label for="js-datetime" class="form_input_title">日時</label>
      <input type="datetime-local" name="datetime" class="form_input_value" id="js-datetime">
    </div>

    <div class="form_input_block">
      <label for="js-textarea" class="form_input_title">テキストエリア</label>
      <span class="need form_input_any">任意</span>
      <textarea id="js-textarea" class="form_input_value" maxlength="20"></textarea>
      <p class="form_input_textarea_message">現在
        <span id="js-textareaCount">0</span>文字入力中です。
      </p>
    </div>

    <div class="form_input_block">
      <label for="js-password" class="form_input_title">パスワード</label>
      <span class="need form_input_need">必須</span>
      <input type="password" name="password" class="form_input_value" id="js-password" value="<?php echo h($data['password']); ?>">
      <?php if (isset($error['password'])) : ?>
        <p class="form_input_error_message"><?php echo $error['password']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordMessage"></p>
      <span class="form_input_caution">※半角英数記号8文字以上16文字以下</span>
    </div>

    <div class="form_input_block">
      <label for="js-password-confirm" class="form_input_title">パスワード確認</label>
      <span class="need form_input_need">必須</span>
      <input type="password" name="password_confirm" class="form_input_value" id="js-password-confirm">
      <?php if (isset($error['password_confirm'])) : ?>
        <p class="form_input_error_message"><?php echo $error['password_confirm']; ?></p>
      <?php endif; ?>
      <p class="form_input_error_message" id="js-passwordConfirmMessage"></p>
    </div>

    <div id="privacyPolicy" class="privacy-policy">
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nihil minus excepturi harum, labore earum odio. Minima itaque sit labore, nostrum earum eaque, debitis qui sunt molestias, voluptas accusamus veritatis minus quidem sint cumque inventore eligendi! Suscipit, dolores sed numquam ex eum minus esse, rerum harum accusantium cumque animi commodi ipsa ullam nulla quibusdam? Quis magni, doloribus amet commodi ratione quibusdam nam nobis tempore excepturi laboriosam molestias nulla enim deleniti! Sed impedit ducimus deserunt sunt, tempora amet, temporibus unde reiciendis, animi veritatis a ut aperiam in aspernatur earum. Iusto ipsa aperiam ex eveniet earum similiqueur quos asperiores eius nobis totam error mollitia rem dolor excepturi doloremque molestiae magni porro id exercitationem, sunt fuga minus modi cupiditate quidem? Molestias autem quos voluptates accusantium quod alias distinctio illum nulla. Quis accusamus ipsa obcaecati tempora necessitatibus error qui ipsam eum eveniet delectus placeat animi quo sunt earum, atque numquam tenetur est molestias quas fugit praesentium voluptatibus alias ducimus! Soluta officia sunt at id illo? Commodi optio dolores dolore ducimus unde nobis necessitatibus temporibus doloribus corrupti velit distinctio maiores nulla, cum molestias accusamus, qui sapiente suscipit neque labore ratione quos a eaque error. Provident vel debitis dolores, necessitatibus non in quam fugiat et excepturi a esse? Iusto facere porro inventore deleniti, repellendus eum in voluptatibus odio nulla, officiis magni suscipit distinctio esse quibusdam, fuga minima commodi error delectus? Unde porro optio sint exercitationem nostrum placeat, ullam qui natus adipisci cupiditate, suscipit iure enim eaque nihil doloribus fuga. A, impedit architecto voluptas saepe harum earum consectetur voluptatum fugiat qui molestiae magnam quia labore nostrum, praesentium ut dolor error, illo consequuntur explicabo quasi! Necessitatibus expedita fugit nemo id nostrum consectetur, aperiam numquam cumque quos saepe excepturi autem illo adipisci similique ea quia, fuga, doloremque ipsa. Debitis, tenetur aut. Nemo tenetur dolorum voluptate quae aliquam quia amet excepturi dolores ullam provident illum, ad exercitationem expedita sed non impedit, dolor quod natus voluptatem consequuntur incidunt officiis sapiente iure. Libero, explicabo. Modi possimus ab repellendus? Consectetur nihil, aperiam beatae earum fugiat asperiores mollitia modi molestias distinctio harum excepturi sit necessitatibus minima accusamus ullam doloremque officiis. Aspernatur, eius consequatur. Voluptas nobis maxime saepe ipsum fuga voluptatem est ex molestias reiciendis temporibus. Similique, quibusdam beatae esse magni consequatur cum vero, ab ad ullam, facere provident? Ullam, consequatur! Eum nostrum incidunt tempora. Dolore sit veritatis, asperiores numquam iste debitis vel.
    </div>

    <div class="form_input_block">
      <label for="js-check" class="form_input_title">利用規約</label>
      <span class="need form_input_need">必須</span>
      <label class="form_input_label">
        <input type="checkbox" name="checkbox_name" id="js-check" value="同意" <?php if ($data['checkbox_name'] === '同意') echo 'checked'; ?>>
        同意
      </label>
      <?php if (isset($error['checkbox_name'])) : ?>
        <p class="form_input_error_message"><?php echo $error['checkbox_name']; ?></p>
      <?php endif; ?>
    </div <div class="form_input_block">


    <input type="submit" value="確認" class="el_btn el_btn_submit" disabled>
    </div>

  </form>
</main>


<?php require_once("footer.php"); ?>



<dl class="form_confirm_block">
  <dt class="form_input_title form_confirm_title">写真</dt>
  <dd class="form_confirm_value">
    <?php if (!empty($data['image_path']) && is_array($data['image_path']) && isset($data['image_path']['name'])) : ?>
      <?php echo $data['image_path']['name']; ?>
    <?php else : ?>
      画像がアップロードされていません
    <?php endif; ?>
  </dd>
</dl>
