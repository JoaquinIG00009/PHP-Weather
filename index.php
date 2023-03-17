<?php
  if(array_key_exists('submit', $_GET)) {

    if(!$_GET['city']) {
      $error = "This field can't be empty!";
    }

    if($_GET['city']) {
      $weatherApiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&appid=7e8e137dd88e1817328af0ed0943d82f");

      $weatherArray = json_decode($weatherApiData, true);

      if($weatherArray['cod'] == 200) {
        $city = $weatherArray['name'];

        $timezone = $weatherArray['timezone'];
        $currentTime = time() + $timezone;
        $realTime = gmdate('H:i', $currentTime);

        $weather = $weatherArray['weather'][0]['description'];
        $celcius = $weatherArray['main']['temp'] - 273;
        $celciusH = $weatherArray['main']['temp_max'] - 273;
        $celciusL = $weatherArray['main']['temp_min'] - 273;
      } else {
        $error = "Couldn't find the city name, enter a valid one.";
      }

    }

  }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Weather</title>

    <style>
      body {
        background-color: black;
      }
      .w {
        color: white;
      }
      .search-btn {
        border: none;
        border-top-left-radius: 7px;
        border-bottom-left-radius: 7px;
        background-color: #1e1e1e;
        padding: 3px 5px;
        cursor: pointer;
      }

      .search-btn img {
        width: 24px;
        height: auto;
      }

      .search {
        border: none;
        border-top-right-radius: 7px;
        border-bottom-right-radius: 7px;
        background-color: #1e1e1e;
        color: #99999f;
        padding: 3px 5px;
      }
      .city {
        margin: 15px 0px;
        padding: 15px;
        border: none;
        border-radius: 16px;
        background-color: lightskyblue;
        color: white;
        display: flex;
        justify-content: space-between;
      }
    </style>
  </head>

  <body>
    <div class="container" style="margin-top: 15px">
      <h1 class="w">Weather</h1>

      <form action="" method="GET">
        <div class="input">
          <button class="search-btn" type="submit" name="submit">
            <!-- <img src="src/search.png" alt="Button Image"> -->
            🔍
          </button>

          <input class="search" type="text" name="city" id="city" placeholder="Search for a city">
        </div>
        
        <div class="output">
          <?php

            if($weather) {
              echo '<div class="city">
                      <div>
                        <div><h3>'. $city .'</h3><br>'. $realTime .'</div>
                        <div style="text-transform: capitalize;">'. $weather .'</div>
                      </div>
                      <div style="display: flex; flex-direction: column; justify-content: space-between;"><h1 style="text-align: right;">'. substr($celcius, 0, -3) .'&deg;</h1>
                        <div><span>H: '. substr($celciusH, 0, -3) .'</span><span> &nbsp;L: '. substr($celciusL, 0, -3) .'</span></div>
                      </div>
                    </div>';
            }

            if($error) {
              echo '<div style="margin: 15px 0px; color: red;">'.$error.'<div>';
            }

          ?>
        </div>

      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>