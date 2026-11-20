DROP USER IF EXISTS 'messageApp'@'localhost'; -- Elimina al usuario en caso de que exista
CREATE USER 'messageApp'@'localhost' IDENTIFIED BY '1234'; -- Crea al usuario 'messageApp' con la contraseña '1234'

GRANT SELECT ON messages.* TO 'messageApp'@'localhost';
GRANT EXECUTE ON messages.* TO 'messageApp'@'localhost';