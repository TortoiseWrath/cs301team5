USE cs301;

INSERT INTO CUSTOMER
VALUES
  ("bsmith@gmail.com", "bsmith", "password"),
  ("ejones@gmail.com", "ejones", "12345"),
  ("clear@gmail.com", "clear", "bubblegum"),
  ("computers@gmail.com", "computer", "science"),
  ("user1@gmail.com", "user1", "password1"),
  ("steve@gmail.com", "steve", "pass"),
  ("bob@gmail.com", "bob", "yeet123"),
  ("jimmy@gmail.com", "jimmy", "neutron123"),
  ("timmy@gmail.com", "timmy", "turner123"),
  ("sarah@gmail.com", "sarah", "pass1234"),
  ("elizabeth@gmail.com", "elizabeth", "wow123"),
  ("john@gmail.com", "john", "trees"),
  ("rob@gmail.com", "rob", "stairs"),
  ("robert@gmail.com", "robert", "chairs"),
  ("michael@gmail.com", "michael", "football"),
  ("james@gmail.com", "james", "soccer"),
  ("mary@gmail.com", "mary", "volleyball"),
  ("paul@gmail.com", "paul", "hat"),
  ("kevin@gmail.com", "kevin", "lamp"),
  ("david@gmail.com", "david", "computers");

INSERT INTO MANAGER
VALUES
  ("msmith@gmail.com", "msmith", "password456"),
  ("brian@gmail.com", "brian", "manager"),
  ("timothy@gmail.com", "timothy", "code123"),
  ("frank@gmail.com", "frank", "laptop"),
  ("ryan@gmail.com", "ryan", "music");

INSERT INTO PAYMENT_INFO
VALUES
("8800784593457364",
"2020-10-01",
"Paul Bryant",
335,
1,
"paul"
),
("8800473689234657", "2021-08-01", "Paul Bryant", 245, 1, "paul"),
("7688999934567658", "2019-07-01", "Mary Brown", 546, 1, "mary"),
("8347362536890058", "2020-03-01", "John Smith", 783, 1, "john"),
("0987654323456789", "2020-07-01", "Jimmy Neutron", 789, 1, "jimmy"),
("8467182984301334", "2021-09-01", "Jimmy Neutron", 894, 1, "jimmy"),
("8746893283746190", "2022-04-01", "Bob Light", 938, 0, "bob"),
("4832910482914738", "2019-09-01", "James McDonald", 834, 1, "james"),
("4832701982398432", "2020-05-01", "Bob Light", 348, 1, "bob"),
("8876785654434566", "2021-11-01", "Mary Brown", 677, 1, "mary"),
("1010298329019238", "2020-09-01", "David Forster", 222, 0, "david"),
("3820942390849333", "2022-12-01", "Nick Saban", 069, 1, "user1"),
("4328791083474739", "2019-01-01", "Kevin Christianson", 234, 1, "kevin"),
("6942011843723899", "2020-03-01", "Harry Potter", 420, 0, "clear"),
("2390490234042304", "2021-04-01", "Super Saban", 120, 1, "user1");

INSERT INTO THEATER
VALUES
  ("1", "AMC1", "MO", "Saint Louis", "Watson", "63119"),
  ("2", "Cobb", "AL", "Tuscaloosa", "University", "35401"),
  ("3", "IMAX", "AL", "Tuscaloosa", "Bigstreet", "34599"),
  ("4", "AMC2", "AL", "Tuscaloosa", "Smallstreet", "23940"),
  ("5", "Moolah", "MO", "Saint Louis", "Jonesroad", "93838"),
  ("6", "Olympian", "IL", "Chicago", "Smokehouse", "23848"),
  ("7", "AMC3", "AL", "Tuscaloosa", "Overthere", "39583");

