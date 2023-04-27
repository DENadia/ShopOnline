<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
  .review {
    display: grid;
    grid-template: 100%/50% 50%;
  }

  .container {
    margin-left: 20px;
    background-color: rgb(208, 222, 228);
    border-radius: 20px;
    box-sizing: border-box;
    height: 250px;
    padding: 20px;
    width: 500px;
    grid-column: 1;
  }

  .container input,
  textarea {
    background-color: rgb(245, 245, 245);
    border-radius: 12px;
    border: 0;
    box-sizing: border-box;
    font-size: 18px;
    height: 100%;
    padding: 4px 20px 0;
    width: 100%;
  }

  .container label {
    color: rgb(18, 89, 204);
    font-family: cursive;
    font-size: 20px;
    font-weight: 600;
    margin-top: 10px;
  }

  .container button {
    background-color: rgb(18, 89, 204);
    border-radius: 12px;
    border: 0;
    box-sizing: border-box;
    color: #eee;
    cursor: pointer;
    font-size: 18px;
    height: 30px;
    margin-top: 15px;
    text-align: center;
    margin-left: 0;
    width: 100%;
  }

  .container button:hover {
    background-color: rgb(5, 60, 150);
    transform: scale(1.05);
  }

  .comments h3 {
    color: rgb(18, 89, 204);
    text-transform: uppercase;
    font-family: cursive;
    font-size: 25px;
  }

  .comments a {
    color: black;
    font-size: 20px;
    font-weight: bold;
    font-style: italic;
  }

  .comments a:after {
    color: black;
    font-weight: bold;
  }

  .comments {
    font-size: 20px;
  }

  .submit {
    background-color: rgb(18, 89, 204);
    border-radius: 12px;
    border: 0;
    box-sizing: border-box;
    color: #eee;
    cursor: pointer;
    font-size: 15px;
    margin-top: 15px;
    text-align: center;
    width: 100px;
    height: 30px;
  }

  .submit:hover {
    background-color: rgb(5, 60, 150);
    transform: scale(1.05);
  }
</style>

<body>
  <?php
  session_start();
  include("connect.php");
  include("page_top.html");
  $id_dvd = $_GET['id_dvd'];
  ?>

  <table class="products">
    <?php
    $sql = "SELECT id_dvd, title, director_name, descr, price FROM dvd, directors WHERE id_dvd=" . $id_dvd . " AND dvd.id_director = directors.id_director";
    $sursa = mysqli_query($conn, $sql);
    print '<tr>';
    while ($row = mysqli_fetch_array($sursa)) {
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
          <br>
          <form action="shopping.php?actiune=adauga" method="POST">
            <input type="hidden" name="id_dvd" value="' . $id_dvd . '">
            <input type="hidden" name="title" value="' . $row['title'] . '">
            <input type="hidden" name="director_name" value="' . $row['director_name'] . '">
            <input type="hidden" name="price" value="' . $row['price'] . '">
            <input type="submit" value="Buy it now!" class="submit">
          </form>
          </td><td> <span style="font-weight:lighter; font-size:20px;">' . $row['descr'] . '</span>
          </td></tr>';
    }

    ?>
  </table>
  <br>
  <div class="review">
    <div class="container">
      <form action="review.php" method="POST">
        <label for="user_name"> User Name:</label>
        <input type="text" name="user_name" id="user_name" required>
        <label for="email"> Email:</label>
        <input type="text" name="email" id="email" required>
        <label for="review"> Your review:</label>
        <textarea name="review" id="review" cols="45" required></textarea>
        <input type="hidden" name="id_dvd" value="<?= $id_dvd ?>">
        <button type="text">Submit</button>
      </form>
    </div>
    <div class="comments">
      <h3>Reviews</h3>
      <?php
      $sqlComent = "SELECT * FROM reviews WHERE id_dvd =" . $id_dvd;
      $sursaComent = mysqli_query($conn, $sqlComent);
      while ($row = mysqli_fetch_array($sursaComent)) {
        print '
		<a href="mailto : ' . $row['email'] . ' "> '
          . $row['user_name'] . '</a><br>'
          . $row['review'] . '<br><br>';
      }
      ?>
    </div>
  </div>
  <br>

  <?php
  include("page_bottom.html");
  ?>

</body>

</html>