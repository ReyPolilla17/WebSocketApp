DELIMITER $

DROP TABLE IF EXISTS read_messages$
DROP TABLE IF EXISTS user_conversation$
DROP TABLE IF EXISTS messages$
DROP TABLE IF EXISTS conversations$
DROP TABLE IF EXISTS users$

DROP VIEW IF EXISTS v_unread_messages$
DROP VIEW IF EXISTS v_chat_messages$

CREATE TABLE users (
    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    user_password VARCHAR(100) NOT NULL,
    user_image MEDIUMBLOB NOT NULL DEFAULT '0x0',
    birth_date DATE NOT NULL,
    creation_date DATE NOT NULL,

    INDEX(user_name)
)$

CREATE TABLE conversations (
    conversation_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    conversation_name VARCHAR(100),
    conversation_image MEDIUMBLOB NOT NULL DEFAULT '0x0',
    creation_date DATE NOT NULL,
    user_id INT,
    is_chat BOOLEAN NOT NULL DEFAULT FALSE,

    INDEX(conversation_name),

    CONSTRAINT c_user_id_fk FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE
)$

CREATE TABLE messages (
    message_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    message_timestamp TIMESTAMP NOT NULL,
    message_content VARCHAR(2000) NOT NULL,
    user_id INT,
    conversation_id INT NOT NULL,

    INDEX(message_timestamp),
    INDEX(conversation_id),

    CONSTRAINT m_user_id_fk FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT m_conversation_id_fk FOREIGN KEY (conversation_id) REFERENCES conversations (conversation_id) ON DELETE CASCADE ON UPDATE CASCADE
)$

CREATE TABLE user_conversation (
    user_id INT NOT NULL,
    conversation_id INT NOT NULL,

    CONSTRAINT uc_user_id_fk FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT uc_conversation_id_fk FOREIGN KEY (conversation_id) REFERENCES conversations (conversation_id) ON DELETE CASCADE ON UPDATE CASCADE
)$

CREATE TABLE read_messages (
    user_id INT NOT NULL,
    message_id INT NOT NULL,
    read_timestamp TIMESTAMP NOT NULL,

    CONSTRAINT rm_user_id_fk FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT rm_message_id_fk FOREIGN KEY (message_id) REFERENCES messages (message_id) ON DELETE CASCADE ON UPDATE CASCADE
)$


CREATE TRIGGER t_conversations BEFORE INSERT ON conversations FOR EACH ROW
BEGIN
    SET NEW.creation_date = CURDATE();
END$

CREATE TRIGGER t_users BEFORE INSERT ON users FOR EACH ROW
BEGIN
    SET NEW.creation_date = CURDATE();
END$

CREATE TRIGGER t_messages BEFORE INSERT ON messages FOR EACH ROW
BEGIN
    SET NEW.message_timestamp = NOW();
END$

CREATE TRIGGER t_read_messages BEFORE INSERT ON read_messages FOR EACH ROW
BEGIN
    SET NEW.read_timestamp = NOW();
END$


CREATE VIEW v_unread_messages AS
    SELECT * FROM messages m WHERE m.message_id NOT IN (SELECT message_id FROM read_messages)$

CREATE VIEW v_chat_messages AS
    SELECT conversation_id, message_id, message_timestamp, message_content, u.user_id, user_name, user_image FROM messages m LEFT JOIN users u ON m.user_id = u.user_id ORDER BY message_timestamp DESC$