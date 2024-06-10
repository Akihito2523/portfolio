<?php

require_once('../lib/functions.php');
require_once('../config/env.php');

class Admin
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = preg_replace('/[^a-zA-Z0-9_]/', '', 'admins');
    }
    //============================================
    // 1.DBへ接続
    //============================================
    public function AdminConnect()
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

    public function AdminCreate($data)
    {
        $sql = "INSERT INTO $this->table_name (name, email, password, user_agent, ip_address) VALUES (:name, :email, :password, :user_agent, :ip_address)";

        $dbh = $this->AdminConnect();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':user_agent', getUserAgent(), PDO::PARAM_STR);
            $stmt->bindValue(':ip_address', getIpAddress(), PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['message'] = 'ユーザー登録完了しました。';
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['error'] = 'このメールアドレスは既に登録されています。';
            } else {
                $_SESSION['error'] = '登録に失敗しました: ' . $e->getMessage();
            }
            error_log('AdminCreateエラー: ' . $e->getMessage());
            header('Location: user_signup.php');
            exit();
        }
    }

    public function login($data)
    {

        $sql = "SELECT * FROM $this->table_name WHERE email = :email";
        $dbh = $this->AdminConnect();

        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->execute();
            $member = $stmt->fetch();
            if ($member && password_verify($data['password'], $member['password'])) {
                $_SESSION['name'] = $member['name'];
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log('Loginエラー: ' . $e->getMessage());
            $_SESSION['error'] = 'ログイン認証に失敗しました';
            header('Location: login.php');
            exit();
        }
    }

    /**
     * ログアウト処理
     */
    public static function logout()
    {
        //セッションの中身を空にする
        $_SESSION = array();
        session_destroy();
    }
    
};
