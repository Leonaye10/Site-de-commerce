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
            <form method="post" action="index.php?choix=etud">
                <table>
                    <tr><td>Nom : </td><td><input name="nom" value=""></td></tr>
                    <tr><td>Prenom : </td><td><input name="prenom" value=""></td></tr>
                    <tr><td>Date de naissance(dd-mm-aa) : </td><td><input name="datenai" value=""></td></tr>
					<tr><td>Telephone : </td><td><input name="tel" value=""></td></tr>
					<tr><td>Numero de la rue : </td><td><input name="numrue" value=""></td></tr>
					<tr><td>Nom de la rue : </td><td><input name="nomrue" value=""></td></tr>
					<tr><td>Province : </td><td><input name="province" value=""></td></tr>
					<tr><td>Ville : </td><td><input name="ville" value=""></td></tr>
					<tr><td>Numero du groupe : </td><td><input name="numgrpe" value=""></td></tr>
					<tr><td>Mot de passe : </td><td><input name="password" value=""></td></tr>
                    <tr><td><input type="submit" name="ajouterEt" value="Ajouter un etudiant"></td></tr>
                </table>
            </form>
            
        <?php
        if(isset($_REQUEST['ajouterEt']))
        {
				$nom_etud = $_REQUEST['nom'];
                $prenom_etud = $_REQUEST['prenom'];
                $tel_etud = $_REQUEST['tel'];
                $datedenaissance = $_REQUEST['datenai'];
                $no_rue = $_REQUEST['numrue'];
                $nom_rue = $_REQUEST['nomrue'];
                $province = $_REQUEST['province'];
                $ville = $_REQUEST['ville'];
                $no_groupe = $_REQUEST['numgrpe'];
                $password = $_REQUEST['password'];
            //connection avec oracle 2
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                //verification si id auto né pas vide
                if(!empty($nom_etud))
                {
                    //insertion 3
                    $insertion= oci_parse($conn,"insert into ML_ETUDIANT(codepermanent,nom_etud,prenom_etud,datedenaissance,tel_etud,no_rue,nom_rue,province,ville,no_groupe,password)
					values(SUBSTR('$nom_etud',0,3)||SUBSTR('$prenom_etud',0,1)||substr('$datedenaissance',0,2)||seq_etud.NEXTVAL,'$nom_etud','$prenom_etud',TO_DATE('$datedenaissance','dd-mm-yyyy'),'$tel_etud','$no_rue','$nom_rue','$province','$ville','$no_groupe','$password')");
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
                    echo'Veuillez remplir correctement le champs id';
                }
        }
        ?>
		</td>
		<td style="padding:20px;border-radius:25px;">
        <h3>Modifier un etudiant</h3>
            <form method="post" action="index.php?choix=etud">
                Code permanent :
                <table>
                    <tr>
						<select name="codepe">
                        <?php
                            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select codepermanent from ML_ETUDIANT");

                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $code=$resultats['CODEPERMANENT'][$i];
                        echo "<option value='$code'>$code</option>";
                    }
                    oci_close($conn);
                        ?>
                        </select></tr>
                    <tr><input type="submit" name="ChercherEt" value="Chercher un etudiant"></tr>
                </table>
            </form>
                  <?php
            //recuperation des données
            //initialisation de la variable choix avec la fonction isset
            if(isset($_REQUEST['ChercherEt']))
            {
                $choix= $_REQUEST['codepe'];
                //connexion avec oracle
                //inscrire le nom et le mot de passe de l'utilisateur crée dans oracle
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //requête sql
                $update = oci_parse($conn,"Select * from ML_ETUDIANT WHERE codepermanent='$choix'");

                //excution de la requête
                oci_execute($update);
                //analyse et affichage des resulta
                $nbrows=oci_fetch_all($update,$resultats);
                echo "<form method='post' action='index.php?choix=etud'>";
				echo "<table>";

                for( $i = 0 ; $i < $nbrows ; $i++)
                {//le champ idauto doit être a majusqule

                    $nom_etud = $resultats['NOM_ETUD'][$i];
                    $prenom_etud = $resultats['PRENOM_ETUD'][$i];
                    $tel_etud = $resultats['TEL_ETUD'][$i];
                    $datedenaissance = $resultats['DATEDENAISSANCE'][$i];
                    $no_rue = $resultats['NO_RUE'][$i];
                    $nom_rue = $resultats['NOM_RUE'][$i];
                    $province = $resultats['PROVINCE'][$i];
                    $ville = $resultats['VILLE'][$i];
                    $no_groupe = $resultats['NO_GROUPE'][$i];                 
                    $password = $resultats['PASSWORD'][$i];

					
					echo "<tr>";
                    echo "<td>Nom :</td><td><input type='text' name='nom' value='$nom_etud'></td></tr>";
                    echo "<td>Prenom :</td><td><input type='text' name='prenom' value= '$prenom_etud'></td></tr>";
                    echo "<td>Telephone :</td><td><input type='text' name='phone' value= '$tel_etud'></td></tr>";
                    echo "<td>Date de naissance (dd-mm-aa) :</td><td><input type='text' name='naissance' value= '$datedenaissance'></td></tr>";
                    echo "<td>Numero de la rue :</td><td><input type='text' name='numerorue' value= '$no_rue'></td></tr>";
                    echo "<td>Nom de la rue :</td><td><input type='text' name='nomrue' value= '$nom_rue'></td></tr>";
                    echo "<td>Province :</td><td><input type='text' name='province' value= '$province'></td></tr>";
                    echo "<td>Ville :</td><td><input type='text' name='ville' value= '$ville'></td></tr>";
                    echo "<td>Num de groupe :</td><td><input type='text' name='groupe' value= '$no_groupe'></td></tr>";
                    echo "<td>Mot de passe :</td><td><input type='password' name='password' value= '$password'></td></tr>";
                }
				echo "</table>";
                echo "<input type='submit' name='ok' value='ok'></form>";
				
            }
            if(isset($_REQUEST["ok"]))
            {
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                //recuperation

                $nom_etud = trim($_REQUEST['nom']);
                $prenom_etud = $_REQUEST['prenom'];
                $tel_etud = $_REQUEST['phone'];
                $datedenaissance = $_REQUEST['naissance'];
                $no_rue = $_REQUEST['numerorue'];
                $nom_rue = $_REQUEST['nomrue'];
                $province = $_REQUEST['province'];
                $ville = $_REQUEST['ville'];
                $no_groupe = $_REQUEST['groupe'];
                $password = $_REQUEST['password'];

                $misajour = oci_parse($conn,"UPDATE ML_ETUDIANT set nom_etud='$nom_etud',prenom_etud='$prenom_etud',tel_etud='$tel_etud',datedenaissance='$datedenaissance',no_rue='$no_rue',nom_rue='$nom_rue',province='$province',ville='$ville',no_groupe='$no_groupe' , password='$password' WHERE codepermanent='$code'");

                oci_execute($misajour);
                oci_commit($conn);
                //analyse des resultat de la requête
                $rows=oci_num_rows($misajour);
                if($rows >0)
                {
                    echo $rows.'Mise a jour reussie ';
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
<form method="post" action="index.php?choix=etud">
    Code permanent :
    <table>
    <tr><select name="supp">
        <?php    
            $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");

                    $select=oci_parse($conn,"Select codepermanent from ML_ETUDIANT");
                    oci_execute($select);
                    $nbrows=oci_fetch_all($select,$resultats);

                    for( $i = 0 ; $i < $nbrows ; $i++)
                    {//le champ idauto doit être a majusqule
                        $code=$resultats['CODEPERMANENT'][$i];
                        echo "<option value='$code'>$code</option>";
                    }
                    oci_close($conn);
        ?>
    </select></tr>
    <tr><input type="submit" name="SupprimerEt" value="Supprimer cet etudiant"></tr>
        </table>
</form>
            <?php
            //recuperation et initialisation  de requête
            if(isset($_REQUEST['SupprimerEt']))
            {
                $choix = $_REQUEST['supp'];
                //connexion
                $conn=oci_connect("sgbdr","sgbdr","127.0.0.1/XE");
                $delete=oci_parse($conn,"Delete FROM ML_ETUDIANT WHERE codepermanent='$choix'");

                oci_execute($delete);
                $nbrows=oci_num_rows($delete);
                if($nbrows>0)
                {
                    echo "Suppresion reussi";
                }

                else
                {
                    echo "Echec de suppresion ";

                }
                oci_close($conn);
            }
            ?>
        </td>
    </tr>
</table>
</center>       

