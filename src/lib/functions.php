<?php

/**
 * 各種関数
 *
 * @version $Revision: 4.0.0 $
 * @copyright
 * @author
 */
?>

<?php

/**
 * 文字列をHTML特殊文字に変換（サニタイズ処理）
 * @param string $str 変換する文字列
 * @return string 変換された文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * CSRF対策用トークンを生成し、セッションに保存する
 * @return string 生成されたCSRFトークン
 */
function setToken()
{
    // トークンを生成
    $csrf_token = bin2hex(random_bytes(32));
    // セッションにトークンを保存
    $_SESSION['csrf_token'] = $csrf_token;
    // トークンを返す
    return $csrf_token;
}

/**
 * IPアドレスを取得する
 * @return string IPアドレス
 */
function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // 共有インターネット接続から取得されたIPアドレス
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // プロキシサーバーを経由して取得されたIPアドレス
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // リモートアドレスから取得されたIPアドレス
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
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
 * ログインフォームの入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateLogin($data)
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
 * ユーザー登録フォームの入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateUserSignupFormData($data)
{
    $error = [];

    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
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

    $password = isset($data['password']) ? $data['password'] : '';
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    if (empty($password)) {
        $error['password'] = 'パスワードを入力してください。';
    } elseif (strlen($password) < 8 || strlen($password) > 16) {
        $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
    }

    if (empty($password_confirm)) {
        $error['password_confirm'] = '確認用パスワードを入力してください。';
    } elseif ($password !== $password_confirm) {
        $error['password_confirm'] = 'パスワードが一致しません。';
    }

    return $error;
}

/**
 * 入力フォームの入力データをバリデーションする
 * @param array $data フォームデータ
 * @return array エラーメッセージの配列
 */
function validateInputFormData($data)
{
    $error = [];

    if (empty($data['name'])) {
        $error['name'] = '氏名を入力してください。';
    }

    if (empty($data['tel'])) {
        $error['tel'] = '電話番号を入力してください。';
    } elseif (!preg_match('/^[0][0-9]{9,10}$/', str_replace('-', '', $data['tel']))) {
        $error['tel'] = '電話番号を正しく入力してください。';
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

    if (empty($data['pref'])) {
        $error['pref'] = '都道府県を選択してください。';
    }

    $password = isset($data['password']) ? $data['password'] : '';
    $password_confirm = isset($data['password_confirm']) ? $data['password_confirm'] : '';

    if (!empty($password)) {
        if (strlen($password) < 8 || strlen($password) > 16) {
            $error['password'] = 'パスワードは8文字以上16文字以下で入力してください。';
        } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
            $error['password'] = 'パスワードには英字、数字、記号を含めてください。';
        }

        if (empty($password_confirm)) {
            $error['password_confirm'] = '確認用パスワードを入力してください。';
        } elseif ($password !== $password_confirm) {
            $error['password_confirm'] = 'パスワードが一致しません。';
        }
    }

    return $error;
}

/**
 * 画像ファイルのバリデーションを行う
 * @param array $image アップロードされた画像の情報（$_FILESから取得）
 * @return array エラーメッセージの配列
 */
function validateImage($image)
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

