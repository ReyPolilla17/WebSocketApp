DELIMITER $

DROP PROCEDURE IF EXISTS createUser$
DROP PROCEDURE IF EXISTS updateUser$
DROP PROCEDURE IF EXISTS deleteUser$

DROP PROCEDURE IF EXISTS createGroup$
DROP PROCEDURE IF EXISTS updateGroup$
DROP PROCEDURE IF EXISTS deleteGroup$
DROP PROCEDURE IF EXISTS insertInGroup$

DROP PROCEDURE IF EXISTS createChat$

DROP PROCEDURE IF EXISTS sendMessage$
DROP PROCEDURE IF EXISTS readMessages$

DROP PROCEDURE IF EXISTS getUserChats$


CREATE PROCEDURE createUser(IN user_name VARCHAR(100), IN user_password VARCHAR(100), IN birth_date DATE)
BEGIN
    INSERT INTO users (user_name, user_password, birth_date) VALUES (user_name, user_password, birth_date);
END$

CREATE PROCEDURE updateUser(IN user_id INT, IN user_name INT, IN user_password INT, IN birth_date DATE, IN user_image MEDIUMBLOB)
BEGIN
    UPDATE users u SET u.user_name = user_name, u.user_password = user_password, u.birth_date = birth_date, u.user_image = user_image
    WHERE u.user_id = user_id;
END$

CREATE PROCEDURE deleteUser(IN d_user_id INT)
BEGIN
    DELETE FROM users WHERE user_id = d_user_id;
END$


CREATE PROCEDURE createGroup(IN user_id INT, IN conversation_name VARCHAR(100))
BEGIN
    DECLARE conversation_id INT;

    INSERT INTO conversations (user_id, conversation_name) VALUES (user_id, conversation_name);

    SELECT LAST_INSERT_ID() INTO conversation_id;

    INSERT INTO user_conversation (user_id, conversation_id) VALUES (user_id, conversation_id);
END$

CREATE PROCEDURE updateGroup(IN conversation_id INT, IN conversation_name VARCHAR(100), IN conversation_image MEDIUMBLOB)
BEGIN
    UPDATE conversations c SET c.conversation_name = conversation_name, c.conversation_image = conversation_image
    WHERE c.conversation_id = conversation_id;
END$

CREATE PROCEDURE deleteGroup(IN d_conversation_id INT)
BEGIN
    DELETE FROM conversations WHERE conversation_id = d_conversation_id;
END$

CREATE PROCEDURE insertInGroup(IN conversation_id INT, IN user_id INT)
BEGIN
    DECLARE user_in_group INT DEFAULT 0;

    SELECT COUNT(*) INTO user_in_group FROM user_conversation uc WHERE uc.conversation_id = conversation_id AND uc.user_id = user_id;

    IF user_in_group = 0 THEN
        INSERT INTO user_conversation (conversation_id, user_id) VALUES (conversation_id, user_id);
    END IF;
END$


CREATE PROCEDURE createChat(IN user_id_1 INT, IN user_id_2 INT)
BEGIN
    DECLARE conversation_id INT DEFAULT 0;
    DECLARE chat_exists INT DEFAULT 0;

    SELECT COUNT(*) INTO chat_exists FROM conversations c 
    RIGHT JOIN user_conversation uc 
    ON c.conversation_id = uc.conversation_id 
    WHERE c.is_chat = TRUE 
    AND uc.user_id IN (user_id_1, user_id_2)
    GROUP BY c.conversation_id DESC LIMIT 1;

    IF chat_exists != 2 THEN
        INSERT INTO conversations (is_chat) VALUES (TRUE);

        SELECT LAST_INSERT_ID() INTO conversation_id;

        INSERT INTO user_conversation (user_id, conversation_id) VALUES (user_id_1, conversation_id), (user_id_2, conversation_id);
    END IF;

    SELECT conversation_id;
END$


CREATE PROCEDURE sendMessage(IN message_content VARCHAR(2000), IN conversation_id INT, IN user_id INT)
BEGIN
    DECLARE message_id INT;

    INSERT INTO messages (message_content, conversation_id, user_id) VALUES (message_content, conversation_id, user_id);

    SELECT LAST_INSERT_ID() INTO message_id;

    SELECT message_id, conversation_id;
END$

CREATE PROCEDURE readMessages(IN user_id INT, IN conversation_id INT)
BEGIN
    INSERT INTO read_messages
    SELECT user_id, vum.message_id, NOW() FROM v_unread_messages vum WHERE vum.conversation_id = conversation_id;
END$

DROP PROCEDURE IF EXISTS getUserChats$

CREATE PROCEDURE getUserChats(IN c_user_id INT)
BEGIN
    SELECT c.conversation_id chat_id, 
        IF(c.is_chat, u.user_image, c.conversation_image) chat_image, IF(c.is_chat, u.user_name, c.conversation_name) chat_name
    FROM user_conversation uc 
        LEFT JOIN users u ON uc.user_id = u.user_id 
        LEFT JOIN conversations c ON uc.conversation_id = c.conversation_id
    WHERE uc.conversation_id IN(
        SELECT conversation_id 
        FROM user_conversation 
        WHERE user_id = c_user_id
    ) 
    AND u.user_id != c_user_id;
END$