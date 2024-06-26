<?php

require_once('../lib/functions.php');
require_once('../config/env.php');

class Admin
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = preg_replace('/[^a-zA-Z0-9_]/', '', 'admin');
    }
    //============================================
    // 1.DBへ接続
    //============================================
    public function AdminDbConnect()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        try {
            $dbh = new PDO($dsn, DB_USER, DB_PASS,  [
                //エラーのモードを決める
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //配列をキーと値で返す
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // PDOのエミュレート機能を無効
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return $dbh;
        } catch (PDOException $e) {
            error_log('DB接続エラー: ' . $e->getMessage());
            throw new Exception('データベース接続に失敗しました');
        }
    }

    //============================================
    // WHERE文（ログイン情報）
    //============================================
    public function AdminDbLogin($data)
    {

        $sql = "SELECT * FROM $this->table_name WHERE email = :email";
        $dbh = $this->AdminDbConnect();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->execute();
            $member = $stmt->fetch();
            if ($member['deleted_at']) {
                $_SESSION['error'] = '退会済みです';
                return false;
            } else {
                if ($member && password_verify($data['password'], $member['password'])) {
                    // ログイン成功時に最終ログイン日時を更新する
                    $sql_update = "UPDATE $this->table_name SET last_login = :last_login WHERE id = :id";
                    $stmt_update = $dbh->prepare($sql_update);
                    $stmt_update->bindValue(':last_login', getDateTime(), PDO::PARAM_STR);
                    $stmt_update->bindValue(':id', $member['id'], PDO::PARAM_INT);
                    $stmt_update->execute();
                    // セッションにユーザー情報を保存
                    $_SESSION['id'] = $member['id'];
                    $_SESSION['name'] = $member['name'];
                    return true;
                } else {
                    $_SESSION['error'] = 'メールアドレスまたはパスワードが正しくありません';
                    return false;
                }
            }
        } catch (Exception $e) {
            error_log('Loginエラー: ' . $e->getMessage());
            $_SESSION['error'] = 'ログイン認証に失敗しました';
        }
    }

    //============================================
    // INSERT文（データ追加）
    //============================================
    public function AdminDbCreate($data)
    {
        $sql = "INSERT INTO $this->table_name (name, email, password, user_agent, ip_address) VALUES (:name, :email, :password, :user_agent, :ip_address)";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':user_agent', getUserAgent(), PDO::PARAM_STR);
            $stmt->bindValue(':ip_address', getIpAddress(), PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['message'] = '会員登録が完了しました。';
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'このメールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbCreateエラー: ' . $e->getMessage());
        }
    }

    //============================================
    // UPDATE文（会員情報変更）
    //============================================
    public function AdminDbUpdate($data)
    {
        $sql = "UPDATE $this->table_name SET
        name = :name, email = :email, updated_at = :updated_at WHERE id = :id";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', getDateTime(), PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['message'] = 'ユーザー登録更新完了しました。';
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'このメールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbCreateエラー: ' . $e->getMessage());
        }
    }

    //============================================
    // UPDATE文（削除日時）
    //============================================
    public function AdminDbUpdateDeleted($data)
    {
        $sql = "UPDATE $this->table_name SET deleted_at = :deleted_at WHERE id = :id";

        $dbh = $this->AdminDbConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindValue(':deleted_at', getDateTime(), PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['message'] = '退会が完了しました。';
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = ($e->getCode() == 23000) ? 'このメールアドレスは既に登録されています。' : '登録に失敗しました: ' . $e->getMessage();
            error_log('AdminDbCreateエラー: ' . $e->getMessage());
        }
    }



    //============================================
    // SELECT文（データ詳細）
    //============================================
    public function AdminDbDetail($id)
    {
        if (empty($id)) {
            throw new Exception('IDが不正です');
        }

        $dbh = $this->AdminDbConnect();
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name where id = :id Limit 1");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $dbh = null;
        if (!$result) {
            throw new Exception('データが見つかりません');
        }
        return $result;
    }

    /**
     * ログアウト処理
     */
    public function AdminDblogout()
    {
        session_unset();
        session_destroy();
        header('Location: admin_signin.php');
        exit();
    }

    /**
     * パスワード再登録
     */
    public function AdminDbPassReset($email)
    {

        $sql = "SELECT * FROM $this->table_name WHERE email = :email";
        $dbh = $this->AdminDbConnect();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            // メールアドレスに一致するエントリがあるかどうかを確認
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            error_log('AdminDbPassResetエラー: ' . $e->getMessage());
            throw new Exception('登録に失敗しました');
        }
    }

    /**
     * パスワード再登録
     */
    public function AdminDbEmail($email)
    {
        // 以下、mail関数でパスワードリセット用メールを送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        // URLはご自身の環境に合わせてください
        $url = "http://localhost:1515";

        $subject =  'パスワードリセット用URLをお送りします';

        $body = <<<EOD
      24時間以内に下記URLへアクセスし、パスワードの変更を完了してください。
      {$url}
      EOD;

        // Fromはご自身の環境に合わせてください
        $headers = "From : http://localhost:1515\n";
        // text/htmlを指定し、html形式で送ることも可能
        $headers .= "Content-Type : text/plain";

        // mb_send_mailは成功したらtrue、失敗したらfalseを返す
        $isSent = mb_send_mail($email, $subject, $body, $headers);

        return $isSent;
        // if (!$isSent) throw new \Exception('メール送信に失敗しました。');
    }
};
