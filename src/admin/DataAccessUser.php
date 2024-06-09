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
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $password = DB_PASS;
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            $dbh = new PDO($dsn, $user, $password, [
                //エラーのモードを決める
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //配列をキーと値で返す
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // PDOのエミュレート機能を無効
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            //echo 'DBの接続成功';
            return $dbh;
        } catch (PDOException $e) {
            echo 'DBの接続失敗' . $e->getMessage();
            exit();
        };
    }


    public function AdminCreate($adminData)
    {
        $sql = "INSERT INTO $this->table_name(name, email, password, user_agent, ip_address) VALUES (:name, :email, :password, :user_agent, :ip_address)";

        $dbh = $this->AdminConnect();
        //トランザクションを開始
        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $adminData['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $adminData['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($adminData['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':user_agent', getUserAgent(), PDO::PARAM_STR);
            $stmt->bindValue(':ip_address', getIpAddress(), PDO::PARAM_STR);
            $stmt->execute();
            $dbh->commit();
            $_SESSION['message'] = 'ユーザー登録完了しました。';
            return true;
        } catch (PDOException $e) {
            $dbh->rollBack();
            if ($e->getCode() == 23000) {
                $_SESSION['error'] = 'このメールアドレスは既に登録されています。';
            } else {
                $_SESSION['error'] = '登録に失敗しました: ' . $e->getMessage();
            }
            error_log('AdminCreateエラー: ' . $e->getMessage());

            // return false;
            header('Location: user_signup.php');
            exit();
        }
    }
};
