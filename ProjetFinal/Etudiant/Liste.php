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

    <div class="article" style="border:1px solid black;width:80%;height:auto;margin-top:5px;">

            <?php
            $codepermanent=$_SESSION['codepermanent'];

            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

            $select=oci_parse($conn,"Select ML_COURS.nom_cours,ML_COURS.no_cours,ML_INSCRIPTION.codepermanent from ML_INSCRIPTION,ML_COURS WHERE ML_COURS.no_cours=ML_INSCRIPTION.no_cours and codepermanent='$codepermanent'");
            oci_execute($select);

            $nbrows=oci_fetch_all($select,$resultats);
			echo "<table border style='background-color:#F8F8FF;border:1px solid black;width:50%;height:auto;margin-top:5px;text-align:center;'>";
			echo "<tr><td> CODE PERMANENT </td><td> NO COURS </td><td> COURS </td></tr>";
            for( $i = 0 ; $i < $nbrows ; $i++)
            {//le champ  doit être a majusqule
                $_SESSION['codepermanent']=$resultats['CODEPERMANENT'][$i];
                $_SESSION['no_cours']=$resultats['NO_COURS'][$i];
                $_SESSION['nom_cours']=$resultats['NOM_COURS'][$i];

                echo "<tr style='background-color:#F0F0F0';><td> ". $_SESSION['codepermanent']." </td><td> ".$_SESSION['no_cours']." </td><td> ".$_SESSION['nom_cours']." </td></tr>";

            }
			echo "</table>";
            oci_close($conn);
            ?>
	</div>
</center>
</body>
</html>