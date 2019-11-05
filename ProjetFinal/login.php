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
</head>
<body style="text-align: center;">

<!--Patient-->
<div class="entete"><h1>L'Administration</h1></div>
<form method="post" action="index.php?choix=administration">
    <table>
        <tr><td>Login :</td><td> <input name="login" value=""></td></tr>
        <tr><td>Password :</td><td><input type="password" name="password" value=""></td></tr>
        <tr><td colspan="2" align="right"> <input type="submit" name="administration" value="Entrez"></td></tr>

    </table>
</form>
<div class="entete"> <h1>Professeur</h1></div>
<form method="post" action="index.php?choix=prof">
    <table>
        <tr><td>Num du Prof :</td><td><input name="numprof" value=""></td></tr>
        <tr><td>Password :</td><td><input type="password" name="password" value=""></td></tr>
        <tr><td colspan="2" align="right"> <input type="submit" name="prof" value="Entrez"></td></tr>

    </table>
</form>
<div class="entete"><h1>Etudiants</h1></div>
<form method="post" action="index.php?choix=etudiant">
    <table>
        <tr><td>Code Permanent :</td><td><input name="codeper" value=""></td></tr>
        <tr><td>Password :</td><td><input type="password" name="password" value=""></td></tr>
        <tr><td colspan="2" align="right"> <input type="submit" name="etudiant" value="Entrez"></td></tr>

    </table>
</form>
</body>
</html>