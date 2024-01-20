<?php $title = 'OpaD@m_Jukebox_code16012024O'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $title ?>
  </title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link defer rel="stylesheet" href="style.css">
  <script defer src="./script.js?01234"></script>
</head>

<?php
// DEFINE VARIABLES AND SET TO EMPTY VALUES ---
$songs = [];
$songs_array = [];
$search_array = [];
$shuffle_array = [];
$musicPath = "../_music/";
$shuffle = 'off';
$search = 'off';
$playing = 'off';
$dirName = 'Muziek';
// DIRNAME ///////////////////////////////////////////////////
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["dirName"])) {
    $dirName = $_POST["dirName"];             //DIRNAME
  }
}
if (empty($dirName)) {
  $dirName = "Muziek";
}
$filePath = $musicPath . $dirName . "/"; //FILEPATH

// ! MAKE ARRAY $SONGS_array ---- SCANDISK -----------
global $filePath;
$files = scandir($filePath);
foreach ($files as $file) {
  if (substr($file, -4) === ".mp3") {
    $file = substr($file, 0, -4);
    array_push($songs_array, $file);
  }
}

// $songs_shuffle = array_merge(array(), $songs_array);
$songs_index = array_merge(array(), $songs_array);      // ! COPY array to new array //
?>

<body>
  <!-- set clock timezone -->
  <?php date_default_timezone_set('Europe/Amsterdam'); ?>
  <p class="clock" id="time"></p>

  <header id="header">
    <form id="form" class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"autocomplete="input">
      <input class="btn" id="myInput" type="text" name="input" placeholder="Search..."> <!-- Search input -->
      <select class="btn" id="dirName" name="dirName"> <!-- select dirName -->
        <option value="<?= $dirName ?>"><?= $dirName ?></option>
        <option value="Muziek">Muziek</option>
        <option value="Evergreen">Evergreen</option>
        <option value="TOP 2500 van 1965 tot 1990">TOP 2500 van 1965 tot 1990</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1965">Top 40 - 1965 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1966">Top 40 - 1966 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1967">Top 40 - 1967 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1968">Top 40 - 1968 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1969">Top 40 - 1969 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1970">Top 40 - 1970 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1971">Top 40 - 1971 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1972">Top 40 - 1972 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1973">Top 40 - 1973 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1974">Top 40 - 1974 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1975">Top 40 - 1975 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1976">Top 40 - 1976 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1977">Top 40 - 1977 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1978">Top 40 - 1978 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1979">Top 40 - 1979 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1980">Top 40 - 1980 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1981">Top 40 - 1981 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1982">Top 40 - 1982 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1983">Top 40 - 1983 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1984">Top 40 - 1984 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1985">Top 40 - 1985 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1986">Top 40 - 1986 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1987">Top 40 - 1987 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1988">Top 40 - 1988 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1989">Top 40 - 1989 top100</option>
        <option value="TOP 100-JAAROVERZICHT VAN 1990">Top 40 - 1990 top100</option>
      </select>
      <input type="checkbox" class="btn" id="shuffle" name="shuffle" checked> <!-- Shuffle checked -->
      <label for="shuffle">Shuffle</label>
      <button class="select btn submit" type="submit">Enter</button> <!-- submit -->
    </form>

    <audio id="audioPlayer" controls src=""></audio>
    <h3 id="prt_song" class='blink-class'></h3>
    <button class='btn' onclick='goToPlaying()'>goto Playing</button>
    <button class='btn' onclick='goToPlayList()'>goto Play List</button>
    <button class='btn' onclick='prev_song()'> << PREV </button>
        <button class='btn' onclick='next_song()'> NEXT >> </button>
  </header>
  <img class="coin" src="./image/coin-input.jpg" alt="coin" width='46px'>
  <img class="neon" src="./image/neon.gif" alt="coin" width='300'>


  <div id="container">
    <div id="div1"></div>
    <center class="prt_h3">
      <hr>
      <h3>***** LocalList *****
      </h3>
    </center>
    <div id="localList"></div>

    <center class="prt_h3">
      <hr>
      <h3>***** Play List *****
      </h3>
      <span id="top_play_list"></span>
    </center>

    <div id="playList">

      <?php

      // ! Shuffle Array $songs ------SHUFFLE ARRAY----------///
      function shuffle_array()
      {
        global $shuffle_array, $songs_array;
        $shuffle_array = $songs_array;
        shuffle($shuffle_array);
        return $shuffle_array;
      }

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["shuffle"])) {
          $shuffle = "on";
          $songs_array = shuffle_array();
        }
      }
      // ! Shuffle Array $songs ---------End----////

      // ! POST input search----------------------------------------------------
      if (isset($_POST['input']))
        ;
      $search = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_SPECIAL_CHARS);
      if (empty($search))
        $search = '';
      $search = strtolower($search);
      foreach ($songs_array as $file) {
        $file = strtolower($file);
        if (str_contains($file, $search)) {
          array_push($search_array, $file);
        }
      }

      if (!empty($search_array) && $playing == "off") {
        $search = "on";
        $songs = $search_array;
        print_array();
      } else {
        $search = "off";
        $playing = "on";
      }

      function print_array()
      {
        global $filePath, $search, $songs, $playing, $dirName, $songs_array;
        if ($search === "off")
          $songs = $songs_array;
        foreach ($songs as $key => $value) {
          $txt = explode("-", $value);
          $txt[0] = strtoupper($txt[0]);
          $txt[1] = strtoupper($txt[1]);
          if (isset($txt[2])) {
            $txt[2] = strtoupper($txt[2]);
          } else {
            $txt[2] = '';
          }
          if ( $dirName == "Muziek" ) {
            $value2 = $txt[0] . " - " . $txt[1];
          } else {
            $value2 = $txt[1] . " - " . $txt[2];
          }
          ?>

          <li class='<?=$key?> list' id='<?=$key?>' >
          <!-- <div class='point'></div> -->
          <img class='<?=$key?> hoes' src='<?=$filePath."/".$value?>.jpg' loading='lazy' >
          <p class='<?=$key?> txt1'><?=$value2?></p>
          <span><b class='local add' onclick='local_add(<?=$key?>)'>ADD</b></span>
          </li>

          <?php
        }
        // $search = "off";
        // $playing = "off";
      }
      ?>

    </div>
  </div>

  <script>
    let musicPath = <?= json_encode($musicPath); ?>;
    const filePath = <?= json_encode($filePath); ?>;
    let dirName = <?= json_encode($dirName); ?>;
    let songs = <?= json_encode($songs); ?>;
    let songs_array = <?= json_encode($songs_array); ?>;
    let songs_index = <?= json_encode($songs_index); ?>;
    let search_array = <?= json_encode($search_array); ?>;
    let shuffle_array = <?= json_encode($shuffle_array); ?>;
    let shuffle = <?= json_encode($shuffle); ?>;
    let search = <?= json_encode($search); ?>;
    let playing = <?= json_encode($playing); ?>;
  </script>

  <footer id="footer">
    <p class='footer_copyright'>OpaD@m © Copyright 2024. All Rights Reserved.</p>
  </footer>
</body>

</html>