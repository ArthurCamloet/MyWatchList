
<?php

      include 'connection.php';
      include 'display_search_result.php';

      if(!empty($_GET['search'])){

        $option = $_GET['option'];
        $sorting_option = $_GET['sorting-option'];

        //escape the strings
        $search_key = $mysqli->escape_string($_GET['search']);

        if($_GET['option'] === 'Any'){

          /*
          $search_query = $mysqli->query("SELECT * FROM MOVIE, GENRE, is_genres, has_tags
            WHERE MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND MOVIE.movie_id = has_tags.movie_id AND has_tags.tag_id = TAGS.tag_id
            AND (title LIKE '%" . "$search_key" . "%' OR genre LIKE '%" . "$search_key" . "%')");
          */
        }
        else {
          if($_GET['option'] === 'Title'){

            if($_GET['sorting-option'] === 'Alphabetical'){
              $order_option = 'title';
            }
            else if($_GET['sorting-option'] === 'Release Year'){
              $order_option = 'release_date';
            }
            else if($_GET['sorting-option'] === 'Duration'){
              $order_option = 'duration';
            }
            else{
              $order_option = '';
            }

            if(empty($_GET['genre'])){
              $genre[0] = '';
              $genre_query = "SELECT DISTINCT MOVIE.movie_id FROM MOVIE, GENRE, is_genres WHERE MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND title LIKE '%$search_key%' ORDER BY $order_option";
            }
            else {

              $genre_query = "SELECT DISTINCT MOVIE.movie_id FROM MOVIE, GENRE, is_genres WHERE MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND title LIKE '%$search_key%'";

              $genre = $_GET['genre'];
              $counter = 0;
              foreach ($genre as $genre_values) {
                if($counter == 0){
                  $genre_query .= " AND (genre = '$genre_values'";
                }
                else{
                  $genre_query .= " OR genre = '$genre_values'";
                }
                $counter += 1;
              }

              $genre_query .= ") ORDER BY $order_option";
            }

            $search_query = $mysqli->query($genre_query);

          }
          else if($_GET['option'] === 'Crew'){

            if($_GET['sorting-option'] === 'Alphabetical'){
              $order_option = 'title';
            }
            else if($_GET['sorting-option'] === 'Release Year'){
              $order_option = 'release_date';
            }
            else if($_GET['sorting-option'] === 'Duration'){
              $order_option = 'duration';
            }
            else{
              $order_option = '';
            }

            //$search_query = $mysqli->query("SELECT * FROM MOVIE, GENRE, is_genres WHERE MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND genre LIKE '%$search_key%' GROUP BY (MOVIE.movie_id) ORDER BY $order_option");

            if(empty($_GET['genre'])){
              $genre[0] = '';
              $genre_query = "SELECT DISTINCT MOVIE.movie_id FROM MOVIE, has_crew, CREW, MEMBER, has_members, GENRE, is_genres WHERE MOVIE.movie_id = has_crew.movie_id AND has_crew.crew_id = CREW.crew_id AND MEMBER.mem_id = has_members.mem_id AND CREW.crew_id = has_members.crew_id AND MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND name LIKE '%$search_key%' ORDER BY $order_option";
            }
            else {

              $genre_query = "SELECT DISTINCT MOVIE.movie_id FROM MOVIE, has_crew, CREW, MEMBER, has_members, GENRE, is_genres WHERE MOVIE.movie_id = has_crew.movie_id AND has_crew.crew_id = CREW.crew_id AND MEMBER.mem_id = has_members.mem_id AND CREW.crew_id = has_members.crew_id AND MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND name LIKE '%$search_key%'";

              $genre = $_GET['genre'];
              $counter = 0;
              foreach ($genre as $genre_values) {
                if($counter == 0){
                  $genre_query .= " AND (genre = '$genre_values'";
                }
                else{
                  $genre_query .= " OR genre = '$genre_values'";
                }
                $counter += 1;
              }

              $genre_query .= ") ORDER BY $order_option";
            }

            $search_query = $mysqli->query($genre_query);

          }
          else if($_GET['option'] === 'Tag'){

            if($_GET['sorting-option'] === 'Alphabetical'){
              $order_option = 'title';
            }
            else if($_GET['sorting-option'] === 'Release Year'){
              $order_option = 'release_date';
            }
            else if($_GET['sorting-option'] === 'Duration'){
              $order_option = 'duration';
            }
            else{
              $order_option = '';
            }

            if(empty($_GET['genre'])){
              $genre[0] = '';
              $genre_query = "SELECT DISTINCT MOVIE.movie_id FROM MOVIE, TAGS, has_tags WHERE MOVIE.movie_id = has_tags.movie_id AND has_tags.tag_id = TAGS.tag_id AND tag LIKE '%$search_key%' ORDER BY $order_option";
            }
            else {

              $genre_query = "SELECT DISTINCT MOVIE.movie_id FROM MOVIE, GENRE, is_genres, TAGS, has_tags WHERE is_genres.movie_id = MOVIE.movie_id AND GENRE.genre_id = is_genres.genre_id AND MOVIE.movie_id = has_tags.movie_id AND has_tags.tag_id = TAGS.tag_id AND tag LIKE '%$search_key%'";

              $genre = $_GET['genre'];
              $counter = 0;
              foreach ($genre as $genre_values) {
                if($counter == 0){
                  $genre_query .= " AND (genre = '$genre_values'";
                }
                else{
                  $genre_query .= " OR genre = '$genre_values'";
                }
                $counter += 1;
              }

              $genre_query .= ") ORDER BY $order_option";
            }

            $search_query = $mysqli->query($genre_query);

          }

          if($search_query){

            // for each search result, print out a little block of info
            while($current_row = $search_query->fetch_assoc()){
              $movie_id = $current_row['movie_id'];

              displaySearchResult($movie_id, $admin_tag, $search_key, 0, $option, $sorting_option, $genre);

            }

            if ($search_query->num_rows == 1) {
              echo $search_query->num_rows . ' result found.<br><br>';
            } else {
              echo $search_query->num_rows . ' results found.<br><br>';
            }
          }
          else {
            die('Error');
          }
        }
      }
      else{

        if(!empty($_GET['genre'])){

          $option = $_GET['option'];
          $sorting_option = $_GET['sorting-option'];

          if($_GET['option'] === 'Title'){

            if($_GET['sorting-option'] === 'Alphabetical'){
              $order_option = 'title';
            }
            else if($_GET['sorting-option'] === 'Release Year'){
              $order_option = 'release_date';
            }
            else if($_GET['sorting-option'] === 'Duration'){
              $order_option = 'duration';
            }

            $search_key = "";
            $genre = $_GET['genre'];
            $counter = 0;
            $genre_query = "";
            foreach ($genre as $genre_values) {
              if ($counter != 0) {
                $genre_query .= " UNION ";
                $genre_query .=  "SELECT DISTINCT MOVIE.movie_id, title, duration, release_date FROM MOVIE, GENRE, is_genres WHERE MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND genre = '$genre_values'";
              }
              else {
                $genre_query .=  "SELECT DISTINCT MOVIE.movie_id, title, duration, release_date FROM MOVIE, GENRE, is_genres WHERE MOVIE.movie_id = is_genres.movie_id AND is_genres.genre_id = GENRE.genre_id AND genre = '$genre_values'";
              }
              $counter += 1;
            }

            $genre_query .= " ORDER BY $order_option";
          }
          $genre_query = $mysqli->query($genre_query);
          if($genre_query){

            // for each search result, print out a little block of info
            while($current_row = $genre_query->fetch_assoc()){
              $movie_id = $current_row['movie_id'];

              displaySearchResult($movie_id, $admin_tag, $search_key, 0, $option, $sorting_option, $genre);

            }

            if ($genre_query->num_rows == 1) {
              echo $genre_query->num_rows . ' result found.<br><br>';
            } else {
              echo $genre_query->num_rows . ' results found.<br><br>';
            }
          }
          else {
            die('Error');
          }
      }
    }

?>
