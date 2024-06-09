<?php

require_once('../config/env.php');

class Dbc
{
    protected $table_name = 'form';

    // (__construct)インスタンス生成された時に呼ばれる
    // function __construct($table_name)
    // {
    //     $this->table_name = $table_name;
    // }

    //============================================
    // 1.DBへ接続
    //============================================
    public function dbConnect()
    // protected function dbConnect()
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
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            //echo 'DBの接続成功';
            return $dbh;
        } catch (PDOException $e) {
            echo 'DBの接続失敗' . $e->getMessage();
            exit();
        };
    }


    // //============================================
    // // INSERT文（データ追加）
    // //============================================
    public function Create($blogs)
    {
        $sql = "INSERT INTO $this->table_name(title, content, category,  publish_status) VALUES(:title, :content, :category, :publish_status)";

        $dbh = $this->dbConnect();
        //トランザクションを始める
        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':title', $blogs['title'], PDO::PARAM_STR);
            $stmt->bindValue(':content', $blogs['content'], PDO::PARAM_STR);
            $stmt->bindValue(':category', $blogs['category'], PDO::PARAM_INT);
            $stmt->bindValue(':publish_status', $blogs['publish_status'], PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
            echo 'ブログを投稿しました';
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    // //============================================
    // // SELECT文（データ取得）
    // //============================================
    public function Read()
    {
        //DBに接続
        $dbh = $this->dbConnect();
        //①SQLの準備
        $sql = "SELECT * FROM $this->table_name";
        //②SQLの実行
        $stmt = $dbh->query($sql);
        //③SQLの結果を受け取る
        $result = $stmt->fetchall(\PDO::FETCH_ASSOC);
        // 接続を閉じる
        $dbh = null;
        return $result;
    }

    // //============================================
    // // UPDATE文（データ更新）
    // //============================================
    public function Update($form)
    {
        $sql = "UPDATE $this->table_name SET
        name = :name, content = :content, category = :category,  publish_status = :publish_status WHERE id = :id";

        $dbh = $this->dbConnect();
        //トランザクションを始める
        $dbh->beginTransaction();
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':name', $form['name'], PDO::PARAM_STR);
            // $stmt->bindValue(':content', $form['content'], PDO::PARAM_STR);
            // $stmt->bindValue(':category', $form['category'], PDO::PARAM_INT);
            // $stmt->bindValue(':publish_status', $form['publish_status'], PDO::PARAM_INT);
            // $stmt->bindValue(':id', $form['id'], PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            exit($e);
        }
    }

    // //============================================
    // // DELETE文（データ削除）
    // //============================================
    // public function Delete($id)
    // {
    //     if (empty($id)) {
    //         exit('IDが不正です');
    //     }
    //     $dbh = $this->DbConnect();

    //     //SQL準備
    //     $stmt = $dbh->prepare("DELETE FROM $this->table_name where id = :id Limit 1");
    //     $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);

    //     //SQL実行
    //     $stmt->execute();
    // }

    // //============================================
    // // SELECT文（データ詳細）
    // //============================================
    public function Detail($id)
    {
        if (empty($id)) {
            exit('IDが不正です');
        }

        $dbh = $this->DbConnect();

        //SQL準備
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);

        //SQL実行
        $stmt->execute();
        //結果を表示
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        // var_dump($result);
        if (!$result) {
            exit('ブログがありません');
        }
        return $result;
    }

    // /**
    //  * ファイルデータを保存
    //  * @param string $filename ファイル名
    //  * @param string $save_path 保存先のパス
    //  * @param string $caption 投稿の説明
    //  * @param bool $result
    //  */
    // function fileSave($filename, $save_path, $caption)
    // {
    //     $result = False;

    //     $sql = "INSERT INTO file(file_name, file_path, description) VALUES (?, ?, ?)";

    //     try {
    //         $stmt = $this->dbConnect()->prepare($sql);
    //         $stmt->bindValue(1, $filename);
    //         $stmt->bindValue(2, $save_path);
    //         $stmt->bindValue(3, $caption);
    //         //(execute)SQLを実行し結果を$resultに格納
    //         $result = $stmt->execute();
    //         return $result;
    //     } catch (\Exception $e) {
    //         echo $e->getMessage();
    //         return $result;
    //     }
    // }

    // /**
    //  * ファイルデータを取得
    //  * @return array $fileData
    //  */
    // function getAllFile()
    // {

    //     $sql = "SELECT * FROM file ORDER BY id DESC";
    //     $fileData = $this->dbConnect()->query($sql);
    //     return $fileData;
    // }
}
