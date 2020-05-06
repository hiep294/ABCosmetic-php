<?php

require_once("SaleStaffController.php");

class NationalManagerController extends SaleStaffController {

    public $totalQuantity; //may be order quantity or store quantity
    public $totalAmount;

    public function viewOrdersAndOrderDetail($OrderDate1, $OrderDate2, $UserId) {
        $table1 = "tblOrder";
        $table2 = "tblOrderDetail";
        $columns = "a.OrderId, a.CustomerId, a.DateOfOrder, a.TotalAmount, a.UserId, b.ProductDetailId, b.OrderQuantity";
        $on = "a.OrderId = b.OrderId";
//        WHERE OrderDate BETWEEN '1996-07-01' AND '1996-07-31';

        if ($UserId == "") {
            $conditions = "a.DateOfOrder BETWEEN '$OrderDate1' AND '$OrderDate2'";
        } else {
            $conditions = "a.UserId='$UserId' AND a.DateOfOrder BETWEEN '$OrderDate1' AND '$OrderDate2'";
        }

        if ($OrderDate1 == "") {//in the beginning, just check the OrderDate1
            $conditions = "";
        }
        //$sqlStatement = "SELECT $columns FROM $table1 as a INNER JOIN $table2 as b ON $on WHERE $conditions";
        $queryString = $this->DBConnection->joinTablesQuery($columns, $table1, $table2, $on, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewOrdersAndOrderDetailByStore($OrderDate1, $OrderDate2, $StoreId) {
        $table1 = "tblOrder";
        $table2 = "tblOrderDetail";
        $table3 = "tblStaff";
        $columns = "a.OrderId, a.CustomerId, a.DateOfOrder, a.TotalAmount, a.UserId, c.StoreId, b.ProductDetailId, b.OrderQuantity";
        $condition1 = "a.OrderId = b.OrderId AND a.UserId = c.UserId";
//        WHERE OrderDate BETWEEN '1996-07-01' AND '1996-07-31';

        if ($StoreId == "") {
            $conditions = $condition1 . " AND " . "a.DateOfOrder BETWEEN '$OrderDate1' AND '$OrderDate2'";
        } else {
            $conditions = $condition1 . " AND " . "c.StoreId='$StoreId' AND a.DateOfOrder BETWEEN '$OrderDate1' AND '$OrderDate2'";
        }

        if ($OrderDate1 == "") {//in the beginning, just check the OrderDate1
            $conditions = $condition1;
        }
        // $sqlStatement = "select $columns from $table1 a, $table2 b, $table3 c where $conditions ";
        $queryString = $this->DBConnection->joinThreeTableQuery($columns, $table1, $table2, $table3, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewOrdersAndOrderDetailByProduct($OrderDate1, $OrderDate2, $ProductId) {
        $table1 = "tblOrder";
        $table2 = "tblOrderDetail";
        $table3 = "tblProductDetail";
        $columns = "a.OrderId, a.CustomerId, a.DateOfOrder, a.TotalAmount, a.UserId, c.ProdId, b.ProductDetailId, b.OrderQuantity, c.StoreId";
        $condition1 = "a.OrderId = b.OrderId AND b.ProductDetailId = c.ProductDetailId";
//        WHERE OrderDate BETWEEN '1996-07-01' AND '1996-07-31';

        if ($ProductId == "") {
            $conditions = $condition1 . " AND " . "a.DateOfOrder BETWEEN '$OrderDate1' AND '$OrderDate2'";
        } else {
            $conditions = $condition1 . " AND " . "c.ProdId='$ProductId' AND a.DateOfOrder BETWEEN '$OrderDate1' AND '$OrderDate2'";
        }

        if ($OrderDate1 == "") {//in the beginning, just check the OrderDate1
            $conditions = $condition1;
        }
        // $sqlStatement = "select $columns from $table1 a, $table2 b, $table3 c where $conditions ";
        $queryString = $this->DBConnection->joinThreeTableQuery($columns, $table1, $table2, $table3, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function setRecordedQuantityAndTotalAmount($ordersOrderDetails) {
        $this->totalQuantity = 0;
        $this->totalAmount = 0;
        $OrderIdNow = null;
        //like arrange columns in the report.
        while ($row = mysqli_fetch_assoc($ordersOrderDetails)) {
            $OrderIdBefore = $OrderIdNow;
            if ($OrderIdBefore != $row['OrderId']) {
                $this->totalAmount = $this->totalAmount + $row["TotalAmount"];
            }
            $this->totalQuantity = $this->totalQuantity + $row["OrderQuantity"];

            $OrderIdNow = $row['OrderId'];
        }
    }

    public function setRecordedTotalSpendingForProducts($ordersOrderDetailsByProduct) {
        $this->totalAmount = 0;
        //like arrange columns in the report.
        while ($row = mysqli_fetch_assoc($ordersOrderDetailsByProduct)) {
            $price = $this->findPriceOfProduct($row["ProductDetailId"]);
            $this->totalAmount = $this->totalAmount + ($price*$row["OrderQuantity"]);
        }
    }

    public function setQuantity($productDetails) {
        $this->totalQuantity = 0;
        //like arrange columns in the report.
        while ($row = mysqli_fetch_assoc($productDetails)) {
            $this->totalQuantity = $this->totalQuantity + $row["StoreQuantity"];
        }
    }

    public function getTotalAmount2() {
        return $this->totalAmount;
    }

    public function getTotalQuantity2() {
        return $this->totalQuantity;
    }

    public function viewAllStaffs($userId) {
        $nameOfTable = "tblStaff";
        $conditions = "";
        if ($userId != "") {
            $conditions = "UserId='$userId'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewAllSaleSaff($theRole) {
        $nameOfTable = "tblStaff";
        $conditions = "";
        if ($theRole != "") {
            $conditions = "UserRole='$theRole'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewAllStores($id) {
        $nameOfTable = "tblStore";
        $conditions = "";
        if ($id != "") {
            $conditions = "StoreId='$id'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewAllProductDetailsCond($cond) {
        $nameOfTable = "tblProductDetail";
        $conditions = "";
        if ($cond != "") {
            $conditions = "$cond";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

    public function viewAProductDetail($id) {
        $nameOfTable = "tblProductDetail";
        $conditions = "";
        if ($id != "") {
            $conditions = "ProductDetailId='$id'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }

}
