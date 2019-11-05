<?php
if(!session_id())
{
	session_start();
} 
?>
<center>

<table style="width:80%;">
    <tr style="background-color:#ECF1EF;text-align:center;">
        <td style="padding:20px;border-radius:25px;"><h3>Faire une inscription</h3>
            <form method="post" action="index.php?choix=inscription">
                <table>
                    <tr><td>Code permanent : </td><td><input name="codepermanent" value=""></td></tr>
                    <tr><td>Numero cours : </td><td><input name="nocours" value=""></td></tr>
                    <tr><td>Session : </td><td><input name="sess" value=""></td></tr>
					<tr><td>Numero du prof : </td><td><input name="noprof" value=""></td></tr>
					<tr><td>Note etudiant : </td><td><input name="note" value=""></td></tr>
					<tr><td>Prix cours : </td><td><input name="prix" value=""></td></tr>
					<tr><td>Date de debut du cours : </td><td><input name="dateDe" value=""></td></tr>
					<tr><td>Date de fin du cours : </td><td><input name="dateFin" value=""></td></tr>
					<tr><td>Rabais : </td><td><input name="rabais" value=""></td></tr>
                    <tr><td><input type="submit" name="ajouterIns" value="Faire une inscription"></td></tr>
                </table>
            </form>
            
        <?php
        if(isset($_REQUEST['ajouterIns']))
        {
				$codepermanent = $_REQUEST['codepermanent'];
                $no_cours = $_REQUEST['nocours'];
                $lasession = $_REQUEST['sess'];
                $no_prof = $_REQUEST['noprof'];
                $date_debut = $_REQUEST['dateDe'];
                $date_fin = $_REQUEST['dateFin'];
                $prix_cours = $_REQUEST['prix'];
                $rabais = $_REQUEST['rabais'];
                $note_etud = $_REQUEST['note'];
            //connection avec oracle 2
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                //verification si id auto né pas vide
                if(!empty($codepermanent))
                {
                    //insertion 3
                    $insertion= oci_parse($conn,"insert into ML_INSCRIPTION(no_seq,codepermanent,no_cours,no_prof,lasession,note_etud,prix_cours,date_debut,date_fin,rabais)
               values(seq_inscription.NEXTVAL,'$codepermanent','$no_cours','$no_prof','$lasession','$note_etud','$prix_cours',TO_DATE('$date_debut','dd-mm-yyyy'),TO_DATE('$date_fin','dd-mm-yyyy'),'$rabais')");
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
        <h3>Modifier une inscription</h3>
            <form method="post" action="index.php?choix=inscription">
                Numero inscription :
                <table>
                    <tr>
						<select name="seq">
                        <?php
                    $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select no_seq from ML_INSCRIPTION");

                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $no_seq=$resultats['NO_SEQ'][$i];
                        echo "<option value='$no_seq'>$no_seq</option>";
                    }
                    oci_close($conn);
                    ?>
                        </select></tr>
                    <tr><input type="submit" name="ChercherIns" value="Chercher une inscription"></tr>
                </table>
            </form>
                  <?php
            //recuperation des données
            //initialisation de la variable choix avec la fonction isset
            if(isset($_REQUEST['ChercherIns']))
            {
                $choix= $_REQUEST['seq'];
                //connexion avec oracle
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //requête sql
                $update = oci_parse($conn,"Select * from ML_INSCRIPTION WHERE no_seq='$choix'");

                //excution de la requête
                oci_execute($update);
                //analyse et affichage des resulta
                $nbrows=oci_fetch_all($update,$resultats);
                echo "<form method='post' action='index.php?choix=inscription'>";
				echo "<table>";

                for( $i = 0 ; $i < $nbrows ; $i++)
                {//le champ idauto doit être a majusqule

                    $codepermanent = $resultats['CODEPERMANENT'][$i];
                    $no_cours = $resultats['NO_COURS'][$i];
					$no_prof = $resultats['NO_PROF'][$i];
                    $lasession = $resultats['LASESSION'][$i];
                    $note_etud = $resultats['NOTE_ETUD'][$i];
					$prix_cours = $resultats['PRIX_COURS'][$i];
                    $date_debut = $resultats['DATE_DEBUT'][$i];
                    $date_fin = $resultats['DATE_FIN'][$i];
                    $rabais = $resultats['RABAIS'][$i];
					
					echo "<tr>";
                    echo "<td>Code permanent :</td><td><input type='text' name='codepermanent' value='$codepermanent'></td></tr>";
                    echo "<td>Numero cours :</td><td><input type='text' name='no_cours' value= '$no_cours'></td></tr>";
					echo "<td>Numero prof :</td><td><input type='text' name='no_prof' value= '$no_prof'></td></tr>";
                    echo "<td>Session :</td><td><input type='text' name='lasession' value= '$lasession'></td></tr>";
                    echo "<td>Note de l'etudiant :</td><td><input type='text' name='note_etud' value= '$note_etud'></td></tr>";
					echo "<td>Prix du cours :</td><td><input type='text' name='prix_cours' value= '$prix_cours'></td></tr>";
                    echo "<td>Date de debut du cours :</td><td><input type='text' name='date_debut' value= '$date_debut'></td></tr>";
                    echo "<td>Date de fin du cours :</td><td><input type='text' name='date_fin' value= '$date_fin'></td></tr>";
                    echo "<td>Rabais :</td><td><input type='text' name='rabais' value= '$rabais'></td></tr>";
					echo "</table>";
                }
                echo "<input type='submit' name='ok' value='Valider'></form>";
            }
            if(isset($_REQUEST["ok"]))
            {
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //recuperation

                $codepermanent = trim($_REQUEST['codepermanent']);
                $no_cours = $_REQUEST['no_cours']; 
                $no_prof = $_REQUEST['no_prof'];
				$lasession = $_REQUEST['lasession'];
				$note_etud = $_REQUEST['note_etud'];
				$prix_cours = $_REQUEST['prix_cours'];
                $date_debut = $_REQUEST['date_debut'];
                $date_fin = $_REQUEST['date_fin'];
                $rabais = $_REQUEST['rabais'];
                

                $misajour = oci_parse($conn,"UPDATE ML_INSCRIPTION set no_cours='$no_cours',
				no_prof='$no_prof',lasession='$lasession',note_etud='$note_etud',prix_cours='$prix_cours',
				date_debut=TO_DATE('$date_debut','dd-mm-yyyy'),date_fin=TO_DATE('$date_fin','dd-mm-yyyy'),
				rabais='$rabais' WHERE no_seq='$no_seq'");
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
  

        <h3>Supprimer une inscription</h3>
<form method="post" action="index.php?choix=inscription">
    Numero inscription :
    <table>
    <tr><select name="supp">
        <?php    
           $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select no_seq from ML_INSCRIPTION");
                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $no_seq=$resultats['NO_SEQ'][$i];
                        echo "<option value='$no_seq'>$no_seq</option>";
                    }
                    oci_close($conn);
        ?>
    </select></tr>
    <tr><input type="submit" name="SupprimerIns" value="Supprimer cette inscription"></tr>
        </table>
</form>
            <?php
            //recuperation et initialisation  de requête
            if(isset($_REQUEST['SupprimerIns']))
            {
                $choix = $_REQUEST['supp'];
                //connexion
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                $delete=oci_parse($conn,"Delete FROM ML_INSCRIPTION WHERE no_seq='$choix'");

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

