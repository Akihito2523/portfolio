<?php
session_start();
// セッションから会員idとnameを取得
$id = $_SESSION['id'];
$name = $_SESSION['data']['name'] ?? $_SESSION['name'];

require_once('../lib/functions.php');
require_once('../config/env.php');
require_once('../includes/admin_header.php');
require_once('DataAccessUser.php');
require_once('DataAccessAdmin.php');

// $nameを$_SESSION['data']に追加する
// admin_update.phpで名前を更新するため

$user = new User();
$userDb = $user->UserDbRead();
$userDbResults = $userDb['result'];

// ユーザーがログインしているか確認
if (!$id) {
    header('Location: admin_signin.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = h($_POST['keyword'] ?? '');
    $form = new User();
    $formData = $form->UserDbConnect();
    $formData = $form->UserDbSearch(['keyword' => $keyword]);
}
?>

<form action="admin_top.php" method="post" class="">
    <div class="form_search_btn_block">
        <div class="adminName"><?php echo h($name); ?>さんログイン中</div>
        <input type="search" name="keyword" placeholder="名前検索" class="form_input_value form_input_search">
        <input type="submit" name="search" value="検索" class="el_btn_search">
    </div>
</form>

<div class="tb_wrap">
    <table class="table">
        <thead class="table_thead">
            <tr class="table_tr">
                <th>ID</th>
                <th>氏名</th>
                <th>電話番号</th>
                <th>メールアドレス</th>
                <th>性別</th>
                <th>チェックボックス</th>
                <th>都道府県</th>
                <th>写真</th>
                <th>テキストエリア</th>
                <th>登録日時</th>
                <th></th>
            </tr>
        </thead>

        <tbody class="table_tbody">
            <?php if ($userDbResults) : ?>
                <?php foreach ($userDbResults as $column) : ?>
                    <tr class="table_tr">
                        <td><a href="/src/admin/user_detail.php?id=<?php echo h($column["id"]); ?>" class="form_input_link" ontouchstart=""><?php echo h($column["id"]); ?></a></td>
                        <td><?php echo h($column["name"]); ?></td>
                        <td><?php echo h($column["tel"]); ?></td>
                        <td><?php echo h($column["email"]); ?></td>
                        <td><?php echo h($column["gender"]); ?></td>
                        <td><?php echo h($column["genre"]); ?></td>
                        <td><?php echo h($column["pref"]); ?></td>
                        <td class="table_td"><img src="<?php echo h($column["image_path"]); ?>" alt=""></td>
                        <td><?php echo h($column["textarea"]); ?></td>
                        <td><?php echo h($column["created_at"]); ?></td>
                        <td>
                            <a href="/src/admin/user_delete.php?id=<?php echo $column['id']; ?>" class="js-btndelete form_input_link" ontouchstart="">削除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="scroll-info">画像が小さくなりました。スクロールして全体を見てください。</div>

<form action="admin_signout.php" method="post">
    <input type="submit" name="logout" value="ログアウト" class="el_btn el_btn_top">
</form>
