-- Fig 1. Log in
-- Check if manager with correct credentials:
SELECT COUNT(*) FROM MANAGER WHERE username = ? AND password = ?
-- Check if customer with correct credentials:
SELECT COUNT(*) FROM CUSTOMER WHERE username = ? AND password = ?

-- Fig 2. New User Registration
-- Check if manager password is correct
SELECT COUNT(*) FROM SYSTEMINFO WHERE managerPassword = ?
-- Create a regular user
INSERT INTO CUSTOMER VALUES (?, ?, ?)
-- Or create a manager
INSERT INTO MANAGER VALUES (?, ?, ?)

-- Fig 3. Now Playing
SELECT title FROM MOVIE NATURAL JOIN PLAYS_AT WHERE playing = 1

-- Fig 4. Movie
SELECT MOVIE.title, releaseDate, MOVIE.rating, length, genre, COUNT(REVIEW.reviewID) AS reviews, AVG(REVIEW.rating) AS avgScore FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?

-- Fig 6. Overview
SELECT synopsis, cast FROM MOVIE WHERE MOVIE.title = ?
