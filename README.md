# falsePastebin
A(nother) pastebin clone.

Follow the following steps to setup:
1. Clone or download the repository
2. Start MySQL and create a database called 'pastebin_clone'
3. Create the following tables - users and pastes:
```sql
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE pastes (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    public INT(1) NOT NULL,
    title VARCHAR(1000) NOT NULL,
    paste VARCHAR(10000) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```
4. Open mysql.php and edit the credentials of
```php
$host = "";
$username = "";
$password = "";
$db_name = "";
```
5. Start your server and run :-)
