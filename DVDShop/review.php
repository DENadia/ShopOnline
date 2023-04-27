<?php
include("connect.php");
/*folosim din motive de securitate functia strip_tags pentru a elimina tagurile HTML si
PHP din toate stringurile trimise de utilizator. E bine sa folosim aceasta functie pentru a
"curata" inputul utilizatorilor de orice cod potential rauvoitor */
$nume = strip_tags($_POST['user_name']);
$email = strip_tags($_POST['email']);
$coment = strip_tags($_POST['review']);
$sql = "INSERT INTO reviews
	(id_dvd, user_name, email, review)
	VALUES(" . $_POST['id_dvd'] . ",'" . $nume . "','" . $email . "','" . $coment . "')";
mysqli_query($conn, $sql);
/* redirectionam utilizatorul catre pagina cartii la care a adaugat un comentariu */
$inapoi = "dvd.php?id_dvd=" . $_POST['id_dvd'];
$id_dvd = $_POST['id_dvd'];
header("location: $inapoi");
