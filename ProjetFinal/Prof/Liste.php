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
    

    <div class="article" style="border:1px solid border;width:80%;">
        <div>

            <?php
            $no_prof=$_SESSION['no_prof'];
            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

            $select=oci_parse($conn,"Select ML_ETUDIANT.nom_etud, ML_ETUDIANT.codepermanent, ML_COURS.nom_cours,ML_COURS.no_cours from ML_INSCRIPTION,ML_ETUDIANT,ML_COURS WHERE ML_ETUDIANT.codepermanent=ML_INSCRIPTION.codepermanent and ML_INSCRIPTION.no_cours=ML_COURS.no_cours and no_prof='$no_prof'");
            oci_execute($select);

            $nbrows=oci_fetch_all($select,$resultats);
            echo "<h3>Voici les éleves et les Cours que vous enseignez</h3>";
			echo "<table border style='border:1px solid border;width:60%;height:auto;text-align:center;background-color:#F8F8FF';>";
			echo "<tr><td> CODE PERMANENT </td><td> NOM ETUDIANT </td><td> NO COURS </td><td> COURS </td></tr>";
            for( $i = 0 ; $i < $nbrows ; $i++)
            {//le champ  doit être a majusqul

                echo"<tr style='background-color:#F0F0F0';><td> ".$resultats['CODEPERMANENT'][$i]." </td><td> ".$resultats['NOM_ETUD'][$i]." </td><td> ".$resultats['NO_COURS'][$i]." </td><td> ".$resultats['NOM_COURS'][$i]." </td></tr> ";

            }
			echo "</table>";
            oci_close($conn);
            ?>

        </div>

    </div>
</center>
</body>
</html>