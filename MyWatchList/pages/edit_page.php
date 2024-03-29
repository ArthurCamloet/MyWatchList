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
    <link rel="stylesheet" href="../css/add_page.css" type="text/css">

    <?php
      include '../functions/session.php';
      include '../functions/connection.php';

      //makes sure no one can access this page if they are not a manager
      if($_SESSION['admin_tag'] != 1){

        $_SESSION['message'] = 'Request Failed. You do not have permission to view that page!';
        $_SESSION['status'] = 'Failure';

        header("location: main_page.php");
      }

      if(isset($_GET['movie_id']) && !empty($_GET['movie_id'])){

        $movie_id = $_GET['movie_id'];
        $movie_query = $mysqli->query("SELECT * FROM MOVIE WHERE movie_id=$movie_id");
        $movie_tuple = $movie_query->fetch_assoc();

        $c_title = $movie_tuple['title'];
        $c_release_date = $movie_tuple['release_date'];
        $c_summary = $movie_tuple['summary'];
        $c_language = $movie_tuple['language'];
        $c_duration = $movie_tuple['duration'];
        $c_trailer = $movie_tuple['trailer'];
        $c_poster = $movie_tuple['poster'];
        $search = $_GET['search'];
        $option = $_GET['option'];
        $sorting_option = $_GET['sorting-option'];
      }
      else {
        header("location: main_page.php");
      }

      if(isset($_POST['submit'])){

        //translate the form inputs into php variables
        $title = $mysqli->escape_string($_POST['title']);
        $release_date = $mysqli->escape_string($_POST['release_date']);
        $summary = $mysqli->escape_string($_POST['summary']);
        $language = $mysqli->escape_string($_POST['language']);
        $duration = $mysqli->escape_string($_POST['duration']);
        $trailer = $mysqli->escape_string($_POST['trailer']);
        $poster = $mysqli->escape_string($_POST['poster']);
        $movie_id = $mysqli->escape_string($_GET['movie_id']);

        //create the insertion query using the form data
        $update_query = $mysqli->query("UPDATE MOVIE SET title='$title', release_date='$release_date', summary='$summary', language='$language', duration='$duration', trailer='$trailer', poster='$poster' WHERE movie_id=$movie_id");

        if($update_query){

          $genre_list = '';
          if(isset($_GET['genre'])){
            $genre = $_GET['genre'];
            foreach($genre as $genre_value){
              if($genre_value != ''){
                $genre_list .= '&genre[]=';
                $genre_list .= $genre_value;
              }
            }
          }

          $_SESSION['status'] = 'Success';
          $_SESSION['message'] = 'Success! The information for '. $title .' was modified.';

          header("location: main_page.php?search=$search&option=$option&sorting-option=$sorting_option&submit=Search$genre_list");
        }
        else{
          die("Error...");
        }

        //Close the connection to the database
        $mysqli->close();
      }

    ?>
  </head>
<body>
  <div class="container">
    <div class="row shadow">
      <div class="main-page-title">
        <h1>MyWatchList</h1>
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
        <button type="button" class="btn btn-danger logout"><a href="../login.php">Logout</a></button>
      </div>
    </div>
    <div class= "row page-content">
      <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-xs-12 col-md-6 add-form">
            <img src="https://cdn4.iconfinder.com/data/icons/IMPRESSIONS/multimedia/png/400/video.png"></img>
            <?php
              echo "<div class='well'><h2>$c_title</h2></div>";
            ?>
            <h4>
              <?php
                if(isset($_POST['add_genre'])){
                  include '../functions/add_genre_to_movie.php';
                }
                else if(isset($_POST['delete_genre'])){
                  include '../functions/delete_genre_from_movie.php';
                }
                $is_genres_query = $mysqli->query("SELECT * FROM is_genres WHERE movie_id = $movie_id");
                $first = true;
                while ($is_genres_tuple = $is_genres_query->fetch_assoc()) {
                  $genre_id = $is_genres_tuple['genre_id'];
                  $genre_query = $mysqli->query("SELECT * FROM GENRE WHERE genre_id = $genre_id");
                  if ($genre_tuple = $genre_query->fetch_assoc()) {
                    $genre = $genre_tuple['genre'];
                    if ($first) {
                      echo $genre;
                      $first = false;
                    } else {
                      echo ", $genre";
                    }
                  }
                }
              ?>
            </h4>
            <form id="genre-form" method="post" action="">
              <select name="genre_select" class="genres-select">
                <?php
                $genres_query = $mysqli->query("SELECT * FROM GENRE");
                while ($genres_tuple = $genres_query->fetch_assoc()) {
                  $i_genre = $genres_tuple['genre'];
                  $i_genre_id = $genres_tuple['genre_id'];
                  echo '<option value="' . $i_genre_id .'">' . $i_genre . '</option>';
                }
                ?>
              </select>
              <input style="display: none;" type="text" name="option" value="<?php echo $option; ?>">
              <input style="display: none;" type="text" name="sorting-option" value="<?php echo $sorting_option; ?>">
              <input style="display: none;" type="text" name="movie_id" value="<?php echo $movie_id; ?>">
              <button form="genre-form" type="submit" name="delete_genre" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
              <button form="genre-form" type="submit" name="add_genre" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button><br><br>
            </form>
            <form method="post" action="">
              <input type="text" name="title" value="<?php echo $c_title;?>"><br>
              <input type="date" name="release_date" value="<?php echo $c_release_date;?>"><br>
              <textarea name="summary" rows="8" cols="50"><?php echo $c_summary;?></textarea><br>
              <input type="text" name="language" value="<?php echo $c_language;?>"><br>
              <input type="text" name="duration" value="<?php echo $c_duration;?>"><br>
              <input type="text" name="trailer" value="<?php echo $c_trailer;?>"><br>
              <input type="text" name="poster" value="<?php echo $c_poster;?>"><br>
              <input class="databased-btn" type="submit" name="submit" value="Update Movie">
            </form>
          </div>
          <div class="col-md-3"></div>
        </div>
      </div>
    </div>
  </body>
</html>
