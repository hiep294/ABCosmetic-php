<?php

require_once("VisitorController.php");

class SaleStaffController extends VisitorController {

    public function SaleStaffController() {
        $this->DBConnection = new DBConnection();
    }

    public function ViewAllCustomers($id) {
        $nameOfTable = "tblCustomer";
        $conditions = "";
        if ($id != "") {
            $conditions = "CustomerId='$id'";
        }
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    /* tblOrder */

    public function addOrder($CustomerId, $DateOfOrder, $TotalAmount, $UserId) {
        $nameOfTable = "tblOrder";
        $columns = "CustomerId, DateOfOrder, TotalAmount, UserId";
        $values = "'$CustomerId', '$DateOfOrder', '$TotalAmount', '$UserId'";
        //$sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        //queryString
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }

    public function addOrderDetail($OrderId, $ProdDetailId, $OrderQuantity) {
        $nameOfTable = "tblOrderDetail";
        $columns = "OrderId,ProductDetailId,OrderQuantity";
        $values = "'$OrderId','$ProdDetailId','$OrderQuantity'";
        //$sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }

    //for update Total Amount one by one when a order detail is added
    public function addOrderDetailManagement($OrderId, $ProdDetailId, $OrderQuantity) {
        //update Store quantity://find StoreQuantity//minus and, update
        $StoreQuantity = $this->findStoreQuantity($ProdDetailId);
        $StoreQuantity = $StoreQuantity - $OrderQuantity;
        $this->updateStoreQuantity($ProdDetailId, $StoreQuantity);
        //update total amount: get total amount:
        $price = $this->findPriceOfProduct($ProdDetailId);
        $TotalAmount = $this->getTotalAmount($OrderId);
        $TotalAmount = $TotalAmount + ($price * $OrderQuantity);
        $this->updateTotalAmount($OrderId, $TotalAmount);
        /* add to product detail */
        //check OrderDetail whether OrderId and ProdDetailId have been exist?
        //if exist, add more order quantity
        $checkOrderDetail= $this->viewTheOrderDetail($OrderId, $ProdDetailId);
        if ($checkOrderDetail->num_rows == 1) {
            $oldOrderQuantity = $this->getOrderQuantity($OrderId, $ProdDetailId);
            $newOrderQuantity = $oldOrderQuantity + $OrderQuantity;
            $this->updateOrderQuantity($OrderId, $ProdDetailId, $newOrderQuantity);
        } else {
            $this->addOrderDetail($OrderId, $ProdDetailId, $OrderQuantity);
        }

        //return result
    }

    public function updateOrderQuantity($OrderId, $ProdDetailId, $newOrderQuantity) {
        $nameOfTable = "tblOrderDetail";
        $changedInfo = "OrderQuantity='$newOrderQuantity'";
        $conditions= "ProductDetailId='$ProdDetailId' AND OrderId='$OrderId'";
        //$sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function getOrderQuantity($OrderId, $ProductDetailId) {
        $nameOfTable = "tblOrderDetail";
        $conditions = "OrderId='$OrderId' AND ProductDetailId='$ProductDetailId'";
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        while ($row = mysqli_fetch_assoc($result)) {
            $OrderQuantity = $row['OrderQuantity'];
        }
        return $OrderQuantity;
    }

    public function getTotalAmount($OrderId) {
        $nameOfTable = "tblOrder";
        $conditions = "OrderId='$OrderId'";
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        while ($row = mysqli_fetch_assoc($result)) {
            $TotalAmount = $row['TotalAmount'];
        }
        return $TotalAmount;
    }

    /**
     * return orders follows userId
     */
    public function viewOrders($UserId, $is) {
        $nameOfTable = "tblOrder";
        $conditions = "";
        if ($UserId != "" && $is == "isUserId") {//for output is a table which follows UserId
            $conditions = "UserId='$UserId'";
        }
        if ($UserId != "" && $is == "isOrderId") {//for output is a table which follows OrderId
            $conditions = "OrderId='$UserId'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    /**
     * return orderdetails follows OrderId
     */
    public function viewOrderDetails($OrderId) {
        $nameOfTable = "tblOrderDetail";
        $conditions = "";
        if ($OrderId != "") {
            $conditions = "OrderId='$OrderId'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewTheOrderDetail($OrderId, $ProductDetailId) {
        $nameOfTable = "tblOrderDetail";
        $conditions = "OrderId='$OrderId' AND ProductDetailId='$ProductDetailId'";
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function predictTheNextId($nameOfTable) {
        $queryString = $this->DBConnection->predictTheNextIdQuery($nameOfTable);
        $result = $this->DBConnection->runQueryMySql($queryString);
        while ($row = mysqli_fetch_assoc($result)) {
            $nextId = $row['NextId'];
        }
        return $nextId;
    }

    /**
     * 
     * @param type $storeId
     * @return: all products which a store is selling6
     */
    public function tblProductDetail_tblProduct($storeId) {
        $table1 = "tblProductDetail";
        $table2 = "tblProduct";
        $columns = "a.ProductDetailId, b.ProdId, b.ProdName, b.Image, b.Price, a.StoreQuantity, a.StoreId";
        $on = "a.ProdId = b.ProdId";
        $conditions = "StoreId=$storeId";
        $sqlStatement = $this->DBConnection->joinTablesQuery($columns, $table1, $table2, $on, $conditions);
        $result = $this->DBConnection->runQueryMySql($sqlStatement);
        return $result;
    }

    /**
     * 
     * @param type $productDetailId
     * @return: the price of product in table tblProductDetail 
     */
    public function findPriceOfProduct($productDetailId) {
        $table1 = "tblProductDetail";
        $table2 = "tblProduct";
        $columns = "a.ProductDetailId, b.ProdId, b.Price";
        $on = "a.ProdId = b.ProdId";
        $conditions = "ProductDetailId=$productDetailId";
        $sqlStatement = $this->DBConnection->joinTablesQuery($columns, $table1, $table2, $on, $conditions);
        $result = $this->DBConnection->runQueryMySql($sqlStatement);
        while ($row = mysqli_fetch_assoc($result)) {
            $price = $row['Price'];
        }
        return $price;
    }

    public function updateTotalAmount($OrderId, $newTotalAmount) {
        $nameOfTable = "tblOrder";
        $changedInfo = "TotalAmount='$newTotalAmount'";
        $conditions = "OrderId = '$OrderId'";
        // $sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function findStoreQuantity($prodDetailId) {
        $nameOfTable = "tblProductDetail";
        $conditions = "ProductDetailId='$prodDetailId'";
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        while ($row = mysqli_fetch_assoc($result)) {
            $StoreQuantity = $row['StoreQuantity'];
        }
        return $StoreQuantity;
    }

    public function updateStoreQuantity($prodDetailId, $newStoreQuantity) {
        $nameOfTable = "tblProductDetail";
        $changedInfo = "StoreQuantity='$newStoreQuantity'";
        $conditions = "ProductDetailId='$prodDetailId'";
        // $sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

}