INSERT INTO MOVIE
VALUES
  ("The Grinch", "the grinch, a dog, some girl", "the grinch tries to steal christmas oh no", 200, "action", "G", "2018-12-25"),
  ("Avengers", "spiderman, ironman, thor", "all the super heroes fight evil", 300, "action", "PG-13", "2018-08-12"),
  ("Bohemian Rhapsody", "all of queen", "the queen makes music for the world to enjoy", 150, "romance", "NC-17", "2018-11-25"),
  ("Star Wars", "darth vader, luke skywalker, yoda", "darth vader tries to kill people but luke has better skills", 256, "action", "R", "2018-11-25"),
  ("The Shawshank Redemption", "morgan freeman, some other guy", "good guy tries to escape jail", 200, "action", "R", "2018-11-24"),
  ("Pulp Fiction", "samuel jackson, some coke girl, some coke guy", "people take mad drugs and do weird stuff", "145", "romance", "G", "2018-11-25"),
  ("Inception", "leonardo dicaprio, leonardo dicaprio's mind", "main charachter has like 8 dreams", 220, "thriller", "R", "2018-11-23"),
  ("Interstellar", "matthew mconanaughay, his daughter", "they go into like the 9th dimension of space", 400, "romance", "NC-17", "2018-08-15"),
  ("Casablanca", "some beautiful woman, some man who loves the beautiful woman", "a couple falls in love in black and white", 250, "romance", "NC-17", "2018-08-10"),
  ("The Lion King", "lion, lions dad", "lions go around town and fight evil", 70, "romance", "G", "2019-12-12"),
  ("WALLE", "walle, walle’s girlfriend robot", "robot goes from cleaning trash to picking up girl robots", 150, "action", "NC-17", "2018-08-30"),
  ("Toy Story", "woody, buzzlightyear", "a bunch of toys go on an adventure", 150, "action", "G", "2015-09-18"),
  ("Up", "grandpa, child, grandpa’s dead wife", "grandpa has a midlife crisis and moves his house to the hills", 150, "action", "NC-17", "2018-09-12"),
  ("The Wolf of Wall Street", "leonardio dicaprio, other business people", "dicaprio gets a lot of money and does bad things", 150, "comedy", "PG-13", "2018-09-12"),
  ("Finding Nemo", "clown fish, blue fish, turtle", "fish swims across ocean to find other fish", 160, "comedy", "R", "2018-12-25");

INSERT INTO PLAYS_AT
VALUES
  ("1", "Bohemian Rhapsody", 1),
  ("2", "Star Wars", 1),
  ("3", "The Shawshank Redemption", 1),
  ("4", "Pulp Fiction", 1),
  ("5", "Inception", 1),
  ("2", "Bohemian Rhapsody", 1),
  ("3", "Bohemian Rhapsody", 1),
  ("4", "Inception", 1);

INSERT INTO SHOWTIME
VALUES
	("2018-12-08 17:00:00", "1", "Bohemian Rhapsody", 15),
	("2018-12-09 12:00:00", "1", "Bohemian Rhapsody", 15),
	("2018-12-10 17:00:00", "1", "Bohemian Rhapsody", 15),
	("2018-12-09 20:00:00", "1", "Bohemian Rhapsody", 15),
	("2018-12-11 12:00:00", "1", "Bohemian Rhapsody", 15),
	("2018-12-11 17:00:00", "1", "Bohemian Rhapsody", 15),
	("2018-12-09 17:00:00", "2", "Bohemian Rhapsody", 15),
	("2018-12-08 17:00:00", "2", "Bohemian Rhapsody", 15),
	("2018-12-12 17:00:00", "3", "Bohemian Rhapsody", 15),
	("2018-12-11 20:00:00", "3", "Bohemian Rhapsody", 15),
	("2018-12-10 17:00:00", "2", "Star Wars", 15),
	("2018-12-09 12:00:00", "2", "Star Wars", 15),
	("2018-12-09 17:00:00", "2", "Star Wars", 15),
	("2018-12-10 20:00:00", "2", "Star Wars", 15),
	("2018-12-11 17:00:00", "3", "The Shawshank Redemption", 15),
	("2018-12-12 12:00:00", "3", "The Shawshank Redemption", 15),
	("2018-12-12 17:00:00", "3", "The Shawshank Redemption", 15),
	("2018-12-11 20:00:00", "3", "The Shawshank Redemption", 15),
	("2018-12-10 17:00:00", "4", "Pulp Fiction", 15),
	("2018-12-09 12:00:00", "4", "Pulp Fiction", 15),
	("2018-12-08 17:00:00", "4", "Pulp Fiction", 15),
	("2018-12-07 20:00:00", "4", "Pulp Fiction", 15),
	("2018-12-06 17:00:00", "4", "Inception", 15),
	("2018-12-05 12:00:00", "4", "Inception", 15),
	("2018-12-09 17:00:00", "4", "Inception", 15),
	("2018-12-08 20:00:00", "4", "Inception", 15),
	("2018-12-07 17:00:00", "5", "Inception", 15),
	("2018-12-10 12:00:00", "5", "Inception", 15),
	("2018-12-11 17:00:00", "5", "Inception", 15),
	("2018-12-12 20:00:00", "5", "Inception", 15);

