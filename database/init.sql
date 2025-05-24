USE designdb;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username NVARCHAR(255) NOT NULL UNIQUE,
    password_hash NVARCHAR(255) NOT NULL
);

CREATE UNIQUE INDEX idx_users_username ON Users(username);

CREATE TABLE IF NOT EXISTS UserSessions (
    session_id CHAR(32) PRIMARY KEY NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

DELIMITER $$

CREATE EVENT IF NOT EXISTS delete_old_sessions
ON SCHEDULE EVERY 4 HOUR
DO
BEGIN
    DELETE FROM UserSessions
    WHERE created_at < NOW() - INTERVAL 7 DAY;
END $$

DELIMITER ;

-- password is 'password' (Very secure good job)
-- INSERT INTO Users (username, password_hash) VALUES ('shrimp332', '$2y$10$13BTa74Q0.vgdvCvpmlFc.ddEg9Zzbb6YHCKeiXrVRkFDpdmpsy9q')

CREATE TABLE IF NOT EXISTS Posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    title NVARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    owner_id INT NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Likes (
    user_id INT,
    post_id INT
    PRIMARY KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES Posts(post_id) ON DELETE CASCADE
);
 
CREATE TABLE IF NOT EXISTS Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    owner_id INT NOT NULL,
    post_id INT NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES Posts(post_id) ON DELETE CASCADE
);
