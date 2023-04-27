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

	form input[type=submit] {
		font-size: 20px;
		padding: 5px 15px;
		font-family: cursive;
		background-color: rgb(46, 107, 206);
		border: 0;
		color: white;
		border-radius: 8px;
		cursor: pointer;
	}

	form input[type=submit]:hover {
		transform: scale(1.05);
	}

	h2 {
		font-family: cursive;
		font-size: 25px;
	}

	h4 {
		font-family: cursive;
		font-size: 18px;
	}

	.continue a {
		font-family: cursive;
		font-size: 20px;
		color: black;
		text-decoration: none;
	}
</style>

<body>
	<?php
	session_start();
	include("connect.php");
	include("page_top.html");
	/* Dacă este setată variabila $_GET[‘actiune’] şi valoarea acesteia este "adaugă", se
	execută următorul cod: */
	if (!isset($_GET['actiune'])) {
		// print '<center><h4>nu ai adaugat nimic in cos</h4></center>';
		print '<center><h2>Shopping Cart</h2></center>
		<form action="shopping.php?actiune=modifica" method="POST">
			<center><table class="shopping-cart" >
			<tr bgcolor="#F9F1E7">
				<th align="center"><b>No_items</b></th>
				<th align="center"><b>Dvd </b></th>
				<th align="center"><b>Price </b></th>
				<th align="center"><b>Total </b></th>
			</tr>';
		$totalGeneral = 0;
		if (!isset($_SESSION['id_dvd'])) {
			print '<center><h3>Still nothing in your cart</h3></center>';
			print '<center><h4><a href="index.php" style=" font-weight:bold; color:black; text-decoration:none">Back to shopping</a></h4></center>';
			exit;
		} else {
			for ($i = 0; $i < count($_SESSION['id_dvd']); $i++) {
				/*doar daca numarul de bucati nu este 0, afiseaza randul*/
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
			print '<tr>
			<td align="right" colspan="3"><b>Total in cos</b></td>
			<td align="right"><b>' . $totalGeneral . '</b> lei</td>
			</tr>';

			print '</table>
			<input type="submit" value="Update">
		</form>';
		}
	} else {
		if (isset($_GET['actiune']) && $_GET['actiune'] == "adauga") {
			$_SESSION['id_dvd'][] = $_POST['id_dvd'];
			$_SESSION['nr_buc'][] = 1;
			$_SESSION['price'][] = $_POST['price'];
			$_SESSION['title'][] = $_POST['title'];
			$_SESSION['director_name'][] = $_POST['director_name'];
		}
		/* Dacă este setată variabila $_GET[‘actiune’] şi valoarea acesteia este „Modifica", se execută
		următorul cod: */
		if (isset($_GET['actiune']) && $_GET['actiune'] == "modifica") {
			for ($i = 0; $i < count($_SESSION['id_dvd']); $i++) {
				$_SESSION['nr_buc'][$i] = $_POST['noulNrBuc'][$i];
			}
		}

		print '<center><h2>Shopping Cart</h2></center>
		<form action="shopping.php?actiune=modifica" method="POST">
			<center><table class="shopping-cart" >
			<tr bgcolor="#F9F1E7">
				<th align="center"><b>No_items</b></th>
				<th align="center"><b>Dvd </b></th>
				<th align="center"><b>Price </b></th>
				<th align="center"><b>Total </b></th>
			</tr>';
		$totalGeneral = 0;
		for ($i = 0; $i < count($_SESSION['id_dvd']); $i++) {
			if ($_SESSION['nr_buc'][$i] != 0) {
				/*doar daca numarul de bucati nu este 0, afiseaza randul*/
				print '<tr>
				<td><input type="number" min=0 name="noulNrBuc[' . $i . ']" size="1"
				value="' . $_SESSION['nr_buc'][$i] . '"></td>
				<td><b>' . $_SESSION['title'][$i] . '</b> de:
				' . $_SESSION['director_name'][$i] . '</td>
				<td align="right">' . $_SESSION['price'][$i] . ' lei</td>
				<td align="right">' . ($_SESSION['nr_buc'][$i] * $_SESSION['price'][$i]) . ' lei </td>
				</tr>';
				$totalGeneral = $totalGeneral + ($_SESSION['nr_buc'][$i] * $_SESSION['price'][$i]);
			} else {
				// stergem din tabel inregistrarile care au nr_buc=0
				unset($_SESSION['nr_buc'][$i]);
				$_SESSION['nr_buc'] = array_values($_SESSION['nr_buc']);

				unset($_SESSION['id_dvd'][$i]);
				$_SESSION['id_dvd'] = array_values($_SESSION['id_dvd']);

				unset($_SESSION['title'][$i]);
				$_SESSION['title'] = array_values($_SESSION['title']);

				unset($_SESSION['price'][$i]);
				$_SESSION['price'] = array_values($_SESSION['price']);

				unset($_SESSION['director_name'][$i]);
				$_SESSION['director_name'] = array_values($_SESSION['director_name']);
				$i = $i - 1;
			}
		}

		//afisam totalul general
		print '<tr>
		<td align="right" colspan="3"><b>Total in cos</b></td>
		<td align="right"><b>' . $totalGeneral . '</b> lei</td>
		</tr>';

		print '</table></center>
		<center><input type="submit" value="Update"></center>
	</form>';
	}

	print '<br><br>
	<center><table class="continue">
		<tr>
			<td width="300" align="center">
			<a href="index.php"> Back to shopping</a></td>
			<td width="300" align="center">
			<a href="checkout.php">Finalize order</a></td>
		</tr>
	</table></center>';
	include("page_bottom.html");
	?>
</body>

</html>