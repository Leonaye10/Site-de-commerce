<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">

    <title></title>
    <link rel="stylesheet" href="../style/index.css">
</head>
<body style="text-align: center;margin-left:1px;background-color:#A9A9A9;">
<!--logo-->

<center>

    <div style="height:25%;width:80%;border:2px solid black;">
        <div class="logo">
			<h1>Universite Naye</h1>
			<h3><?php echo "Bonjour " .$_SESSION['loginAd']; ?></h3>
        </div>

        <nav>
            <ul>
                <li style="display: inline"><a class="item-menu" href="../index.php">Acceuil</a></li>
                <li style="display: inline;margin-left:50px "><a class="item-menu" href="index.php?choix=etud">Etudiant</a></li>
                <li style="display: inline;margin-left:50px"><a class="item-menu" href="index.php?choix=prof">Professeur</a></li>
                <li style="display: inline;margin-left:50px"><a class="item-menu" href="index.php?choix=cours">Cours</a></li>
				<li style="display: inline;margin-left:50px"><a class="item-menu" href="index.php?choix=inscription">Inscription</a></li>
            </ul>

        </nav>
    </div>
</center>
</body>
</html>

<?php
//echo 'bonjour bien venu sur la page des Medecins';
if(isset($_REQUEST['choix']))
{
    $choix=$_REQUEST['choix'];
    switch($choix)
    {
        case'etud';
            include("Etudiant.php");
            break;
        case'prof';
            include("Prof.php");
            break;
        case'cours';
            include("Cours.php");
            break;
		case'inscription';
            include("Inscription.php");
            break;
        default:
            echo "Bienvenue admin";
    }
}
?>