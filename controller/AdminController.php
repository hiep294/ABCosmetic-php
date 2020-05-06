<?php

require_once("NationalManagerController.php");

class AdminController extends NationalManagerController {
    public function AdminController() {
        $this->DBConnection = new DBConnection();
    }
    /* CATEGORY CONTROLLER */
    public function viewAllCategories($categoryId) {
        $nameOfTable = "tblCategory";
        $conditions = "";
        if ($categoryId != "") {
            $conditions = "CategoryId=$categoryId";
        }
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }// get all categories or a category
    public function addCategory($CategoryName, $Desciption) {
        $nameOfTable = "tblCategory";
        $columns = "CategoryName, Description";
        $values = "'$CategoryName','$Desciption'";
        //find the query
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }// add a new category
    public function updateCategory($CategoryId, $CategoryName, $Description) {
        $nameOfTable = "tblCategory";
        $changedInfo = "CategoryName='$CategoryName',Description='$Description'";
        $conditions = "CategoryId = '$CategoryId'";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//update a category
    public function deleteCategory($CategoryId) {
        $nameOfTable = "tblCategory";
        $deletedInfo = "CategoryId=$CategoryId";
        //find the query
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }//delete a category
    /* PRODUCT CONTROLLER */
    public function addProduct($ProductName, $CategoryId, $Price, $Description, $Image) {
        $nameOfTable = "tblProduct";
        $columns = "ProdName,CategoryId,Price,Description,Image";
        $values = "'$ProductName','$CategoryId','$Price','$Description','$Image'";
        //create the query: $sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }// add a new product
    public function deleteProduct($prodId) {
        $nameOfTable = "tblProduct";
        $deletedInfo = "ProdId='$prodId'";
        //create the query: $sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
    }//delete a product
    public function updateProduct($ProdId, $ProdName, $CategoryId, $Price, $Desciption, $Image) {
        $nameOfTable = "tblProduct";
        $changedInfo = "ProdName='$ProdName',CategoryId='$CategoryId',Price='$Price',Description='$Desciption',Image='$Image'";
        $conditions = "ProdId = '$ProdId'";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//update a product
    /* STORE CONTROLLER */
    public function addStore($StoreAddress, $StorePhone) {
        $nameOfTable = "tblStore";
        $columns = "StoreAddress,StorePhone";
        $values = "'$StoreAddress','$StorePhone'";
        //$sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        //queryString
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        //run query
        $result = $this->DBConnection->runQueryMySql($queryString);
        //return result
        return $result;
        //return curentId;
    }//add a new store
    public function updateStore($id, $address, $phone) {
        $nameOfTable = "tblStore";
        $changedInfo = "StoreAddress='$address', StorePhone= '$phone'";
        $conditions = "StoreId='$id'";
        // $sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//update a store
    public function deleteStore($id) {
        $nameOfTable = "tblStore";
        $deletedInfo = "StoreId='$id'";
        //$sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//delete a store
    /* PRODUCTDETAIL CONTROLLER */
    public function viewAllProductDetailsOfStore($id) {
        $nameOfTable = "tblProductDetail";
        $conditions = "";
        if ($id != "") {
            $conditions = "StoreId='$id'";
        }
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//get all Product details of a store
    public function addProductDetail($prodId, $storeId, $storeQuantity) {
        $nameOfTable = "tblProductDetail";
        $columns = "ProdId,StoreId,StoreQuantity";
        $values = "'$prodId','$storeId','$storeQuantity'";
        //$sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//add a new product detail
    public function updateProductDetail($productdetailId, $prodId, $storeId, $storeQuantity) {
        $nameOfTable = "tblProductDetail";
        $changedInfo = "ProdId='$prodId',StoreId='$storeId',StoreQuantity='$storeQuantity'";
        $conditions = "ProductDetailId='$productdetailId'";
        //$sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//update a product detail
    public function deleteProductDetail($id) {
        $nameOfTable = "tblProductDetail";
        $deletedInfo = "ProductDetailId='$id'";
        //$sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//delete a product detail
    public function viewAllProductsWhichHaveNotAssignedByAStore($StoreId){
        //select product is sold by StoreId
        $queryString = $this->DBConnection->specialQUERY1($StoreId);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//get all products which have not been sold by a store
    /** ===== STAFF CONTROLLER ===== * */
    public function addStaff($UserName, $UserPhone, $UserEmail, $StoreId, $Password, $UserRole) {
        $nameOfTable = "tblStaff";
        $columns = "UserName,UserPhone,UserEmail,StoreId,Password,UserRole";
        $values = "'$UserName','$UserPhone','$UserEmail','$StoreId','$Password','$UserRole'";
        //$sqlStatement = "INSERT INTO $nameOfTable($columns) values($values)";
        $queryString = $this->DBConnection->addObjectQuery($nameOfTable, $columns, $values);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }// add a new staff
    public function updateStaff($UserId, $UserName, $UserPhone, $UserEmail, $StoreId, $UserRole) {
        $nameOfTable = "tblStaff";
        $changedInfo = "UserName='$UserName',UserPhone='$UserPhone',UserEmail='$UserEmail',StoreId='$StoreId',UserRole='$UserRole'";
        $conditions = "UserId='$UserId'";
        //$sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }// update a staff
    public function deleteStaff($UserId) {
        $nameOfTable = "tblStaff";
        $deletedInfo = "UserId='$UserId'";
        //$sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }// delete a staff
    public function getStoreQuantity($ProductDetailId) {
        $nameOfTable = "tblProductDetail";
        $conditions = "ProductDetailId='$ProductDetailId'";
        //$sqlStatement = "SELECT * FROM $nameOfTable WHERE $conditions";
        $queryString = $this->DBConnection->selectObjectQuery($nameOfTable, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        while ($row = mysqli_fetch_assoc($result)) {
            $StoreQuantity = $row['StoreQuantity'];
        }
        return $StoreQuantity;
    }//get store quantity in table tblProductDetail
    public function deleteOrderDetail($OrderId,$ProductDetailId) {
        $nameOfTable = "tblOrderDetail";
        $deletedInfo = "ProductDetailId='$ProductDetailId' AND OrderId='$OrderId'";
        //$sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//delete an order detail
    public function deleteOrderDetailManager($deletedOrderId, $deletedProductDetailId) {
        //$TotalAmount://update Total Amount
        $deletedOrderQuantity = $this->getOrderQuantity($deletedOrderId, $deletedProductDetailId);
        $price = $this->findPriceOfProduct($deletedProductDetailId);
        $TotalAmount = $this->getTotalAmount($deletedOrderId);
        $TotalAmount = $TotalAmount - ($deletedOrderQuantity * $price);
        
        $this->updateTotalAmount($deletedOrderId, $TotalAmount);
        //modify  store quantity:
        $StoreQuantity = $this->getStoreQuantity($deletedProductDetailId);
        $StoreQuantity = $StoreQuantity + $deletedOrderQuantity;
        $this->updateStoreQuantity($deletedProductDetailId, $StoreQuantity);
        //delete order details
        $this->deleteOrderDetail($deletedOrderId, $deletedProductDetailId);
    }// do sth in need, before deleting an order detail
    public function deleteOrder($OrderId){
        $nameOfTable = "tblOrder";
        $deletedInfo = "OrderId='$OrderId'";
        ////$sqlStatement = "DELETE FROM $nameOfTable WHERE $deletedInfo";        
        $queryString = $this->DBConnection->deleteObjectQuery($nameOfTable, $deletedInfo);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//delete an order
    public function updateOrder($OrderId,$CustomerId,$OrderDate){
        $nameOfTable="tblOrder";
        $conditions="OrderId='$OrderId'";
        $changedInfo="CustomerId='$CustomerId',DateOfOrder='$OrderDate'";
        //$sqlStatement = "UPDATE $nameOfTable SET $changedInfo WHERE $conditions";
        $queryString = $this->DBConnection->updateObjectQuery($nameOfTable, $changedInfo, $conditions);
        $result = $this->DBConnection->runQueryMySql($queryString);
        return $result;
    }//update an order
    /*input is orderId, find the recorder, find the store, output all product details of this store:*/
    public function findProductDetailsOfTheStoreFromOrderIdManagement($OrderId){
        //find the UserId: get order row, get the UserId
        $theOrderRow=$this->viewOrders($OrderId, "isOrderId");
        while ($row1 = mysqli_fetch_assoc($theOrderRow)) {
            $UserId = $row1['UserId'];
        }
        
        //find the store: get UserId row, get storeId
        $theUserRow = $this->viewAllStaffs($UserId);
        while ($row2 = mysqli_fetch_assoc($theUserRow)) {
            $StoreId = $row2['StoreId'];
        }
        //find product details of the store:
        $ProductDetailsOfTheStore = $this->tblProductDetail_tblProduct($StoreId);
        return $ProductDetailsOfTheStore;
    }
}
