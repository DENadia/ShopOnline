<?php
/*Verificăm dacă numele este completat iar dacă nu e, oprim execuţia scriptului*/
if($_POST['nume'] == "")
{
	print 'Trebuie să completaţi numele!<a href="cos.php">inapoi</a>';
}else{
	print 'numele introdus in caseta este: '.$_POST['nume'].'<br>';
}
/*Verificăm dacă adresa e completata iar dacă nu e, oprim execuţia scriptului*/
if($_POST['adresa'] == "")
{
	print 'Trebuie să completaţi adresa!<a href="cos.php">inapoi</a>';
}else{
	print 'numele introdus in caseta este: '.$_POST['adresa'].'<br>';
}

/* Reiniţializăm sesiunea deoarece dorim să verificăm numărul de cărţi comandate */
session_start();
/*numărul de cărţi comandate il aflăm folosind array.sum.array_sum($array} returnează suma
valorilor dintr-un array dacă acestea sunt numerice. Astfel, dacă $a = array[‘1’,’1’,’2’],
array_sum($a)=4. A nu se confunda array_sum cu count: count($a) = 3 elemente in timp ce
array_sum($a)=4 calculează suma elementelor.*/

$nrCarti = array_sum($_SESSION['nr_buc']);
if($nrCarti = 0)
{
	print 'Trebuie să cumpăraţi cel puţin o carte!
	<a href="cos.php">inapoi</a>';
	exit;
}
/* in acest moment toate datele sunt verificate, putem să ne conectăm la baza de date pentru a le
introduce: */
include('conectare.php');

/* Introducem intâi datele in tabelul tranzacţii. Deoarece câmpul data din tabel este de tip
TIMESTAMP, il putem omite (se va seta singur, cu data curentă) */
$sqlTranzactie = "INSERT INTO tranzactii (nume_cump, adr_cump)
VALUES('".$_POST['nume']."', '".$_POST['adresa']."')";
$resursaTranzactie = mysqli_query($conn, $sqlTranzactie);
/* Obţinem id_ul acestei inregistrări folosind mysql_insert_id: */
$id_tranzactie = mysqli_insert_id($conn);
/* iar acum luăm fiecare carte din sesiune şi o introducem in tabelul vânzări. Introducem in tabel
doar cărţile al căror număr de bucăţi este mai mare ca 0 (regăsită in condiţia if, din cadrul
structurii for): */
for($i=0; $i<count($_SESSION['id_carte']); $i++)
{
	if($_SESSION['nr_buc'][$i] > 0)
	{
		/* Creăm interogarea */
		$sqlVanzare = "INSERT INTO vanzari (id_tranz, id_carte, nr_buc) VALUES('".$id_tranzactie."','".
		$_SESSION['id_carte'][$i]."','".
		$_SESSION['nr_buc'][$i]."')";
		/* şi o rulăm */
		mysqli_query($conn, $sqlVanzare);
	}
}

/* Urmează sa trimitem un email de notificare folosind funcţia mail.
mail foloseşte in principal trei argumente: mail:
- adresa destinatarului,
- subiectul mesajului,
- textul mesajului, dar mai poate prelua unul pentru headere adiţionale;
*/
$emailDestinatar = "unemail@yahoo.com";
/* schimbaţi adresa cu cea la care doriţi să primiţi mesajele */
$subiect = "O nouă comandă!";
/* Pentru a compune mesajul ne vom folosi de operatorul ”.=” de concatenare a stringurilor. */
print $_P0ST['nume'].'<br> ceva<br>';
$mesaj = "O nouă comandă de la <b>".$_P0ST['nume']."</b><br>";
$mesaj .= "Adresa:".$_P0ST['adresa']."<br>";
$mesaj .= "Cărţile comandate: <br><br>";
$mesaj .= "<table border='1' cellspacing='0' cellpadding='4'>";
$totalGeneral =0;
for ($i=0;$i < count($_SESSION['id_carte']) ; $i++)
{
	if($_SESSION['nr_buc'][$i] > 0) 
	{
		$mesaj .= "<tr><td>".$_SESSI0N['titlu'][$i]." ".$_SESSION['autor'] [$i].
		"</td><td>".$_SESSION['nr_buc'][$i]. "buc</td></tr>";
		$totalGeneral = $totalGeneral + ($_SESSION['nr_buc'][$i] * $_SESSION['pret'][$i]);
	}
}
$mesaj .= "</table>";
$mesaj .= "Total:<b>".$totalGeneral."</b>";
/* putem pune diacritice in cadrul unui string insă pentru ca browserul să le afişeze corect va
trebui să specificăm in <head> setul de caractere folosit, la fel ca intr-un document HTML.
Punem headere adiţionale pentru a trimite mesajul in format HTML şi encodingul potrivit pentru
caractere’ romaneşti: */
$headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-2\r\n";
/* conditiile fiind indeplinite putem trimite emailul: */
mail($emailDestinatar, $subiect, $mesaj, $headers);
/* Curăţăm sesiunea deoarece nu mai avem nevoie de datele din ea.*/
session_unset() ;
/* eliminăm toate variabilele asociate acestei sesiuni */
session_destroy();
/* ştergem sesiunea si in final afişăm utilizatorului pagina cu mesajul de mulţumire: */
include("page_top.php");
include("meniu.php");
?>
<!-- <td valign="top"> -->
<h1>Multumim!</h1>
Va multumim ca aţi cumpărat de la noi! Veţi primi comanda solicitata in cel mai scurt timp.
<!-- </td> -->
<?php
	include("page_bottom.php");
?>