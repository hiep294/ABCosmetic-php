<?php

require_once '../model/DBConnection.php';

class VisitorController {

    public $DBConnection;

    public function VisitorController() {
        $this->DBConnection = new DBConnection();
    }

    /**
     * if $id exist, the system will find the product which has ProdId = $id;
     * @param type $id
     * @return type
     */
    public function viewAllProducts($id) {
        $nameOfTable = "tblProduct";
        $conditions = "";
        if ($id!="") {
            $conditions = "ProdId = $id";
        }
        $sqlStatement = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($sqlStatement);
        return $result;
    }


    public function tblProductDetail_tblStore($prodId) {
        $table1= "tblProductDetail";
        $table2= "tblStore";
        $columns= "a.StoreId, b.StoreAddress";
        $on= "a.StoreId = b.StoreId";
        $conditions = "ProdId=$prodId";
        $sqlStatement = $this->DBConnection->joinTablesQuery($columns, $table1, $table2, $on, $conditions);
        $result = $this->DBConnection->runQueryMySql($sqlStatement);
        return $result;
    }
    
    
}