INSERT INTO PREFERS
VALUES
  ("1", "jimmy"),
  ("2", "jimmy"),
  ("2", "bsmith") ,
  ("3", "bsmith") ,
  ("3", "ejones"),
  ("4", "ejones"),
  ("4", "clear"),
  ("5", "clear"),
  ("5", "steve"),
  ("1", "steve");

INSERT INTO ORDERS
VALUES
  ("1", "2018-12-26", "02:15:15", "Completed", 12, 4, 4, 4, "jimmy", "0987654323456789", "1", "Avengers", 15),
  ("2", "2018-12-26", "02:16:15", "Completed", 8, 0, 4, 4, "paul", "8800784593457364", "1", "Avengers", 15),
  ("3", "2018-12-26", "02:17:15", "Completed", 8, 4, 0, 4, "mary", "7688999934567658", "1", "Avengers", 15),
  ("4", "2018-12-26", "02:18:15", "Completed", 8, 4, 4, 0, "john", "8347362536890058", "1", "Avengers", 15),
  ("5", "2018-12-27", "02:18:15", "Completed", 13, 5, 4, 4, "jimmy", "0987654323456789", "1", "Finding Nemo", 15),
  ("6", "2018-12-27", "02:19:15", "Completed", 15, 4, 4, 4, "bob", "8746893283746190", "1", "Finding Nemo", 15),
  ("7", "2018-12-27", "02:20:15", "Completed", 12, 4, 4, 4, "james", "4832910482914738", "1", "Finding Nemo", 15),
  ("8", "2018-12-27", "02:25:15", "Completed", 12, 4, 4, 4, "bob", "4832701982398432", "1", "Finding Nemo", 15),
  ("9", "2018-12-27", "02:35:15", "Completed", 8, 0, 4, 4, "mary", "8876785654434566", "1", "Finding Nemo", 15),
  ("10", "2018-12-27", "04:15:15", "Completed", 11, 3, 4, 4, "david", "1010298329019238", "1", "Star Wars", 15),
  ("11", "2018-12-27", "04:13:15", "Completed", 12, 4, 4, 4, "jimmy", "8467182984301334", "2", "Star Wars", 15),
  ("12", "2018-12-28", "05:12:15", "Completed", 12, 4, 4, 4, "user1", "3820942390849333", "2", "Star Wars", 15),
  ("13", "2018-12-28", "05:11:15", "Completed", 10, 4, 4, 2, "kevin", "4328791083474739", "2", "Star Wars", 15),
  ("14", "2018-12-28", "06:15:15", "Completed", 10, 4, 2, 4, "clear", "6942011843723899", "2", "Finding Nemo", 15),
  ("15", "2018-12-28", "06:15:15", "Completed", 10, 2, 4, 4, "user1", "2390490234042304", "2", "Finding Nemo", 15),
  ("16", "2018-12-29", "07:15:15", "Completed", 12, 4, 4, 4, "jimmy", "0987654323456789", "2", "Inception", 15),
  ("17", "2018-12-29", "08:16:15", "Completed", 12, 4, 4, 4, "kevin", "4328791083474739", "2", "Inception", 15),
  ("18", "2018-12-29", "09:17:15", "Completed", 8, 4, 4, 0, "james", "4832910482914738", "2", "Finding Nemo", 15),
  ("19", "2018-12-29", "12:15:15", "Completed", 12, 4, 4, 4, "mary", "8876785654434566", "2", "Finding Nemo", 15),
  ("20", "2018-12-29", "12:15:15", "Completed", 12, 4, 4, 4, "jimmy", "8467182984301334", "2", "Finding Nemo", 15),
  ("21", "2018-12-27", "04:13:15", "Cancelled", 12, 4, 4, 4, "jimmy", "8467182984301334", "2", "Finding Nemo", 15),
  ("22", "2018-12-28", "05:12:15", "Cancelled", 12, 4, 4, 4, "user1", "3820942390849333", "2", "Finding Nemo", 15),
  ("23", "2018-12-28", "05:11:15", "Cancelled", 10, 4, 4, 2, "kevin", "4328791083474739", "2", "Finding Nemo", 15),
  ("24", "2018-12-28", "06:15:15", "Cancelled", 10, 4, 2, 4, "clear", "6942011843723899", "2", "Finding Nemo", 15),
  ("25", "2018-12-28", "06:15:15", "Cancelled", 10, 2, 4, 4, "user1", "2390490234042304", "2", "Finding Nemo", 15),
  ("26", "2018-12-29", "07:15:15", "Cancelled", 12, 4, 4, 4, "jimmy", "0987654323456789", "2", "Finding Nemo", 15),
  ("27", "2018-12-29", "08:16:15", "Cancelled", 12, 4, 4, 4, "kevin", "4328791083474739", "2", "Finding Nemo", 15),
  ("28", "2018-12-29", "09:17:15", "Cancelled", 8, 4, 4, 0, "james", "4832910482914738", "2", "Finding Nemo", 15),
  ("29", "2018-12-29", "12:15:15", "Cancelled", 12, 4, 4, 4, "mary", "8876785654434566", "2", "Finding Nemo", 15),
  ("30", "2018-11-29", "12:15:15", "Cancelled", 12, 4, 4, 4, "jimmy", "8467182984301334", "2", "Finding Nemo", 15),
  ("31", "2018-11-27", "04:13:15", "Completed", 2, 2, 0, 0, "jimmy", "8467182984301334", "2", "Finding Nemo", 15),
  ("32", "2018-11-28", "05:12:15", "Completed", 2, 1, 1, 0, "user1", "3820942390849333", "2", "Finding Nemo", 15),
  ("33", "2018-11-28", "05:11:15", "Completed", 2, 0, 2, 0, "kevin", "4328791083474739", "2", "Finding Nemo", 15),
  ("34", "2018-11-28", "06:15:15", "Completed", 2, 0, 0, 2, "clear", "6942011843723899", "2", "Finding Nemo", 15),
  ("35", "2018-10-28", "06:15:15", "Completed", 2, 0, 1, 1, "user1", "2390490234042304", "2", "Finding Nemo", 15),
  ("36", "2018-10-29", "07:15:15", "Completed", 2, 1, 0, 1, "jimmy", "0987654323456789", "2", "Finding Nemo", 15),
  ("37", "2018-10-29", "08:16:15", "Completed", 2, 0, 2, 0, "kevin", "4328791083474739", "2", "Finding Nemo", 15),
  ("38", "2018-10-29", "09:17:15", "Completed", 2, 2, 0, 0, "james", "4832910482914738", "2", "Finding Nemo", 15),
  ("39", "2018-10-29", "12:15:15", "Completed", 2, 1, 1, 0, "mary", "8876785654434566", "2", "Finding Nemo", 15),
  ("40", "2018-10-29", "12:15:15", "Completed", 2, 0, 1, 1, "jimmy", "8467182984301334", "2", "The Grinch", 15),
  ("41", "2018-11-27", "04:13:15", "Completed", 2, 2, 0, 0, "jimmy", "8467182984301334", "2", "The Grinch", 15),
  ("42", "2018-11-28", "05:12:15", "Completed", 2, 1, 1, 0, "user1", "3820942390849333", "2", "The Grinch", 15),
  ("43", "2018-11-28", "05:11:15", "Completed", 2, 0, 2, 0, "kevin", "4328791083474739", "2", "Casablanca", 15),
  ("44", "2018-11-28", "06:15:15", "Completed", 2, 0, 0, 2, "clear", "6942011843723899", "2", "Casablanca", 15),
  ("45", "2018-10-28", "06:15:15", "Completed", 2, 0, 1, 1, "user1", "2390490234042304", "2", "Casablanca", 15),
  ("46", "2018-10-29", "07:15:15", "Completed", 2, 1, 0, 1, "jimmy", "0987654323456789", "2", "Avengers", 15),
  ("47", "2018-10-29", "08:16:15", "Completed", 2, 0, 2, 0, "kevin", "4328791083474739", "2", "Casablanca", 15),
  ("48", "2018-10-29", "09:17:15", "Completed", 2, 2, 0, 0, "james", "4832910482914738", "2", "The Grinch", 15),
  ("49", "2018-10-29", "12:15:15", "Completed", 2, 1, 1, 0, "mary", "8876785654434566", "2", "The Grinch", 15),
  ("50", "2018-10-29", "12:15:15", "Completed", 2, 0, 1, 1, "jimmy", "8467182984301334", "2", "The Grinch", 15),
  ("51", "2018-10-29", "12:15:15", "Completed", 2, 0, 1, 1, "jimmy", "8467182984301334", "2", "Up", 15),
  ("52", "2018-11-27", "04:13:15", "Completed", 2, 2, 0, 0, "jimmy", "8467182984301334", "2", "The Grinch", 15),
  ("53", "2018-11-28", "05:12:15", "Completed", 2, 1, 1, 0, "user1", "3820942390849333", "2", "The Grinch", 15),
  ("54", "2018-11-28", "05:11:15", "Completed", 2, 0, 2, 0, "kevin", "4328791083474739", "2", "The Grinch", 15),
  ("55", "2018-11-28", "06:15:15", "Completed", 2, 0, 0, 2, "clear", "6942011843723899", "2", "Up", 15),
  ("56", "2018-10-28", "06:15:15", "Completed", 2, 0, 1, 1, "user1", "2390490234042304", "2", "The Wolf of Wall Street", 15);

