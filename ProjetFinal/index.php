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

    <link rel="stylesheet" href="style/index.css">
</head>
<body style="text-align: center;background-color:#A9A9A9;">
<!--logo-->
<center>
    <div style="height:25%;width:80%;border:1px solid black;">
        <div class="logo">
			<h1>Universite Naye</h1>
        </div>
    </div>
    <!--Detail-->
    <div class="article" style="border:1px solid black;width:80%;height:auto;margin-top:5px;">
        <table>
            <tr>
                <!--forme de login-->
                <td width="50%">
                    <?php
                    //initialisation du choix avec la fonction isset
                    if(isset($_GET['choix'])){
                        //recuperation du choix par get après  Request
                        $choix=$_GET['choix'];
                        //traite le choix soit patient soit medecin soit administration
                        switch($choix)
                        {
                            case'administration';
                                include('Admin/administration.php');
                                break;
                            case'prof';
                                include('Prof/prof.php');
                                break;
                            case'etudiant';
                                include('Etudiant/etudiant.php');
                                break;
                            default;
                                include('index.php');
                        }
                    }
                    else{
                        include('login.php');
                    }
                    ?>

                </td>
            </tr>
        </table>
    </div>
</center>
</body>
</html>

