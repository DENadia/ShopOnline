<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
   
<?php
session_start();
include ("connect.php");
include ("page_top.html");
$cuvant = $_GET['cuvant'];
?>
 <div class="cautare">
     <form action="search.php" method="GET">
        <input type="text" placeholder="Search.." name="cuvant">
        <input type="submit" value="Search">
      </form>
 </div> <br><br><br>
<table class="products">

    <?php
    print '<center><h2 style="color:rgb(61, 61, 61);">These are the search results for: '.$cuvant.'</h2></center>';
      $sql="SELECT id_dvd, title, director_name, price FROM dvd, directors WHERE dvd.id_director = directors.id_director AND title LIKE '%".$cuvant."%'";
      $sursa=mysqli_query($conn, $sql);
      print '<tr>';
      if (mysqli_num_rows($sursa)==0)
      {
        ?>
        <center><h2 style="color:#cc0000">No movies found!</h2></center>
       <center> <img src="images/wtf.jpg"></center>
        <?php
      }
      else{
      $repeated=-1;
        while($row=mysqli_fetch_array($sursa))
        {
            $repeated=$repeated+1;
            if($repeated%6==0)
            {
                print '</tr><tr>';
            }
            
          /* deschidem celula tabelului HTML */
          print '<td align = "center" style="width: 300px; height:400px;">' ;
          /*punem şi imaginea copertei dacă există, dacă nu,
          afişăm un layer DIV în care scriem “Fără imagine”*/
          $adrimag="images/".$row['id_dvd'].".jpg";
          /*adresa imagine va fi "c:/coperte/111.jpg" pentru cartea cu id_carte=111,
          "c:/coperte/112.jpg" pentru cartea cu id_carte=112, ...
          functia file_exists returneaza TRUE daca fisierul specificat exista */
          if(file_exists($adrimag))
          {
            // $adrimag="coperte/".$row['id_carte'].".jpg";
            print '<img src="'.$adrimag.'" width="250px" height="300px" alt="No image"><br>';
          }
          /*afisam campurile titlu, autor, pret*/
          
          print '<b><a href="dvd.php?id_dvd='.$row['id_dvd'].'">'
          .$row['title'].'</a></b>
          <br> 
          <span> by: '.$row['director_name'].'</span>
          <br>
           <span>pret: ' .$row['price'].' lei</span>
          </td>';
          /*inchidem celula <td> deschisa in while*/
        }
        
      }
      
    ?>
  </table>
<?php
  include("page_bottom.html");
?>

</body>
</html>
