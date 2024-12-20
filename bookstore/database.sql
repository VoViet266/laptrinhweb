CREATE DATABASE BookStore;
USE BookStore;

CREATE TABLE Book (
    BookID VARCHAR(50) NOT NULL PRIMARY KEY,
    BookTitle VARCHAR(200),
    Price DECIMAL(12,0),
    Author VARCHAR(128),
    Type VARCHAR(128),
    Image VARCHAR(128)
);

CREATE TABLE Users (
    UserID INT NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(128),
    Password VARCHAR(255),
    role VARCHAR(10) DEFAULT 'customer',
    PRIMARY KEY (UserID)
);

CREATE TABLE Customer (
    CustomerID INT NOT NULL AUTO_INCREMENT,
    CustomerName VARCHAR(128),
    CustomerPhone VARCHAR(12),
    CustomerEmail VARCHAR(200),
    CustomerAddress VARCHAR(200),
    CustomerGender VARCHAR(10),
    UserID INT,
    PRIMARY KEY (CustomerID),
    CONSTRAINT FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Orders (
    OrderID INT NOT NULL AUTO_INCREMENT,
    CustomerID INT,
    BookID VARCHAR(50),
    DatePurchase DATETIME,
    Quantity INT,
    TotalPrice DECIMAL(12,0),
    Status VARCHAR(1),
    PRIMARY KEY (OrderID),
    CONSTRAINT FOREIGN KEY (BookID) REFERENCES Book(BookID) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Cart (
    CartID INT NOT NULL AUTO_INCREMENT,
    CustomerID INT,
    BookID VARCHAR(50),
    Price DECIMAL(12,0),
    Quantity INT,
    TotalPrice DECIMAL(12,0),
    PRIMARY KEY (CartID),
    CONSTRAINT FOREIGN KEY (BookID) REFERENCES Book(BookID) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO Book (BookID, BookTitle, Price, Author, Type, Image)
VALUES 
('B-001', 'Những người khốn khổ', 200000, 'Victor Hugo', 'Văn học', 'vanhoc1.jpg'),
('B-002', 'Dế Mèn phiêu lưu ký', 50000, 'Tô Hoài', 'Thiếu nhi', 'thieunhi1.jpg'),
('B-003', 'Tuổi trẻ đáng giá bao nhiêu', 90000, 'Rosie Nguyễn', 'Kỹ năng sống', 'kynang1.jpg'),
('B-004', 'Đắc nhân tâm', 120000, 'Dale Carnegie', 'Phát triển bản thân', 'phattrienbanthan.jpg'),
('B-005', 'Nhà giả kim', 130000, 'Paulo Coelho', 'Văn học', 'vanhoc2.jpg');
