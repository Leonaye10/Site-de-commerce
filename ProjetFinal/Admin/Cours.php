<?php
if(!session_id())
{
	session_start();
} 
?>
<center>

<table style="width:80%;">
    <tr style="background-color:#ECF1EF;text-align:center;">
        <td style="padding:20px;border-radius:25px;"><h3>Ajouter un etudiant</h3>
            <form method="post" action="index.php?choix=cours">
                <table>
					<tr><td>Numero de cours : </td><td><input name="numcrs" value=""></td></tr>
                    <tr><td>Nom : </td><td><input name="nom" value=""></td></tr>
					<tr><td>Description : </td><td><input name="desc" value=""></td></tr>
                    <tr><td><input type="submit" name="ajouterC" value="Ajouter un cours"></td></tr>
                </table>
            </form>
            
        <?php
        if(isset($_REQUEST['ajouterC']))
        {
				$no_cours = $_REQUEST['numcrs'];
                $nom_cours = $_REQUEST['nom'];
                $desc_cours = $_REQUEST['desc'];
            //connection avec oracle 2
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                //verification si id auto né pas vide
               if(!empty($no_cours))
                {
                    //insertion 3
                    $insertion= oci_parse($conn,"insert into ML_COURS(no_cours,nom_cours,desc_cours) 
					values('$no_cours','$nom_cours','$desc_cours')");
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
        <h3>Modifier un cours</h3>
            <form method="post" action="index.php?choix=cours">
                Numero cours :
                <table>
                    <tr>
						<select name="crs">
                       <?php
                    $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select no_cours from ML_COURS");

                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $no_cours=$resultats['NO_COURS'][$i];
                        echo "<option value='$no_cours'>$no_cours</option>";
                    }
                    oci_close($conn);
                        ?>
                        </select></tr>
                    <tr><input type="submit" name="ChercherC" value="Chercher un cours"></tr>
                </table>
            </form>
                 <?php
            //recuperation des données
            //initialisation de la variable choix avec la fonction isset
            if(isset($_REQUEST['ChercherC']))
            {
                $choix= $_REQUEST['crs'];
                //connexion avec oracle
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //requête sql
                $update = oci_parse($conn,"Select * from ML_COURS WHERE no_cours='$choix'");

                //excution de la requête
                oci_execute($update);
                //analyse et affichage des resulta
                $nbrows=oci_fetch_all($update,$resultats);
                echo "<form method='post' action='index.php?choix=cours'>";
				echo "<table>";

                for( $i = 0 ; $i < $nbrows ; $i++)
                {//le champ idauto doit être a majusqule

                    $no_cours = $resultats['NO_COURS'][$i];
                    $nom_cours = $resultats['NOM_COURS'][$i];
                    $desc_cours = $resultats['DESC_COURS'][$i];



					echo "<tr>";
                    echo "<td>Nom :</td><td><input type='text' name='no_cours' value='$no_cours'></td></tr>";
                    echo "<td>Nom :</td><td><input type='text' name='nom_cours' value= '$nom_cours'></td></tr>";
                    echo "<td>Nom :</td><td><input type='text' name='desc_cours' value= '$desc_cours'></td></tr>";
					echo "</table>";
                }
                echo "<input type='submit' name='ok' value='ok'></form>";
            }
            if(isset($_REQUEST["ok"]))
            {
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //recuperation

                $no_cours = $_REQUEST['no_cours'];
                $nom_cours = $_REQUEST['nom_cours'];
                $desc_cours = $_REQUEST['desc_cours'];

                $misajour = oci_parse($conn,"UPDATE ML_COURS set no_cours='$no_cours',nom_cours='$nom_cours',desc_cours='$desc_cours' WHERE no_cours='$no_cours'");

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
  

        <h3>Supprimer un etudiant</h3>
<form method="post" action="index.php?choix=cours">
    Numero cours :
    <table>
    <tr><select name="suppC">
        <?php
                    $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select no_cours from ML_COURS");
                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $no_cours=$resultats['NO_COURS'][$i];
                        echo "<option value='$no_cours'>$no_cours</option>";
                    }
                    oci_close($conn);
                    ?>
    </select></tr>
    <tr><input type="submit" name="SupprimerC" value="Supprimer cet cours"></tr>
        </table>
</form>
            <?php
            //recuperation et initialisation  de requête
            if(isset($_REQUEST['SupprimerC']))
            {
                $choix = $_REQUEST['suppC'];
                //connexion
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                $delete=oci_parse($conn,"Delete FROM ML_COURS WHERE no_cours='$choix'");

                oci_execute($delete);
                $nbrows=oci_num_rows($delete);
                if($nbrows>0)
                {
                    echo "suppresion reussie";
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

