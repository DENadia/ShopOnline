<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
 .domains{
    background-color:rgb(141, 184, 255);
    display:grid;
    grid-template:100%/repeat(8,12.5%);
  }
  .domains a{
    padding:6px;
    color:black;
    font-family: cursive;
    font-size:25px;
    text-decoration: none;
    border-radius:5px;
  }
  .domains a:hover{
    color:white;
  }
  .horror{
    grid-column:1;
  }
  .romance{
    grid-column:2;
  }
  .action{
    grid-column:3;
  }
  .sci-fi{
    grid-column:4;
  }
  .drama{
    grid-column:5;
  }
  .comedy{
    grid-column:6;
  }
  .mystery{
    grid-column:7;
  }
  .thriller{
    grid-column:8;
  }
  </style>
<body>

  <?php
  session_start();
  include("connect.php");
  include("page_top.html");
  ?>
  <button class="buy"><a href="shopping.php"><img src="images/cart.png"></a></button>
  <div class="cautare">
    <form action="search.php" method="GET">
      <input type="text" placeholder="Search.." name="cuvant">
      <input type="submit" value="Search">
    </form>
  </div> <br>
  <br>
  <center><div class="domains">
 <div class="horror"><h3><a href="horror.php">Horror</a></h3></div>
 <div class="romance"><h3><a href="romance.php">Romance</a></h3></div>
 <div class="action"><h3><a href="action.php">Action</a></h3></div>
 <div class="sci-fi"><h3><a href="sci-fi.php">Sci-fi</a></h3></div>
 <div class="drama"><h3><a href="drama.php">Drama</a></h3></div>
 <div class="comedy"><h3><a href="comedy.php">Comedy</a></h3></div>
 <div class="mystery"><h3><a href="mystery.php">Mystery</a></h3></div>
 <div class="thriller"><h3><a href="thriller.php">Thriller</a></h3></div></div></center>
  <table class="products">
    <?php
    $sql = "SELECT id_dvd, title, director_name, price FROM dvd, directors WHERE dvd.id_director = directors.id_director AND dvd.id_domain='114'";
    $sursa = mysqli_query($conn, $sql);
    $repeated = -1;
    print '<tr>';
    while ($row = mysqli_fetch_array($sursa)) {
      $repeated = $repeated + 1;
      if ($repeated % 6 == 0) {
        print '</tr><tr>';
      }

      /* deschidem celula tabelului HTML */
      print '<td align = "center" style="width: 300px; height:400px;">';
      /*punem şi imaginea copertei dacă există, dacă nu,
          afişăm un layer DIV în care scriem “Fără imagine”*/
      $adrimag = "images/" . $row['id_dvd'] . ".jpg";
      /*adresa imagine va fi "c:/coperte/111.jpg" pentru cartea cu id_carte=111,
          "c:/coperte/112.jpg" pentru cartea cu id_carte=112, ...
          functia file_exists returneaza TRUE daca fisierul specificat exista */
      if (file_exists($adrimag)) {
        // $adrimag="coperte/".$row['id_carte'].".jpg";
        print '<img src="' . $adrimag . '" width="250px" height="300px" alt="No image"><br>';
      }
      /*afisam campurile titlu, autor, pret*/

      print '<b><a href="dvd.php?id_dvd=' . $row['id_dvd'] . '">'
        . $row['title'] . '</a></b>
          <br> 
          <span> by: ' . $row['director_name'] . '</span>
          <br>
           <span>pret: ' . $row['price'] . ' lei</span>
          </td>';
      /*inchidem celula <td> deschisa in while*/
    }

    ?>
  </table>
  <?php
  include("page_bottom.html");
  ?>
</body>

</html>