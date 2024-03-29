<!DOCTYPE html>
<html>
  <head>
    <title> MyWatchList </title>
    <meta charset="UTF-8">

    <!-- fix for viewport scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- include bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">

    <!-- include stylesheets -->
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="../css/home_page.css" type="text/css">

    <?php
      include '../functions/session.php';
    ?>
  </head>
  <body>
    <div id="home-page" class="container">
      <div class="row shadow">
        <div class="main-page-title">
          <h1>
            <i class="fa fa-star" aria-hidden="true"></i>
            MywatchList
            <i class="fa fa-star" aria-hidden="true"></i>
          </h1>
        </div>
        <div id="tool-bar">
          <a href="home_page.php"><button class="btn btn-info"><i class="fa fa-home" aria-hidden="true"></i></button></a>
          <?php
            if($admin_tag == 1){
              echo
               '<div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    Manager
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="users_page.php">View Users</a></li>
                    <li><a href="crews_page.php">View Crews</a></li>
                    <li><a href="add_page.php">Add a Movie</a></li>
                  </ul>
                </div>';
            }
          ?>
          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
              User
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
               <li><a href="main_page.php">Search Movies</a></li>
               <li><a href="watchlist_page.php">My Watchlist</a><li>
            </ul>
          </div>
          <span class="greeting"><?php echo 'Hello, ' . $first_name . ' ' . $last_name; ?></span>
          <a href="../login.php"><button type="button" class="btn btn-danger logout">Logout</button></a>
        </div>
      </div>

      <div class="row photobanner-container">

        <!-- https://designshack.net/tutorialexamples/photobanner/index.html -->
        <div class="photobanner">
          <a href="<?php echo "rate_page.php?movie_id=13&navigated-from=home"; ?>"><img class="poster first" src="../images/posters/40yo-virgin.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=22&navigated-from=home"; ?>"><img class="poster" src="../images/posters/divergent.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=14&navigated-from=home"; ?>"><img class="poster" src="../images/posters/fight-club.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=12&navigated-from=home"; ?>"><img class="poster" src="../images/posters/force-awakens.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=21&navigated-from=home"; ?>"><img class="poster" src="../images/posters/frank.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=11&navigated-from=home"; ?>"><img class="poster" src="../images/posters/guardians.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=18&navigated-from=home"; ?>"><img class="poster" src="../images/posters/her.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=20&navigated-from=home"; ?>"><img class="poster" src="../images/posters/inception.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=19&navigated-from=home"; ?>"><img class="poster" src="../images/posters/interstellar.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=15&navigated-from=home"; ?>"><img class="poster" src="../images/posters/jaws.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=17&navigated-from=home"; ?>"><img class="poster" src="../images/posters/jurassic-park.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=16&navigated-from=home"; ?>"><img class="poster" src="../images/posters/titanic.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=13&navigated-from=home"; ?>"><img class="poster" src="../images/posters/40yo-virgin.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=22&navigated-from=home"; ?>"><img class="poster" src="../images/posters/divergent.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=14&navigated-from=home"; ?>"><img class="poster" src="../images/posters/fight-club.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=12&navigated-from=home"; ?>"><img class="poster" src="../images/posters/force-awakens.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=21&navigated-from=home"; ?>"><img class="poster" src="../images/posters/frank.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=11&navigated-from=home"; ?>"><img class="poster" src="../images/posters/guardians.jpg"></a>
          <a href="<?php echo "rate_page.php?movie_id=18&navigated-from=home"; ?>"><img class="poster" src="../images/posters/her.jpg"></a>
        </div>

      </div>
      <div class="row info">
        <h1>Welcome to Movie-DB!</h1>
        <div class="col-sm-4 col-sm-offset-2"><span>&emsp;Movie-DB is a large database of popular movies, complete with searchable information on each movie. Crews, Producers, and Actors for each movie are saved on the database, as well as release dates and movie lengths.</span> </div>
        <div class="col-sm-4"><span>&emsp;As a user, you have the ability to rate and leave comments on movies that you have watched. Help improve our database by leaving feedback on your favorite movies! To begin your search in the database, click the button below. </span></div>
      </div>
      <div class="row search">
        <h3>Search!</h3>
        <a href="main_page.php"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search" aria-hidden="true"></i></button></a>
      </div>
      
     </div>
    </div>

  </body>
</html>`````
