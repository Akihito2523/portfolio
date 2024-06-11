<?php
session_start();
require_once('../lib/functions.php');
require_once('../config/env.php');
require_once('../includes/admin_header.php');
require_once('DataAccessUser.php');
require_once('DataAccessAdmin.php');

// ユーザーがログインしているか確認
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$form = new Dbc();
$formData = $form->dbConnect();
$formData = $form->Read();

$name = $_SESSION['name'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = h($_POST['keyword'] ?? '');
    $form = new Dbc();
    $formData = $form->dbConnect();
    $formData = $form->Search(['keyword' => $keyword]);
}
?>



<form action="top.php" method="post" class="">
    <div class="form_search_btn_block">
        <div class="adminName"><?php echo h($name); ?>さんログイン中</div>
        <input type="search" name="keyword" placeholder="名前検索" class="form_input_value form_input_search">
        <input type="submit" name="search" value="検索" class="el_btn_search" >
    </div>
</form>

<table class="table">
    <thead class="table_thead">
        <tr class="table_tr">
            <th>ID</th>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>写真</th>
            <th>削除</th>
        </tr>
    </thead>

    <tbody class="table_tbody">
        <?php if ($formData) : ?>
            <?php foreach ($formData as $column) : ?>
                <tr class="table_tr">
                    <td><a href="/src/admin/detail.php?id=<?php echo h($column["id"]); ?>"><?php echo h($column["id"]); ?></a></td>
                    <td><?php echo h($column["name"]); ?></td>
                    <td class="text-overflow"></td>
                    <td></td>
                    <td>
                        <!-- <a href="%url/rel:mpgt:tbc_delete%&id=<?php echo h($column["id"]); ?>" class="delete button">削除</a> -->
                        <!-- <form action="" method="post" name="" class="">
                        <input type="submit" value="削除" class="">
                    </form> -->
                        <a href="/src/admin/user_delete.php?id=<?php echo $column['id']; ?>" class="el_btn_delete">削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- <script>
    const btnDelete = document.querySelector('.el_btn_delete');
    // if (btnDelete) {
    console.log(btnDelete);
    btnDelete.addEventListener('click', (e) => {
        alert('か');

    });
</script> -->

<!-- <a class="el_btn el_btn_top" href="login.php">ログアウト</a> -->

<form action="adminlogout.php" method="post">
    <input type="submit" name="logout" value="ログアウト" class="el_btn el_btn_top">
</form>


<!-- <a class="el_btn el_btn_back" href="/php/table/update.php">編集</a> -->