INSERT INTO REVIEW
VALUES
("1", "good movie", "movie was great lol", "Finding Nemo", 5, "jimmy"),
("2", "scary", "too scary not for kids", "The Grinch" , 2, "mary"),
("3", "super", "too many superheroes" , "Avengers" , "3", "bob"),
("4", "queen", "queen is pretty good" , "Bohemian Rhapsody" , "4", "clear"),
("5", "great effects", "yeah great effects" , "Star Wars" , 5, "clear"),
("6", "freeman", "morgan freeman is a god" , "The Shawshank Redemption" , 5, "clear"),
("7", "violence", "violence is bad" , "Pulp Fiction" , 1, "clear"),
("8", "going on", "what is going on" , "Inception" , 1, "clear"),
("9", "outer space", "outer space looked really good" , "Interstellar" , 4, "clear"),
("10", "yeah", "i don't like black and white movies" , "Casablanca" , 2, "clear"),
("11", "lions", "too many lions needed other animals" , "The Lion King" , 2, "clear"),
("12", "good lions", "lions are good" , "The Lion King" , 5, "clear"),
("13", "buzzy", "buzz lightyear is a god" , "Toy Story" , 5, "clear"),
("14", "lots of baloons", "too many balloons" , "Up" , 1, "clear"),
("15", "economics", "movie made me like economics" , "The Wolf of Wall Street" , 1, "clear"),
("16", "symbols", "movie did a great job of symbolizing why fish are awesome" , "Finding Nemo" , 4, "clear"),
("17", "queen", "queen is awful" , "Bohemian Rhapsody" , 1, "clear"),
("18", "complicated", "too complicated" , "Up" , 1, "clear"),
("19", "very simple", "too simple" , "Inception" , 1, "clear"),
("20", "super christmas", "christmas is insane" , "The Grinch" , 5, "clear");

INSERT INTO SYSTEMINFO
VALUES
  (5, 30, 20, "football");
