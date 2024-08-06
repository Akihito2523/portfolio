<?php

/**
 * 各種関数
 *
 * @version $Revision: 4.0.0 $
 * @copyright
 * @author
 */
?>

<<<<<<< HEAD

<?php
/**
 * 文字列をHTML特殊文字に変換（サニタイズ処理）
 *
=======
<?php

/**
 * 各ページごとにタイトルを動的に変更
 * @param
 * @return string タイトル
 */
function getPageTitle()
{
    $pageTitle = '';

    // PHP_SELF から現在のファイル名を取得
    $currentPage = basename($_SERVER['PHP_SELF']);

    // 各ページごとにタイトルを設定
    switch ($currentPage) {
        case 'user_form_regist.php':
        case 'user_form_confirm.php':
        case 'user_form_thanks.php':
            $pageTitle = 'ユーザー登録';
            break;
        case 'user_top.php':
            $pageTitle = 'ユーザートップ';
            break;
        case 'admin_signin.php':
            $pageTitle = 'ログイン';
            break;
        case 'admin_signup.php':
            $pageTitle = '会員登録';
            break;
        case 'admin_top.php':
            $pageTitle = 'トップ';
            break;
        case 'user_detail.php':
            $pageTitle = 'ユーザー詳細';
            break;
        case 'admin_detail.php':
            $pageTitle = '詳細';
            break;
        case 'admin_update.php':
            $pageTitle = '情報変更';
            break;
        case 'admin_delete_account.php':
            $pageTitle = '退会';
            break;
        case 'admin_password_reset.php':
            $pageTitle = 'パスワード再登録手続き';
            break;
        case 'admin_password_reset.php':
        case 'admin_password_reset_thanks.php':
            $pageTitle = 'パスワード再登録手続き';
            break;
        case 'admin_password_update.php.php':
            $pageTitle = 'パスワード再設定';
            break;
        default:
            $pageTitle = 'デフォルトタイトル';
            break;
    }
    return $pageTitle;
}

/**
 * 文字列をHTML特殊文字に変換（サニタイズ処理）
>>>>>>> feature
 * @param string $str 変換する文字列
 * @return string 変換された文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
<<<<<<< HEAD
 * CSRF対策
 * @param void
 * return string $csrf_token
=======
 * CSRF対策用トークンを生成し、セッションに保存する
 * @return string 生成されたCSRFトークン
>>>>>>> feature
 */
function setToken()
{
    // トークンを生成
    $csrf_token = bin2hex(random_bytes(32));
    // セッションにトークンを保存
<<<<<<< HEAD
    $_SESSION['csrf_token'] = $csrf_token;
=======
    // $_SESSION['csrf_token'] = $csrf_token;
>>>>>>> feature
    // トークンを返す
    return $csrf_token;
}

<<<<<<< HEAD
/**
 * IPアドレス取得
 * @param
 * return string $$ip
=======

/**
 * IPアドレスを取得する
 * @return string IPアドレス
>>>>>>> feature
 */
function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
<<<<<<< HEAD
        // IPアドレスは共有インターネット接続から取得された
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IPアドレスはプロキシサーバーを経由して取得された
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IPアドレスはリモートアドレスから取得された
=======
        // 共有インターネット接続から取得されたIPアドレス
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // プロキシサーバーを経由して取得されたIPアドレス
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // リモートアドレスから取得されたIPアドレス
>>>>>>> feature
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
<<<<<<< HEAD
 * ユーザーエージェント取得
 * @param
 * return string $$ip
 */
function getUserAgent()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    return $userAgent;
}

?>
<?php
/*
    引数のバリデーション処理を実行する
    引数：任意のバリデーションパラメータ
    戻り値：数字・記号・アルファベット(32 bytes)の文字列であればその文字列、そうでなければ空文字列
*/


function validateLogin($data)
{
    $error = [];
    // メールアドレスのバリデーション
    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    }
    if (empty($data['password'])) {
        $error['password'] = 'パスワードを入力してください。';
    }
    return $error;
}

