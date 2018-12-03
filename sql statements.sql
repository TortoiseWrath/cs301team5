-- Fig 1. Log in
-- Check if manager with correct credentials:
SELECT COUNT(*) FROM MANAGER WHERE username = ? AND password = ?
-- Check if customer with correct credentials:
SELECT COUNT(*) FROM CUSTOMER WHERE username = ? AND password = ?

-- Fig 2. New User Registration
-- Check if manager password is correct
SELECT COUNT(*) FROM SYSTEMINFO WHERE managerPassword = ?
-- Create a regular user
INSERT INTO CUSTOMER (email, username, password) VALUES (?, ?, ?)
-- Or create a manager
INSERT INTO MANAGER (email, username, password) VALUES (?, ?, ?)
-- Make sure there is no existing user with same email or username
-- Database constraints are insufficient for this since they do not prevent a user
-- from being inserted into the manager or customer table with same email
-- or username as a user in the other table
SELECT username, email FROM (SELECT * FROM CUSTOMER UNION SELECT * FROM MANAGER) AS USERS WHERE username = ? OR email = ?

-- Fig 3. Now Playing
SELECT title FROM MOVIE NATURAL JOIN PLAYS_AT WHERE playing = 1

-- Fig 4. Me
--Order History
SELECT * FROM ORDERS WHERE username = ?
--Payment Info
SELECT * FROM PAYMENT_INFO WHERE username = ? AND saved = 1
--Preferred Theater
SELECT  THEATER.theaterID FROM THEATER NATURAL JOIN PREFERS WHERE username = ?

-- Fig 5. Movie
SELECT MOVIE.title, releaseDate, MOVIE.rating, length, genre, COUNT(REVIEW.reviewID) AS reviews, AVG(REVIEW.rating) AS avgScore FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?

-- Fig 6. Overview
SELECT synopsis, cast FROM MOVIE WHERE MOVIE.title = ?

-- Fig 7. Review
SELECT rating, comment, AVG(REVIEW.rating) FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?

-- Fig 8. Give Review
-- Ensure the user has seen the movie before
SELECT COUNT(*) FROM ORDERS WHERE username = ? AND title = ?
--the following statement should be used to insert the reviewID
SELECT reviewID FROM REVIEWS ORDER BY reviewID DESC LIMIT 1
--reviewID = the above + 1
INSERT INTO REVIEW VALUES (?,?,?,?,?)

-- Fig 9. Choose Theater
-- Get saved theaters that are showing the movie.
SELECT theaterID, name FROM THEATER NATURAL JOIN PREFERS NATURAL JOIN PLAYS_AT WHERE username = ? AND playing = 1 AND title = ?

-- Fig 10. Search Theater Results
SELECT theaterID, name, state, city, street, zip FROM THEATER NATURAL JOIN PLAYS_AT WHERE (lower(state) LIKE ? OR lower(city) LIKE ? OR lower(name) LIKE ?) AND playing = 1 AND title = ?

-- Fig 11. Select Time
-- To get the movie info:
SELECT rating, length, genre FROM MOVIE WHERE title = ?
-- To get the showtimes:
SELECT showtime FROM SHOWTIME where theaterID = ? AND title = ? AND showtime BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)
-- To save a theater to the preferred theaters (which happens when submitting to this page from the search results):
INSERT INTO PREFERS VALUES (?, ?)

-- Fig 12. Ticket
-- To get the movie info:
SELECT rating, length, genre FROM MOVIE WHERE title = ?
-- To get the theater info:
SELECT name, state, city, street, zip FROM THEATER WHERE theaterID = ?
-- To get the discount percentages:
SELECT childDiscount, seniorDiscount FROM SYSTEMINFO
-- To get the base ticket cost:
SELECT ticketPrice FROM SHOWTIME WHERE showtime = ? AND theaterID = ? AND title = ?

-- Fig 13. Payment Information
-- To get the movie info:
SELECT rating, length, genre FROM MOVIE WHERE title = ?
-- To get the theater info:
SELECT name, state, city, street, zip FROM THEATER WHERE theaterID = ?
-- To get the saved cards:
SELECT cardNumber FROM PAYMENT_INFO WHERE username = ? AND expirationDate >= CURDATE() AND saved = 1

-- Fig 14. Confirmation
INSERT INTO ORDERS VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
-- To get an available order id:
SELECT orderID FROM ORDERS ORDER BY orderID DESC LIMIT 1
-- To get the movie info:
SELECT rating, length, genre FROM MOVIE WHERE title = ?
-- To get the theater info:
SELECT name, state, city, street, zip FROM THEATER WHERE theaterID = ?

-- Fig 15. Order History
SELECT orderID, title, status, adultTickets, childTickets, seniorTickets, ticketPrice FROM ORDERS WHERE username=?
-- Or with an order ID to search:
SELECT orderID, title, status, adultTickets, childTickets, seniorTickets, ticketPrice FROM ORDERS WHERE username=? AND orderID=?
-- To get the discount percentages and cancellation fee:
SELECT childDiscount, seniorDiscount, cancellationFee FROM SYSTEMINFO

-- Fig 16. Order Detail/Cancel Order
SELECT * FROM ORDERS JOIN THEATER JOIN MOVIE WHERE orderID=?
-- To get the discount percentages and cancellation fee:
SELECT childDiscount, seniorDiscount, cancellationFee FROM SYSTEMINFO

-- Fig 17. My Payment Information
SELECT cardnumber, nameOnCard, expirationDate FROM PAYMENT_INFO WHERE username = ?

-- Fig 18. My Preferred Theater

-- Fig 19. Choose Functionality

-- Fig 20. View Revenue Report

-- Fig 21. View Popular Movie Report
