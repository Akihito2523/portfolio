<?php require_once("../lib/functions.php"); ?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="/image/png" href="image/CSS.svg" />
    <title>管理者 | <?php echo getPageTitle(); ?></title>

    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/destyle.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
    <script src="../../public/js/index.js" defer></script>
</head>

<!-- <body> -->

<body ontouchstart="">
    <!-- ログインページ以外ならヘッダーを表示 -->
    <?php if (
        getPageTitle() !== 'ログイン' &&
        getPageTitle() !== '会員登録' &&
        getPageTitle() !== 'パスワード再登録手続き' &&
        getPageTitle() !== 'パスワード再設定'
    ) : ?>
        <header class="ly_header container">
            <div class="ly_header_inner">
                <!-- <div class="bl_headerUtils">
                <a class="bl_headerUtils_logo" href="#"><img src="/image/ピカチュウ.png" alt=""></a>
                <a class="el_btn" href="#">お問い合わせ</a>
            </div> -->
                <!-- /.bl_headerUtils -->
                <nav>
                    <ul class="bl_headerNav">
                        <li class="bl_headerNav_item">
                            <a class="bl_headerNav_link" href="../admin/profile.php">ポートフォリオ</a>
                        </li>
                        <li class="bl_headerNav_item">
                            <a class="bl_headerNav_link" href="../admin/admin_top.php">トップ</a>
                        </li>
                        <li class="bl_headerNav_item">
                            <a class="bl_headerNav_link" href="../admin/admin_detail.php?id=<?php echo h($id); ?>">会員詳細</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- /.ly_header_inner -->
        </header>
    <?php endif; ?>
