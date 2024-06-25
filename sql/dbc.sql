CREATE TABLE form 
(id INT AUTO_INCREMENT PRIMARY KEY , name VARCHAR(255));


insert into form values(1 , 'テスト名前');



CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NULL,
    tel VARCHAR(20) NULL,
    email VARCHAR(255) NOT NULL,
    gender VARCHAR(255) NULL,
    genre VARCHAR(255) NULL,
    pref VARCHAR(255) NULL,
    datetimelocal DATETIME NULL,
    image_path VARCHAR(255) NOT NULL UNIQUE,
    textarea TEXT NULL,
    password VARCHAR(191) NOT NULL,
    checkbox_name VARCHAR(50) NULL,
    user_agent VARCHAR(255),
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);



-- アドミンユーザー
-- ユーザーエージェント、IPアドレス、最終ログイン日時、登録日時、更新日時、パスワード変更日時、パスワード再登録依頼日時、名前、メールアドレス、パスポート
CREATE TABLE admin (
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





CREATE TABLE file 
(id INT AUTO_INCREMENT PRIMARY KEY ,file_name VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL UNIQUE, description VARCHAR(140), insert_time DATETIME DEFAULT CURRENT_TIMESTAMP, update_time DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);



CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category_id INT NOT NULL,
    publish_status TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

