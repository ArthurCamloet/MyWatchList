<!DOCTYPE html>
<html>
  <head>
    <title>Login Form</title>
    <meta charset="UTF-8">

    <!-- fix for viewport scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- include bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- include stylesheets -->
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/login_style.css" type="text/css">



    <!-- Javascipt -->
    <script type="text/javascript">
      function Success(){
        alert("Login was successful!");
      }
      function PassFailure(){
        alert("Login unsuccessful. The password was not correct.");
      }
      function UserFailure(){
        alert("Login unsuccessful. The username could not be found.");
      }
    </script>

    <?php
      session_start();
      session_unset();
      session_destroy();

      if(!empty($_POST)){

        include 'functions/connection.php';
        session_start();

        //escape the strings
        $username = $mysqli->escape_string($_POST['username']);
        $password = $mysqli->escape_string($_POST['password']);
        $username = strtolower($username);
		    $password = hash ( "sha256", $password . $username );

        //Gather the query for finding the particular username
        $username = strtolower($username);
        $sql = "call login('$username','$password')";
        $result = $mysqli->query($sql);

        if($result->num_rows == 0){
          echo "<script type='text/javascript'> UserFailure(); </script>";
        }
        else{
          $row = $result->fetch_assoc();

          if($password === $row['password']){

            //create session global variables
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['middle_name'] = $row['middle_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['admin_tag'] = $row['admin_tag'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['message'] = '';
            $_SESSION['status'] = '';

            $_SESSION['logged_in'] = true;

            //redirect to the main page
            header("location: pages/home_page.php");

          }
          else{
            echo "<script type='text/javascript'> PassFailure(); </script>";
          }
        }

        //Close the connection
        $mysqli->close();
      }

    ?>
  </head>
  <body>
    <div class="full-bg-img background-img">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3 login-container">
            <img src="https://www.hit4hit.org/img/login/user-icon-6.png"></img>

            <div class="login-title">
              <h2>MyWatchList Login:</h2>
            </div>

            <form method="post" action="">
              <div class="form-input">
                <input placeholder="Username" type="text" name="username" required><br>
                <input placeholder="Password" type="password" name="password" required>
              </div>
              <input type="submit" name="submit" value="LOGIN" class="login-btn">
            </form>
            <a href="register.php">New User? Register here.</a>
            <br><br>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
