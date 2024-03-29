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

    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">//font
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">

    <!-- include stylesheets -->
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="../css/main_page.css" type="text/css">

    <?php
      include '../functions/session.php';
    ?>

    <script type="text/javascript">
    function toggle(source) {
      checkboxes = document.getElementsByName('genre[]');
      for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
      }
    }
    </script>
  </head>
<body>
  <div id="main-page" class="container">
    <div class="row shadow">
      <div class="main-page-title">
        <h1>
          <i class="fa fa-star" aria-hidden="true"></i>
          MYwatchList
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
        <button type="button" class="btn btn-danger logout"><a href="../login.php">Logout</a></button>
      </div>
    </div>
    <div class= "row page-content">
      <div class = "col-sm-3">
        <div class="well">
          <h1> Genres </h1>
          <?php
            if($admin_tag){
              echo '<form method="post" action="../functions/add_genre.php">
              <div class="genre-form">
                <input class="add-genre-text" type="text" name="genre" placeholder="Genre" required>
                <button type="submit" class="add-genre btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
              </div>
              </form>';
            }
          ?>
          <form method="get" action="">
            <?php
              include '../functions/connection.php';

              $genre_input_query = $mysqli->query("SELECT * FROM GENRE");

              echo '<input type="checkbox" onClick="toggle(this);"> All Genres<br>';

              while($current_row = $genre_input_query->fetch_assoc()){
                $i_genre = $current_row['genre'];
                $i_genre_id = $current_row['genre_id'];
                if ($admin_tag == 1) {
                  echo '<a class="light-x" href="../functions/delete_genre.php?genre_id=' . $i_genre_id . '" onclick="return confirm(\'Are you sure you want to remove the genre ' . $i_genre . ' from the database?\')"><i class="fa fa-times" aria-hidden="true"></i></a> ';
                }
                echo '<input type="checkbox" name="genre[]" value="' . $i_genre . '"> ' . $i_genre . '<br>';
              }
            ?>
          </div>
      </div>
        <div class="col-sm-9 search-window">
          <div class="row search-bar">
              <div class="col-xs-12 col-sm-3 search-options">
                <span class="small-title">Search By:</span>
                <select name="option">
                  <option>Title</option>
                  <option>Crew</option>
                  <option>Tag</option>
                </select>
                <span class="small-title">Sort By:</span>
                <select name="sorting-option">
                  <option>Alphabetical</option>
                  <option>Release Year</option>
                  <option>Duration</option>
                  <!--<option>Rating</option>-->
                </select>
              </div>
              <div class="col-xs-12 col-sm-9 form-input">
                <div class="text-and-button">
                  <input placeholder="Search" name="search" type="text" class="search-text">
                  <button type="submit" name="submit" value="Search" class="btn btn-success search-btn">Search</button>
                </div>
              </div>
            </form>
          </div>
          <div class="row results-row">
            <?php

                if(!empty($message) && $status == 'Success'){
                  echo '<br><div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message . '</div>';
                  $_SESSION['message'] = '';
                }
                else if(!empty($message) && $status == 'Failure'){
                  echo '<br><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message . '</div>';
                  $_SESSION['message'] = '';
                }
            ?>
            <h1> Results: </h1>
            <?php

              include '../functions/search.php';
            ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
