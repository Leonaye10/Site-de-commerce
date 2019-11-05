<?php
if(!session_id())
{
	session_start();
} 
//recuperation des données $_REQUEST
$_SESSION['loginAd']=$_REQUEST['login'];
$_SESSION['mdpAd']=$_REQUEST['password'];

//connecté avec oci_connect
$conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

//requete sql oci_parse()
$select = oci_parse($conn,"Select * from ML_ADMIN WHERE login='".$_SESSION['loginAd']."' and password='".$_SESSION['mdpAd']."'");

//executer sql
oci_execute($select);

$nbr=oci_fetch_all($select,$resulta);

//annalyse et affiche des resultats

if($nbr>0)
{
    header('location:Admin/index.php');
}

else
{
    include('login.php');
    echo 'Login et / ou Mot de passe incorrect!';
}
//fermeture avec oci_close
oci_close($conn);
?>