<?php
if(!session_id())
{
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../style/index.css">
</head>
<body style="text-align: center;">

<center>
   
    <div class="article">
        <div>
            <?php
            $codepermanent=$_SESSION['codepermanent'];

            //connexion avec oracle
            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
            //requête sql oci_parse() selection;

            $select=oci_parse($conn,"Select no_cours , prix_cours , rabais  from ML_INSCRIPTION WHERE codepermanent='$codepermanent'");

            oci_execute($select);
            $nbrows=oci_fetch_all($select,$resultats);
            $somme=0;
            $rabais=0;
			echo "<table border style='background-color:#F8F8FF;border:1px solid black;width:50%;height:auto;text-align:center;'>";
			echo "<tr><td> NO COURS </td><td> PRIX </td><td> RABAIS </td></tr>";
            for( $i = 0 ; $i < $nbrows ; $i++)
            {
//le champ  doit être a majusqule
                // $_SESSION['codepermanent']=$resultats['CODEPERMANENT'][$i];
                $_SESSION['no_cours']=$resultats['NO_COURS'][$i];
                $_SESSION['prix_cours']=$resultats['PRIX_COURS'][$i];
                $_SESSION['rabais']=$resultats['RABAIS'][$i];
				
				echo"<tr style='background-color:#F0F0F0;'><td> ".$_SESSION['no_cours']." </td><td> ".$_SESSION['prix_cours']." </td><td> ".$_SESSION['rabais']." </td></tr>";
              
                $somme+=$_SESSION['prix_cours'];
                $rabais +=$_SESSION['rabais'];

            }
            $stotal=$somme-$rabais;
            $taxe = ($somme - $rabais)*0.05;
            $taxetps = ($somme - $rabais)*0.09975;
            $total = ($somme-$rabais) + $taxe + $taxetps;

		echo "<tr><td colspan='2'> Sous total </td><td style='background-color:#F0F0F0;'> ".$stotal." </td></tr>";
		echo "<tr><td colspan='2'> Taxe </td><td style='background-color:#F0F0F0;'> ".$taxe." </td></tr>";
		echo "<tr><td colspan='2'> TVQ </td><td style='background-color:#F0F0F0;'> ".$taxetps." </td></tr>";
		echo "<tr><td colspan='2'> Total </td><td style='background-color:#F0F0F0;'> ".$total." </td></tr>";
		echo"</table>";
            
            oci_close($conn);
            ?>

</center>
</body>
</html>