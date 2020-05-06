<?php

require_once '../model/DBConnection.php';

class LoginController {

    public $DBConnection;

    public function LoginController() {
        $this->DBConnection = new DBConnection();
    }

    public function checkLogin($email, $tokenpass) {
        $nameOfTable = "tblStaff";
        $conditions = "UserEmail='$email' AND  Password='$tokenpass'";

        //find the query
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }

    public function checkPassword($id, $oldpassToken) {
        $nameOfTable ="tblStaff";
        $conditions = "UserId='$id' and Password='$oldpassToken'";//rule: ''
        //find the query
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }

    public function changePassword($id, $newpassToken) {
        $nameOfTable ="tblStaff";
        $changedInfo = "Password='$newpassToken'";
        $conditions="UserId='$id'";
        //find the query
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }  
}
