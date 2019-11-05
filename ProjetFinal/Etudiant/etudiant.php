<?php
if(!session_id())
{
	session_start();
} 

//recuperation des donnnées du login et password par post
$_SESSION['loginEt']=$_REQUEST['codeper'];
$_SESSION['mdpEt']=$_REQUEST['password'];


//connexion avec oracle
$conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
//requête sql oci_parse() selection;
$select = oci_parse($conn,"Select * from ML_ETUDIANT WHERE codepermanent='".$_SESSION['loginEt']."' and password='".$_SESSION['mdpEt']."'");

// executer aql oci execute
oci_execute($select);

$nbr=oci_fetch_all($select,$resulta);

//note simulation d'echec ou de reussite
if($nbr>0)
{
    $_SESSION['nom_etud']=$resulta['NOM_ETUD'][0];
    $_SESSION['prenom_etud']=$resulta['PRENOM_ETUD'][0];
    $_SESSION['login']=$resulta['LOGIN'][0];
    $_SESSION['password']=$resulta['PASSWORD'][0];
    $_SESSION['codepermanent']=$resulta['CODEPERMANENT'][0];
    header('location:Etudiant/index.php');
}

else
{
    include('login.php');
    echo 'Login et / ou Mot de passe incorrect!';
}
oci_close($conn);
?>