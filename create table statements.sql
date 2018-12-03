CREATE TABLE MANAGER
(
    email VARCHAR(256) UNIQUE,
    username VARCHAR(256) PRIMARY KEY,
    password VARCHAR(256)
);

CREATE TABLE CUSTOMER
(
    email VARCHAR(256) UNIQUE,
    username VARCHAR(256) PRIMARY KEY,
    password VARCHAR(256)
);

CREATE TABLE MOVIE
(
    title VARCHAR(256) PRIMARY KEY,
    cast VARCHAR(5000),
    synopsis VARCHAR(256),
    length INT,
    genre VARCHAR(256),
    rating VARCHAR(5) CHECK (rating IN ("G","PG","PG-13","R","NC-17")),
    releaseDate DATE
);

CREATE TABLE THEATER
(
    theaterID VARCHAR(32) PRIMARY KEY,
    name VARCHAR(256),
    state VARCHAR(2),
    city VARCHAR(32),
    street VARCHAR(256),
    zip VARCHAR(10)
);


CREATE TABLE SYSTEMINFO
(
    cancellationFee INT PRIMARY KEY,
    childDiscount INT,
    seniorDiscount INT,
    managerPassword VARCHAR(256)
);

CREATE TABLE REVIEW (
    reviewID VARCHAR(32) PRIMARY KEY,
    comment VARCHAR(5000),
    title VARCHAR(256), FOREIGN KEY fk_review_title
(title) REFERENCES MOVIE
(title)
        ON
DELETE CASCADE ON
UPDATE CASCADE,
    rating INT
CHECK
(rating BETWEEN 1 AND 5),
    username VARCHAR
(256), FOREIGN KEY fk_review_username
(username) REFERENCES CUSTOMER
(username)
ON
DELETE
SET NULL
ON
UPDATE CASCADE
);

CREATE TABLE PAYMENT_INFO (
    cardNumber VARCHAR(16) PRIMARY KEY,
    expirationDate DATE,
    nameOnCard VARCHAR(256),
    cvv VARCHAR(4),
    saved BOOLEAN,
    username VARCHAR(256), FOREIGN KEY fk_payment_username
(username) REFERENCES
CUSTOMER
(username) ON
DELETE CASCADE ON
UPDATE CASCADE
);

CREATE TABLE ORDERS(
    orderID VARCHAR(32) PRIMARY KEY,
    date DATE,
    time TIME,
    status VARCHAR(9) CHECK (status="Unusued" OR status="Cancelled" OR
        status="Completed"),
    totalTickets INT,
    adultTickets INT,
    childTickets INT,
    seniorTickets INT,
    username VARCHAR(256), FOREIGN KEY fk_order_username
(username) REFERENCES CUSTOMER
(username)
ON
DELETE
SET NULL
ON
UPDATE CASCADE,
    cardNumber VARCHAR(16), FOREIGN KEY fk_order_cardNumber(cardNumber)
REFERENCES PAYMENT_INFO
(cardNumber)
        ON
DELETE
SET NULL
ON
UPDATE CASCADE,
    theaterID VARCHAR(32), FOREIGN KEY fk_order_theater(theaterID)
REFERENCES THEATER
(theaterID)
ON
DELETE
SET NULL
ON
UPDATE CASCADE,
    title VARCHAR(256), FOREIGN KEY fk_order_title(title)
REFERENCES MOVIE
(title)
ON
DELETE
SET NULL
ON
UPDATE CASCADE,
    CONSTRAINT total_tickets CHECK
(totalTickets = adultTickets + childTickets +
seniorTickets)
);

CREATE TABLE PLAYS_AT (
    theaterID VARCHAR(32), FOREIGN KEY fk_plays_at_theater
(theaterID) REFERENCES THEATER
(theaterID)
ON
DELETE CASCADE ON
UPDATE CASCADE,
    title VARCHAR(256), FOREIGN KEY fk_plays_at_title(title)
REFERENCES MOVIE
(title)
ON
DELETE CASCADE ON
UPDATE CASCADE,
    playing BOOLEAN,
    CONSTRAINT playsAtID
PRIMARY KEY
(theaterID, title)
);

CREATE TABLE SHOWTIME (
    showtime DATETIME,
    theaterID VARCHAR(32), FOREIGN KEY fk_showtime_theater
(theaterID) REFERENCES THEATER
(theaterID)
ON
DELETE CASCADE ON
UPDATE CASCADE,
    title VARCHAR(256), FOREIGN KEY fk_showtime_title(title)
REFERENCES MOVIE
(title)
ON
DELETE CASCADE ON
UPDATE CASCADE,
    CONSTRAINT showtimeID PRIMARY KEY
(showtime, theaterID, title)
);


CREATE TABLE PREFERS (
    theaterID VARCHAR(32), FOREIGN KEY fk_prefers_theater
(theaterID) REFERENCES THEATER
(theaterID)
ON
DELETE CASCADE ON
UPDATE CASCADE,
    username VARCHAR(256), FOREIGN KEY fk_prefers_username(username)
REFERENCES CUSTOMER
(username)
ON
DELETE CASCADE ON
UPDATE CASCADE,
CONSTRAINT prefersID PRIMARY KEY
(theaterID, username)
);