function validateUserSignupFormData($data)
{
    $error = [];

    // メールアドレスの取得
    $email = isset($data['email']) ? $data['email'] : '';
    // 確認用メールアドレスの取得
    $email_confirm = isset($data['email_confirm']) ? $data['email_confirm'] : '';

    // パスワードを取得
    $password = isset($data['password']) ? $data['password'] : '';
    // 確認用パスワードの取得
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    // 名前のバリデーション
=======
 * ユーザーエージェント（ブラウザ情報）を取得する
 * @return string ユーザーエージェント
 */
function getUserAgent()
{
    return $_SERVER['HTTP_USER_AGENT'];
}

/**
 * 現在の日時を取得する
 * @return string フォーマットされた日時文字列（YYYY-MM-DD HH:MM）
 */
function getDateTime()
{
    date_default_timezone_set('Asia/Tokyo');
    $today = new DateTime();
    return $today->format("Y-m-d H:i");
}



/**
 * 「admin_signin.php」と「admin_delete_account.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminLogin($data)
{
    $error = [];

    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    }

    if (empty($data['password'])) {
        $error['password'] = 'パスワードを入力してください。';
    }

    return $error;
}

/**
 * 「admin_update.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminUpdate($data)
{
    $error = [];

>>>>>>> feature
    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

<<<<<<< HEAD
    // メールアドレスのバリデーション
    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    } elseif (!preg_match('/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email'])) {
        $error['email'] = "「メールアドレス」は正しい形式で入力してください。";
    }

    // メールアドレスのバリデーション
    if (empty($email)) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($email_confirm)) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($email_confirm !== $email) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

=======
    if (empty($data['email'])) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($data['email_confirm'])) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($data['email_confirm'] !== $data['email']) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    return $error;
}

/**
 * 「admin_signup.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminSignup($data)
{
    $error = [];

    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    if (empty($data['email'])) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($data['email_confirm'])) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($data['email_confirm'] !== $data['email']) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    $password = isset($data['password']) ? $data['password'] : '';
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

>>>>>>> feature
    if (empty($password)) {
        $error['password'] = 'パスワードを入力してください。';
    } elseif (strlen($password) < 8 || strlen($password) > 16) {
        $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    } elseif (empty($password_confirm)) {
        $error['password_confirm'] = '確認用パスワードを入力してください。';
    } elseif ($password !== $password_confirm) {
        $error['password_confirm'] = 'パスワードが一致しません。';
    }

    return $error;
}

<<<<<<< HEAD


function validateInputFormData($data)
{
    $error = [];

    // メールアドレスの取得
    $email = isset($data['email']) ? $data['email'] : '';
    // 確認用メールアドレスの取得
    $email_confirm = isset($data['email_confirm']) ? $data['email_confirm'] : '';

    $gender = isset($data['gender']) ? $data['gender'] : '';
    $pref = isset($data['pref']) ? $data['pref'] : '';
    // パスワードを取得
    $password = isset($data['password']) ? $data['password'] : '';
    // 確認用パスワードの取得
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    // 名前のバリデーション
    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    // 電話番号のバリデーション
    if (empty($data['tel'])) {
        $error['tel'] = '電話番号を入力してください。';
    } else if (!preg_match('/^[0][0-9]{9,10}$/', str_replace('-', '', $data['tel']))) {
        $error['tel'] = '電話番号を正しく入力してください。';
    }

    // メールアドレスのバリデーション
    if (empty($data['email'])) {
        $error['email'] = "メールアドレスを入力してください。";
    } elseif (!preg_match('/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $data['email'])) {
        $error['email'] = "「メールアドレス」は正しい形式で入力してください。";
    }

    // メールアドレスのバリデーション
    if (empty($email)) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    } elseif (empty($email_confirm)) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($email_confirm !== $email) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    // 性別のバリデーション
    if (empty($data['gender'])) {
        $error['gender'] = '性別を選択してください';
    }

    // 都道府県のバリデーション
    if (empty($pref)) {
        $error['pref'] = '都道府県を選択してください';
    }

    // if (empty($password)) {
    //     $error['password'] = 'パスワードを入力してください。';
    // } elseif (strlen($password) < 8 || strlen($password) > 16) {
    //     $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    // } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
    //     $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    // } elseif (empty($password_confirm)) {
    //     $error['password_confirm'] = '確認用パスワードを入力してください。';
    // } elseif ($password !== $password_confirm) {
    //     $error['password_confirm'] = 'パスワードが一致しません。';
    // }
    return $error;
}


/*
    引数のバリデーション処理を実行する
    引数：任意のバリデーションパラメータ
    戻り値：数字・記号・アルファベット(16 bytes)の文字列であればその文字列、そうでなければ空文字列
*/
function validateStaffID($param)
{
    // 引数がstring型であることを検証
    if (!is_string($param)) {
        return "";
    }

    // 文字数が32文字以下であることを検証
    if (strlen($param) > 32) {
        return "";
    }

    // 半角数字、記号、アルファベットで構成されているかを検証
    if (!preg_match('/^[a-zA-Z0-9!-\/:-@\[-`\{-~]+$/', $param)) {
        return "";
    }

    // すべての検証を通過した場合はtrueを返す
    return $param;
}
=======
/**
 * 「admin_password_update.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateAdminPasswordUpdate($data)
{
    $error = [];

    $password = isset($data['password']) ? $data['password'] : '';
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    if (empty($password)) {
        $error['password'] = 'パスワードを入力してください。';
    } elseif (strlen($password) < 8 || strlen($password) > 16) {
        $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    } elseif (empty($password_confirm)) {
        $error['password_confirm'] = '確認用パスワードを入力してください。';
    } elseif ($password !== $password_confirm) {
        $error['password_confirm'] = 'パスワードが一致しません。';
    }

    return $error;
}

/**
 * 「user_form_regist.php」と「user_form_update.php」の入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateUserForm($data)
{
    $error = [];

    // 氏名のバリデーション
    if (empty($_POST['name'])) {
        $error['name'] = '氏名を入力してください。';
    } elseif (mb_strlen($_POST['name']) > 64) {
        $error['name'] = '氏名は64文字以内で入力してください。';
    }

    // 電話番号が空かどうかをチェック
    if (empty($data['tel'])) {
        $error['tel'] = '電話番号を入力してください';
    } else {
        // ハイフンを除去してから正規表現でバリデーション
        $telWithoutHyphen = str_replace('-', '', $data['tel']);
        if (!preg_match('/^(0\d{9,10}|\d{1,4}-\d{1,4}-\d{4})$/', $telWithoutHyphen)) {
            $error['tel'] = '正しい電話番号の形式で入力してください';
        }
    }

    if (empty($data['email'])) {
        $error['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '有効なメールアドレスを入力してください。';
    }

    $email_confirm = isset($data['email_confirm']) ? $data['email_confirm'] : '';
    if (empty($email_confirm)) {
        $error['email_confirm'] = '確認用メールアドレスを入力してください。';
    } elseif ($email_confirm !== $data['email']) {
        $error['email_confirm'] = 'メールアドレスが一致しません。';
    }

    if (empty($data['gender'])) {
        $error['gender'] = '性別を選択してください。';
    }

    // if (empty($data['pref'])) {
    //     $error['pref'] = '都道府県を選択してください。';
    // }

    return $error;
}

/**
 * 画像ファイルのバリデーションを行う
 * @param array $image アップロードされた画像の情報（$_FILESから取得）
 * @return array エラーメッセージの配列
 */
function validateImage($image, $validateerror)
{
    $error = [];

    $tmp_path = $image["tmp_name"];
    $imageName = $image["name"];

    // ファイルがアップロードされているかを確認
    if (!is_uploaded_file($tmp_path)) {
        $error['image_path'] = '画像がアップロードされていません';
        return $error;
    }

    $imageType = $image["type"];
    $allowedTypes = array('image/png', 'image/jpeg', 'image/gif');
    if (!in_array($imageType, $allowedTypes)) {
        $error['image_path'] = 'ファイルは画像形式のみアップロードできます';
        return $error;
    }

    // 他のバリデーションチェックでエラーがなければ保存する
    if (empty($validateerror)) {
        $filename = date('YmdHis') . '_' . $imageName;
        $uploadDir = '../../public/image/';

        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $error['image_path'] = 'ディレクトリの作成に失敗しました';
                return $error;
            }
        }

        $savePath = $uploadDir . $filename;

        if (!move_uploaded_file($tmp_path, $savePath)) {
            $error['image_path'] = 'ファイルの保存に失敗しました';
            return $error;
        }
    }
    $_SESSION['savePath'] = $savePath;

    return [];
}


/**
 * 画像ファイルのバリデーションを行う
 * @param array $image アップロードされた画像の情報（$_FILESから取得）
 * @return array エラーメッセージの配列
 */
function uploadImage($savePath)
{
    $savePath = $savePath ?? '';
    return $savePath;
}



function setCategoryName($category)
{
    if ($category === 1) {
        return '日常';
    } else if ($category === 2) {
        return 'プログラミン';
    } else {
        var_dump($category);
        return 'その他';
    }
}



?>

>>>>>>> feature
