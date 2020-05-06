select * from tblProduct where ProdId not in
(select ProdId from tblProductDetail where StoreId=1);