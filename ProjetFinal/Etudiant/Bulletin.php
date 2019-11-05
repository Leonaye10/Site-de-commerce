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

        $select=oci_parse($conn,"Select ML_COURS.no_cours,ML_COURS.nom_cours , ML_INSCRIPTION.note_etud  
		from ML_INSCRIPTION,ML_COURS WHERE  ML_COURS.no_cours=ML_INSCRIPTION.no_cours and codepermanent='$codepermanent'");
        oci_execute($select);
            $nbrows=oci_fetch_all($select,$resultats);
            $somme=0;
			$moyenne=0;
            echo "<table border style='background-color:#F8F8FF;border:1px solid black;width:50%;height:auto;text-align:center;'>";
			echo "<tr><td> NO COURS </td><td> COURS </td><td> Note </td></tr>";
for( $i = 0 ; $i < $nbrows ; $i++)
{
//le champ  doit être a majusqule
   // $_SESSION['codepermanent']=$resultats['CODEPERMANENT'][$i];
    $_SESSION['no_cours']=$resultats['NO_COURS'][$i];
	$_SESSION['nom_cours']=$resultats['NOM_COURS'][$i];
    $_SESSION['note_etud']=$resultats['NOTE_ETUD'][$i];
    echo"<tr style='background-color:#F0F0F0;'><td> ".$_SESSION['no_cours']." </td><td> ".$_SESSION['nom_cours']." </td><td> ".$_SESSION['note_etud']." </td></tr>";
    $somme+=$_SESSION['note_etud'];
}
	$moyenne=$somme/$nbrows;
    echo "<tr><td colspan='2'> MOYENNE </td><td style='background-color:#F0F0F0;'> ".$moyenne." </td></tr>";
    echo"</table>";
oci_close($conn);
?>

</center>
</body>
</html>