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
    password_reset_requested_at TIMESTAMP NULL,
    password_changed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);


INSERT INTO admin (name, email, password) 
VALUES ('テスト', 'test@gmail.com', '11111111');


CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NULL,
    tel VARCHAR(20) NULL,
    email VARCHAR(255) NOT NULL,
    gender VARCHAR(255) NULL,
    genre VARCHAR(255) NULL,
    pref VARCHAR(255) NULL,
    image_path VARCHAR(255) NOT NULL UNIQUE,
    textarea TEXT NULL,
    checkbox_name VARCHAR(50) NULL,
    user_agent VARCHAR(255),
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);




INSERT INTO user (name, tel, email, gender, genre, pref, image_path, textarea, password, checkbox_name, user_agent, ip_address)
VALUES
('John Doe', '123-456-7890', 'john.doe@example.com', '男性', 'カメラ,パソコン', '東京都', '/../../public/image/IMG_1.JPG', 'Lorem ipsum dolor sit amet.', 'password123', '同意', 'Mozilla/5.0', '192.168.1.1'),
('Jane Smith', '456-789-0123', 'jane.smith@example.com', '女性', 'パソコン', '大阪府', '/../../public/image/IMG_2.JPG', 'Nulla facilisi.', 'p@ssw0rd', '同意', 'Chrome', '10.0.0.1'),
('Michael Johnson', '789-012-3456', 'michael.johnson@example.com', 'その他', 'カメラ,時計', '京都府', '/../../public/image/IMG_3.JPG', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed aliquam.', 'securepass', '同意', 'Safari', '172.16.254.1'),
('Emily Davis', '234-567-8901', 'emily.davis@example.com', '女性', 'パソコン', '愛知県', '/../../public/image/IMG_4.JPG', 'Donec sollicitudin molestie malesuada.', '12345678', '同意', 'Firefox', '192.0.2.1'),
('David Wilson', '567-890-1234', 'david.wilson@example.com', '男性', 'カメラ', '北海道', '/../../public/image/IMG_5.JPG', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'qwerty', '同意', 'Opera', '198.51.100.1'),
('Sarah Brown', '890-123-4567', 'sarah.brown@example.com', '女性', 'カメラ,パソコン', '福岡県', '/../../public/image/IMG_6.JPG', 'Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.', 'password', '同意', 'Edge', '203.0.113.1'),
('James Miller', '123-456-7890', 'james.miller@example.com', '男性', 'パソコン', '静岡県', '/../../public/image/IMG_7.JPG', 'Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'pass1234', '同意', 'Mozilla/4.0', '192.0.2.2'),
('Emma Garcia', '456-789-0123', 'emma.garcia@example.com', '女性', 'カメラ,時計', '長野県', '/../../public/image/IMG_8.JPG', 'Nulla porttitor accumsan tincidunt.', 'securepassword', '同意', 'Chrome', '172.16.254.2'),
('Christopher Lee', '789-012-3456', 'christopher.lee@example.com', '男性', 'カメラ', '岡山県', '/../../public/image/IMG_9.JPG', 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.', 'mypassword', '同意', 'Safari', '192.0.2.3'),
('Olivia Martinez', '234-567-8901', 'olivia.martinez@example.com', '女性', 'パソコン', '奈良県', '/../../public/image/IMG_10.JPG', 'Nulla quis lorem ut libero malesuada feugiat.', 'password123', '同意', 'Firefox', '198.51.100.2'),
('William Taylor', '567-890-1234', 'william.taylor@example.com', '男性', 'カメラ,時計', '熊本県', '/../../public/image/IMG_11.JPG', 'Nulla porttitor accumsan tincidunt.', '123456', '同意', 'Opera', '203.0.113.2'),
('Sophia Anderson', '890-123-4567', 'sophia.anderson@example.com', '女性', 'パソコン', '山口県', '/../../public/image/IMG_12.JPG', 'Cras ultricies ligula sed magna dictum porta.', 'qwerty123', '同意', 'Edge', '192.0.2.4'),
('Alexander Hernandez', '123-456-7890', 'alexander.hernandez@example.com', '男性', 'カメラ', '栃木県', '/../../public/image/IMG_13.JPG', 'Donec sollicitudin molestie malesuada.', 'password1', '同意', 'Mozilla/5.0', '172.16.254.3'),
('Isabella Lopez', '456-789-0123', 'isabella.lopez@example.com', '女性', 'パソコン,時計', '鹿児島県', '/../../public/image/IMG_14.JPG', 'Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.', 'abc123', '同意', 'Chrome', '192.0.2.5'),
('Noah Gonzalez', '789-012-3456', 'noah.gonzalez@example.com', 'その他', 'カメラ', '沖縄県', '/../../public/image/IMG_15.JPG', 'Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', 'password1234', '同意', 'Safari', '198.51.100.3'),
('Grace Perez', '234-567-8901', 'grace.perez@example.com', '女性', 'カメラ,パソコン', '宮城県', '/../../public/image/IMG_16.JPG', 'Nulla quis lorem ut libero malesuada feugiat.', 'securepass123', '同意', 'Firefox', '203.0.113.3'),
('Lucas Rivera', '567-890-1234', 'lucas.rivera@example.com', '男性', 'パソコン', '三重県', '/../../public/image/IMG_17.JPG', 'Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus.', 'password456', '同意', 'Opera', '192.0.2.6'),
('Ava Carter', '890-123-4567', 'ava.carter@example.com', '女性', 'カメラ,時計', '茨城県', '/../../public/image/IMG_18.JPG', 'Curabitur aliquet quam id dui posuere blandit.', '12345678', '同意', 'Edge', '172.16.254.4'),
('Logan Evans', '123-456-7890', 'logan.evans@example.com', '男性', 'パソコン', '福島県', '/../../public/image/IMG_19.JPG', 'Nulla porttitor accumsan tincidunt.', 'password789', '同意', 'Mozilla/4.0', '192.0.2.7'),
('Mia Morris', '456-789-0123', 'mia.morris@example.com', '女性', 'カメラ', '岐阜県', '/../../public/image/IMG_20.JPG', 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.', 'abc1234', '同意', 'Chrome', '198.51.100.4');






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

