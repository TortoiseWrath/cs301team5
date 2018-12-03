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
--the following statement should be used to insert the reviewID
SELECT COUNT(*) FROM REVIEWS
--reviewID = the above + 1
INSERT INTO REVIEW VALUES (?,?,?,?,?)

-- Fig 9. Choose Theater

-- Fig 10. Search Theater Results

-- Fig 11. Select Time

-- Fig 12. Ticket

-- Fig 13. Payment Information

-- Fig 14. Confirmation

-- Fig 15. Order History

-- Fig 16. Order Detail/Cancel Order

-- Fig 17. My Payment Information
SELECT cardnumber, nameOnCard, expirationDate FROM PAYMENT_INFO WHERE username = ?

-- Fig 18. My Preferred Theater

-- Fig 19. Choose Functionality

-- Fig 20. View Revenue Report

-- Fig 21. View Popular Movie Report
