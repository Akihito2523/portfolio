CREATE TABLE form 
(id INT AUTO_INCREMENT PRIMARY KEY , name VARCHAR(255));


insert into form values(1 , 'テスト名前');





-- アドミンユーザー
-- ユーザーエージェント、IPアドレス、最終ログイン日時、登録日時、更新日時、パスワード変更日時、パスワード再登録依頼日時、名前、メールアドレス、パスポート
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(191) NOT NULL,
    user_agent VARCHAR(255),
    ip_address VARCHAR(45) NULL,
    last_login TIMESTAMP NULL,
    password_changed_at TIMESTAMP NULL,
    password_reset_requested_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO admins (name, email, password) 
VALUES ('テスト', 'test@gmail.com', '11111111');
