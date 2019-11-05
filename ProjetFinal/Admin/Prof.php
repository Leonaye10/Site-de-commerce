<?php
if(!session_id())
{
	session_start();
} 
?>
<center>

<table style="width:80%;">
    <tr style="background-color:#ECF1EF;text-align:center;">
        <td style="padding:20px;border-radius:25px;"><h3>Ajouter un professeur</h3>
            <form method="post" action="index.php?choix=prof">
                <table>
                    <tr><td>Nom : </td><td><input name="nom" value=""></td></tr>
					<tr><td>Telephone : </td><td><input name="tel" value=""></td></tr>
					<tr><td>Mot de passe : </td><td><input name="password" value=""></td></tr>
                    <tr><td><input type="submit" name="ajouterPr" value="Ajouter un professeur"></td></tr>
                </table>
            </form>
            
        <?php
        if(isset($_REQUEST['ajouterPr']))
        {
				$nom_prof = $_REQUEST['nom'];
                $tel_prof = $_REQUEST['tel'];
                $password = $_REQUEST['password'];
            //connection avec oracle 2
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                //verification si id auto né pas vide
                if(!empty($nom_prof))
                {
                    //insertion 3
                    $insertion= oci_parse($conn,"insert into ML_PROF(no_prof,nom_prof,tel_prof,password)
               values(SUBSTR('$nom_prof',0,3)||seq_prof.NEXTVAL,'$nom_prof','$tel_prof','$password')");
                    //execution
                    oci_execute($insertion);
                    oci_commit($conn);
                    //analyse 5
                    $row = oci_num_rows($insertion);
                    if($row>0)
                    {
                        echo 'Insertion reussi';
                    }
                    else
                    {
                        echo 'Echec';
                    }
                }
                else
                {
                    echo'Veuillez remplir le champs id';
                }
        }
        ?>
		</td>
		<td style="padding:20px;border-radius:25px;">
        <h3>Modifier un professeur</h3>
            <form method="post" action="index.php?choix=prof">
                Numero du prof :
                <table>
                    <tr>
						<select name="noprof">
                        <?php
                            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select no_prof from ML_PROF");

                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $code=$resultats['NO_PROF'][$i];
                        echo "<option value='$code'>$code</option>";
                    }
                    oci_close($conn);
                        ?>
                        </select></tr>
                    <tr><input type="submit" name="ChercherPr" value="Chercher un professeur"></tr>
                </table>
            </form>
                  <?php
            //recuperation des données
            //initialisation de la variable choix avec la fonction isset
            if(isset($_REQUEST['ChercherPr']))
            {
                $choix= $_REQUEST['noprof'];
                //connexion avec oracle
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //requête sql
                $update = oci_parse($conn,"Select * from ML_PROF WHERE no_prof='$choix'");

                //excution de la requête
                oci_execute($update);
                //analyse et affichage des resulta
                $nbrows=oci_fetch_all($update,$resultats);
                echo "<form method='post' action='index.php?choix=prof'>";
				echo "<table>";

                for( $i = 0 ; $i < $nbrows ; $i++)
                {//le champ idauto doit être a majusqule
                    $nom_prof = $resultats['NOM_PROF'][$i];
                    $tel_prof = $resultats['TEL_PROF'][$i];
                    $password = $resultats['PASSWORD'][$i];

					echo "<tr>";                  
                    echo "<td>Nom :</td><td><input type='text' name='nom_prof' value= '$nom_prof'></td></tr>";
                    echo "<td>Telephone :</td><td><input type='text' name='tel_prof' value= '$tel_prof'></td></tr>";
                    echo "<td>Mot de passe :</td><td><input type='password' name='password' value= '$password'></td></tr>";
					echo "</table>";
                }
                echo "<input type='submit' name='ok' value='ok'></form>";
            }
            if(isset($_REQUEST["ok"]))
            {
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //recuperation

                $nom_prof = trim($_REQUEST['nom_prof']);
                $tel_prof = $_REQUEST['tel_prof'];
                $password = $_REQUEST['password'];

                $misajour = oci_parse($conn,"UPDATE ML_PROF set nom_prof='$nom_prof',tel_prof='$tel_prof',password='$password' WHERE no_prof='$code'");

                oci_execute($misajour);
                oci_commit($conn);
                //analyse des resultat de la requête
                $rows=oci_num_rows($misajour);
                if($rows >0)
                {
                    echo 'Mise a jour reussie ';
                }
                else
                {
                    echo 'Echec';
                }
                //fermeture de la connexion
                oci_close($conn);
            }

            ?>
		</td>
		</tr>
		<tr style="background-color:#ECF1EF;text-align:center;width:100%;">
		<td colspan="2"; style="padding:20px;border-radius:25px;">
  

        <h3>Supprimer un professeur</h3>
<form method="post" action="index.php?choix=prof">
    No serie :
    <table>
    <tr><select name="supp">
        <?php    
            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select no_prof from ML_PROF");
                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $no_prof=$resultats['NO_PROF'][$i];
                        echo "<option value='$no_prof'>$no_prof</option>";
                    }
                    oci_close($conn);
        ?>
    </select></tr>
    <tr><input type="submit" name="SupprimerPr" value="Supprimer cet professeur"></tr>
        </table>
</form>
            <?php
            //recuperation et initialisation  de requête
            if(isset($_REQUEST['SupprimerPr']))
            {
                $choix = $_REQUEST['supp'];
                //connexion
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                $delete=oci_parse($conn,"Delete FROM ML_PROF WHERE no_prof='$choix'");

                oci_execute($delete);
                $nbrows=oci_num_rows($delete);
                if($nbrows>0)
                {
                    echo "suppresion reussi";
                }

                else
                {
                    echo "Echec de suppresion";

                }
                oci_close($conn);
            }
            ?>
        </td>
    </tr>
</table>
</center>       

