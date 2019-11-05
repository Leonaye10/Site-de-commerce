<?php
if(!session_id())
{
	session_start();
}
//recuperation des données $_REQUEST
$_SESSION['loginPr']=$_REQUEST['numprof'];
$_SESSION['mdpPr']=$_REQUEST['password'];

//connecté avec oci_connect
$conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

//requete sql oci_parse()
$select = oci_parse($conn,"Select * from ML_PROF WHERE no_prof='".$_SESSION['loginPr']."' and password='".$_SESSION['mdpPr']."'");

//executer sql
oci_execute($select);

$nbr=oci_fetch_all($select,$resulta);

//annalyse et affiche des resultats

if($nbr>0)
{
    $_SESSION['no_prof']=$resulta['NO_PROF'][0];
    $_SESSION['nom_prof']=$resulta['NOM_PROF'][0];
	$_SESSION['tel_prof']=$resulta['TEL_PROF'][0];
    $_SESSION['password']=$resulta['PASSWORD'][0];

    header('location:Prof/indexe.php');
}

else
{
    include('login.php');
    echo 'Login et / ou Mot de passe incorrect!';
}
//fermeture avec oci_close
oci_close($conn);
?>