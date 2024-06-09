<?php
require_once('../lib/functions.php');
require_once("../config.php");
session_start();
?>
<?php require_once("../header.php"); ?>

<?php require_once("dbc.php"); ?>

<?php

$form = new Dbc;
$formData = $form->dbConnect();
$formData = $form->Read();

?>

<!-- テーブル -->
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>名前</th>
            <th>メールアドレス</th>
            <th>写真</th>
            <th>削除</th>
        </tr>
    </thead>

    <?php foreach ($formData as $column) : ?>
        <!--$inputcardNumber = h($SPIRAL->getContextByFieldTitle("cardNumber"));-->
        <tbody>
            <tr>
                <td><a href="/php/table/detail.php?id=<?php echo h($column["id"]); ?>"><?php echo h($column["id"]); ?></a></td>
                <td><?php echo h($column["name"]); ?></td>
                <td class="text-overflow"><?php //echo h($column["email"]); ?></td>
                <td><?php //echo "<img src='data:image/png;base64," . h($column["image"]) . "'>"; ?></td>
                <td><a href="%url/rel:mpgt:tbc_delete%&id=<?php echo h($column["id"]); ?>" class="delete button">削除</a></td>
            </tr>
        </tbody>
    <?php endforeach; ?>


    <?php require_once("../footer.php"); ?>
