<?php
require "Mailer.php";
require "config.php";

class Auth
{

    private $host;
    private $user;
    private $name;
    private $password;
    private $dbTable;
    private $dbConn;

    function __construct()
    {
        $this->host = DB_HOST;
        $this->user = DB_USERNAME;
        $this->name = DB_NAME;
        $this->password = DB_PASSWORD;
        $this->dbTable = DB_TABLE;
        $this->dbConn = $this->connectDB();
    }

    function connectDB()
    {
        return new mysqli($this->host, $this->user, $this->password, $this->name);
    }

    function createAlphaNumericString($length = 10)
    {
        $chars = '0123456789ABCDEFGHIJKLMOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $size = strlen($chars);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[rand(0, $size - 1)];
        }
        return $result;
    }

    function signUp($id)
    {
        $mailer = new Mailer();
        $password = $this->createAlphaNumericString(10);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $base_query = "INSERT INTO " . $this->dbTable . " (tumid, password, creation_time) VALUES (?, ?, NOW()) AS new ON DUPLICATE KEY UPDATE password = new.password, creation_time = NOW()";
        $stmt = $this->dbConn->prepare($base_query);
        $stmt->bind_param('ss', $id, $hashed_password);
        if (!$stmt->execute()) {
            return 2;
        }

        return $mailer->sendPassMail($id, $password);
    }

    function login($id, $password)
    {
        $base_query = "SELECT password FROM " . $this->dbTable . " WHERE tumid=?";
        $stmt = $this->dbConn->prepare($base_query);
        $stmt->bind_param('s', $id);
        if (!$stmt->execute()) {
            return 2;
        }

        $hashed_password = "";
        $stmt->bind_result($hashed_password);
        $stmt->store_result();
        if ($stmt->num_rows == 1 & $stmt->fetch()) {
            if(password_verify($password, $hashed_password)) {
                return 0;
            }
        }
        return 1;
    }
}