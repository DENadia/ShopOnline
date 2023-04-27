<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .shopping-cart {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    .shopping-cartrs td,
    .shopping-cart th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .shopping-cart tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .shopping-cart tr:hover {
        background-color: #ddd;
    }

    .shopping-cart td {
        font-family: cursive;
    }

    .shopping-cart th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: rgb(46, 107, 206);
        color: white;
    }
    h2 {
        font-family: cursive;
        font-size: 25px;
    }

    h4 {
        font-family: cursive;
        font-size: 18px;
    }
    #order  input[type=text], textarea{
    background-color: rgb(245, 245, 245);
    border-radius: 12px;
    border: 0;
    box-sizing: border-box;
    font-size: 18px;
    padding: 4px 20px 0;
    width: 200px;
    }
    #order label{
    color: rgb(18, 89, 204);
    font-family: cursive;
    font-size: 20px;
    font-weight: 600;
    margin-top: 10px;
    }
    #order input[type=submit] {

font-size: 20px;
padding: 5px 15px;
font-family: cursive;
background-color: rgb(46, 107, 206);
border: 0;
color: white;
border-radius: 8px;
cursor: pointer;
}

#order input[type=submit]:hover {
transform: scale(1.05);
}

</style>

<body>
    <?php
    session_start();
    include("connect.php");
    include("page_top.html");
    print '<center><h2>Shopping Cart</h2></center>
			<center><table class="shopping-cart" >
			<tr bgcolor="#F9F1E7">
				<th align="center"><b>No_items</b></th>
				<th align="center"><b>Dvd </b></th>
				<th align="center"><b>Price </b></th>
				<th align="center"><b>Total </b></th>
			</tr>';
    $totalGeneral = 0;
    for ($i = 0; $i < count($_SESSION['id_dvd']); $i++) {
        print '<tr>
				<td><input type="text" name="noulNrBuc[' . $i . ']" size="1"
				value="' . $_SESSION['nr_buc'][$i] . '"></td>
				<td><b>' . $_SESSION['title'][$i] . '</b> de:
				' . $_SESSION['director_name'][$i] . '</td>
				<td align="right">' . $_SESSION['price'][$i] . ' lei</td>
				<td align="right">' . ($_SESSION['nr_buc'][$i] * $_SESSION['price'][$i]) . ' lei </td>
				</tr>';
        $totalGeneral = $totalGeneral + ($_SESSION['nr_buc'][$i] * $_SESSION['price'][$i]); 
    }
    //afisam totalul general
    print '<tr>
		        <td align="right" colspan="3"><b>Total in cos</b></td>
		        <td align="right"><b>' . $totalGeneral . '</b> lei</td>
		    </tr>
            </table></center>';

    print '<center>
            <h4>Numele şi adresa unde doriţi să primiţi cărţile cumpărate:</h4></center>
            <center><div id="order"><form action="load.php" method="POST" >
             <label for="name">Numele:</label>
             <input type="text" name="name" id="name" required><br><br>
             <label for="adress">Adresa:</label>
             <textarea name="adresa" rows="6" id="adress" required></textarea><br>
            <input type="submit" value="Send">
        </form></div></center><br><br>';

    include("page_bottom.html");
    ?>
</body>

</html>