-- Fig 1. Log in
-- Check if manager with correct credentials:
SELECT COUNT(*) FROM MANAGER WHERE username = ? AND password = ?
-- Check if customer with correct credentials:
SELECT COUNT(*) FROM CUSTOMER WHERE username = ? AND password = ?

-- Fig 2. Now Playing
SELECT title FROM MOVIE NATURAL JOIN PLAYS_AT WHERE playing = 1

-- Fig 3. Movie
SELECT MOVIE.title, releaseDate, MOVIE.rating, length, genre, COUNT(REVIEW.reviewID) AS reviews, AVG(REVIEW.rating) AS avgScore FROM MOVIE LEFT JOIN REVIEW ON MOVIE.title = REVIEW.title WHERE MOVIE.title = ?
