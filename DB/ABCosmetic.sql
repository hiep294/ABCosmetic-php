--DDL
create table tblCategory(
    CategoryId int primary key AUTO_INCREMENT,
    CategoryName varchar(50) unique,
    Description varchar(500) not null
);
ALTER TABLE tblCategory AUTO_INCREMENT=100;

create table tblProduct(
    ProdId int primary key AUTO_INCREMENT,
    ProdName varchar(100) unique,
    CategoryId int not null,
    Price float default 0,
    Description varchar(500) not null,
    Image varchar(50) not null,
    CONSTRAINT fk_tblProduct_tblCategory FOREIGN KEY (CategoryId) REFERENCES tblCategory(CategoryId) on update cascade
);
ALTER TABLE tblProduct AUTO_INCREMENT=1000;


create table tblStore(
    StoreId int primary key AUTO_INCREMENT,
    StoreAddress varchar(100) not null,
    StorePhone varchar(12) unique
);
ALTER TABLE tblStore AUTO_INCREMENT=1;

create table tblStaff(
    UserId int primary key AUTO_INCREMENT,
    UserName varchar(20) not null,
    UserPhone varchar(12) not null,
    UserEmail varchar(100) unique,
    StoreId int not null,
    Password varchar(100) not null,
    UserRole int default 2, 
    CONSTRAINT fk_tblStaff_tblStore FOREIGN KEY (StoreId) REFERENCES tblStore(StoreId) on update cascade
);
ALTER TABLE tblStaff AUTO_INCREMENT=1234500;

create table tblProductDetail(
    ProductDetailId int primary key AUTO_INCREMENT,
    ProdId int not null,
    StoreId int not null,
    StoreQuantity int not null,
    CONSTRAINT unique_tblProductDetail UNIQUE (ProdId,StoreId),
    CONSTRAINT fk_tblProductDetail_tblProduct FOREIGN KEY(ProdId) REFERENCES tblProduct(ProdId) on update cascade,
    CONSTRAINT fk_tblProductDetail_tblStore FOREIGN KEY(StoreId) REFERENCES tblStore(StoreId) on update cascade
);
ALTER TABLE tblProductDetail AUTO_INCREMENT=1111;

create table tblCustomer(
    CustomerId int primary key AUTO_INCREMENT,
    CustomerName varchar(20) not null,
    CustomerPhone varchar(12) not null,
    CustomerEmail varchar(50) unique not null
);
alter table tblCustomer AUTO_INCREMENT=500000;

create table tblOrder(
    OrderId int primary key AUTO_INCREMENT,
    CustomerId int not null,
    DateOfOrder date not null,
    TotalAmount float default 0,
    UserId int not null,
    CONSTRAINT fk_tblOrder_tblCustomer FOREIGN KEY (CustomerId) REFERENCES tblCustomer(CustomerId) on update cascade, 
    CONSTRAINT fk_tblOrder_tblStaff FOREIGN KEY (UserId) REFERENCES tblStaff(UserId) on update cascade
);
alter table tblOrder AUTO_INCREMENT=77654300;

create table tblOrderDetail(
    OrderId int not null,
    ProductDetailId int not null,
    OrderQuantity int not null,    
    CONSTRAINT fk_tblOrderDetail_tblOrder FOREIGN KEY (OrderId) REFERENCES tblOrder(OrderId) on update cascade, 
    CONSTRAINT fk_tblOrderDetail_tblProductDetail FOREIGN KEY (ProductDetailId) REFERENCES tblProductDetail(ProductDetailId) on update cascade    
);
alter table tblOrderDetail ADD CONSTRAINT pk_tblOrderDetail PRIMARY KEY (OrderId,ProductDetailId);

--///////////
--DML


insert into tblCategory(CategoryName,Description) 
values
('Skin Care','This is Skin Care category. This website is a studying version, it is not used for commerce'),
('Make-up & Nails','This is Make-up & Nails category. This website is a studying version, it is not used for commerce'),
('Hair Care & Styling','This is Hair Care & Styling category. This website is a studying version, it is not used for commerce');

