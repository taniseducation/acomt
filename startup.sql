CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
GRANT ALL ON *.* TO 'username'@'localhost';
FLUSH PRIVILEGES;

