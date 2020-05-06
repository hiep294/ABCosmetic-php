<?php

class DBConnection {

    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $port;
    public $salt1;
    public $salt2;
    public $conn;

//echo "1234";
    public function DBConnection() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->dbname = "ABCosmetic";
        $this->port = 8889;
        $this->salt1 = "xs&s*";
        $this->salt2 = "!&^@";
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
        if ($this->conn->error) {
            die($this->conn->error);
        }
    }

//function to run query
    public function runQueryMySql($queryString) {
//add global variable

        $result2 = $this->conn->query($queryString);
        if (!$result2) {
            die($this->conn->error); //can show what error is
        }
        return $result2; //return result
    }

//return string to the truth value
    public function truthString($str) {
        $str = strip_tags($str); //remove html tags, for example: &lt;b&gt;ABC&lt;b&gt; => ABC
        $str = htmlentities($str); //encode html (for special character), example return the true value of <a href=">
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str); // remove magic quotes like : \
        }
//next step
//    global $conn;
        $str = $this->conn->real_escape_string($str);
        return $str;
    }

    /* FUNCTION:delete session when user logout */

    /* FUNCTION: encrypt password */

    public function passwordToToken($passString) {
//declare variables:
        $salt1 = $this->salt1;
        $salt2 = $this->salt2;
        $token = hash('ripemd128', "$salt1$passString$salt2"); //ripemd128 is an algorithm
        return $token;
    }

    /* cookie */

    public function setCookie($name, $value) {
        setcookie($name, $value, time() + 60 * 60 * 24, "/");
    }

    public function unsetCookie($name) {
        setcookie($name, '', time() - 60 * 60 * 24 * 2, "/");
    }

    /* get cookie without reload, may be ONLY one time */

    public function getcookie($name) {
        $cookies = [];
        $headers = headers_list();
// see http://tools.ietf.org/html/rfc6265#section-4.1.1
        foreach ($headers as $header) {
            if (strpos($header, 'Set-Cookie: ') === 0) {
                $value = str_replace('&', urlencode('&'), substr($header, 12));
                parse_str(current(explode(';', $value, 1)), $pair);
                $cookies = array_merge_recursive($cookies, $pair);
            }
        }
        return $cookies[$name];
    }

//source:https://stackoverflow.com/questions/3230133/accessing-cookie-immediately-after-setcookie
    public function predictTheNextIdQuery($nameOfTable) {
        $sqlStatement = "SELECT `AUTO_INCREMENT` as 'NextId'
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'ABCosmetic'
AND   TABLE_NAME   = '$nameOfTable';";
        return $sqlStatement;
    }

    public function addObjectQuery($nameOfTable, $columns, $values) {
        $sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        return $sqlStatement;
    }

    public function updateObjectQuery($nameOfTable, $changedInfo, $conditions) {
        $sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        return $sqlStatement;
    }

    public function deleteObjectQuery($nameOfTable, $deletedInfo) {
        if ($deletedInfo == "") {
            $sqlStatement = "DELETE FROM $nameOfTable";
        } else {
            $sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";
        }
        return $sqlStatement;
    }

    //$query = "select * from tblproduct";
    public function selectObjectQuery($nameOfTable, $conditions) {
        if ($conditions == "") {
            $sqlStatement = "SELECT * FROM $nameOfTable";
        } else {
            $sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        }
        return $sqlStatement;
    }

    public function joinTablesQuery($columns, $table1, $table2, $on, $conditions) {
        if ($conditions == "") {
            $sqlStatement = "SELECT $columns FROM $table1 as a INNER JOIN $table2 as b ON $on";
        } else {
            $sqlStatement = "SELECT $columns FROM $table1 as a INNER JOIN $table2 as b ON $on WHERE $conditions";
        }
        return $sqlStatement;
    }

    public function joinThreeTableQuery($columns, $table1, $table2, $table3, $conditions) {
        $sqlStatement = "select $columns from $table1 as a, $table2 as b, $table3 as c where $conditions ";
        return $sqlStatement;
    }

    public function specialQUERY1($StoreId) {
        //select product is sold by StoreId
        return $sqlStatement = "select * from tblProduct where ProdId not in
(select ProdId from tblProductDetail where StoreId='$StoreId');";
    }

}