insert into tblProduct(ProdName,CategoryId,Price,Description,Image) 
values
('Perfect Radiance Day Creme',100,236,'This is Lakme Perfect Radiance Fairness Day Creme, 50g. This website is a studying version, it is not used for commerce.','1.1.jpg'),
('Naturale Aloe Aquagel',100,179,'This is Lakme 9 to 5 Naturale Aloe Aquagel, 50g. This website is a studying version, it is not used for commerce.','1.2.jpg'),
('Peach Milk Sunscreen Lotion',100,133,'This is Lakme Peach Milk Moisturizer SPF 24 PA Sunscreen Lotion, 120ml. This website is a studying version, it is not used for commerce.','1.3.jpg'),
('Skin Lightening Light Creme',100,218,'This is Lakme Absolute Perfect Radiance Skin Lightening Light Creme, 50g. This website is a studying version, it is not used for commerce.','1.4.jpg'),
('Eyeconic Kajal, Deep Black',101,135,'This is Lakme Eyeconic Kajal, Deep Black, 0.35g. This website is a studying version, it is not used for commerce.','2.1.jpg'),
('Complexion Care Face Cream, Beige',101,236,'Lakme 9 to 5 Complexion Care Face Cream, Beige, 30g. This website is a studying version, it is not used for commerce.','2.2.jpg'),
('Sun Matte SPF 40 PA+++ Compact',101,166,'This is Lakme Sun Expert Ultra Matte SPF 40 PA+++ Compact, 7g. This website is a studying version, it is not used for commerce.','2.3.jpg'),
('Lash Curling Mascara, Black',101,281,'This is Lakme Eyeconic Lash Curling Mascara, Black, 9ml. This website is a studying version, it is not used for commerce.','2.4.jpg'),
('K Wave Waving System',102,2299.96,'This is Lakme K Wave Waving System, 0. This website is a studying version, it is not used for commerce.','3.1.jpg'),
('K.Therapy Shampoo 300ml',102,5438,'This is Lakme K.Therapy Sensitive Relaxing Shampoo 300ml / 10.2oz. This website is a studying version, it is not used for commerce.','3.2.jpg'),
('Collage Hydrox Peroxide Creme',102,1693.9,'This is Lakme Collage Hydrox Stabilized Peroxide Creme, 33.9 Ounce. This website is a studying version, it is not used for commerce.','3.3.jpg'),
('K.Therapy Shampoo 33.9 Oz',102,11437,'This is Lakme K.Therapy Active Prevention Shampoo 33.9 Oz 1000 Ml. This website is a studying version, it is not used for commerce.','3.4.jpg')
;

insert into tblStore(StoreAddress,StorePhone) values
('Ha Noi','0987652220'),
('Bac Can','0987652221'),
('Ca Mau','0987652222'),
('Da Nang','0987652223'),
('TP. HCM','0987652224');


-- insert into tblStaff(UserName,UserPhone,UserEmail,StoreId,Password,UserRole) values
-- ('admin','0987653346','admin@gmail.com',5,'admin',1)
-- ('NM1','0987653341','nm1@gmail.com',1,'1234',2),

--('S.Sara','0987653330','ssara@gmail.com',1,'qwer',3),

-- ('NM2','0987653342','nm2@gmail.com',2,'1234',2),
-- ('NM3','0987653343','nm3@gmail.com',3,'1234',2),
-- ('NM4','0987653344','nm4@gmail.com',4,'1234',2),
-- ('NM5','0987653345','nm5@gmail.com',5,'1234',2);
-- 
-- insert into tblStaff(UserName,UserPhone,UserEmail,StoreId,Password) values
-- 
-- ('S.Sahe','0987653331','ssahe@gmail.com',1,'qwer'),
-- ('S.Aara','0987653332','saara@gmail.com',2,'qwer'),
-- ('S.Aaha','0987653334','saaha@gmail.com',2,'qwer'),
-- ('S.Bara','0987653335','sbara@gmail.com',3,'qwer'),
-- ('S.Baka','0987653336','sbaka@gmail.com',3,'qwer'),
-- ('S.Caka','0987653337','scaka@gmail.com',4,'qwer'),
-- ('S.Cala','0987653338','scala@gmail.com',4,'qwer'),
-- ('S.Dala','0987653339','sdala@gmail.com',5,'qwer'),
-- ('S.Data','0987653340','sdata@gmail.com',5,'qwer');

insert into tblProductDetail(ProdId,StoreId,StoreQuantity) values
(1000,1,50),
(1000,2,60),
(1000,3,70),
(1001,2,80),
(1001,4,90),
(1001,5,40),
(1002,3,30),
(1003,4,20),
(1004,5,10),
(1005,1,20),
(1006,2,30),
(1007,3,40),
(1008,4,50),
(1009,5,60),
(1010,1,70),
(1011,2,80);

insert into tblCustomer(CustomerName, CustomerPhone, CustomerEmail) values
('Hiep','0962675310','1hiep@gmail.com'),
('Xuan','0962675311','xuan@gmail.com'),
('Ha','0962675312','ha@gmail.com'),
('Thu','0962675313','thu@gmail.com'),
('Dong','0962675314','dong@gmail.com');