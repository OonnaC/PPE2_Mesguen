<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <meta http-equiv="content-language" content="fr" />
    <link rel="stylesheet" type="text/css" href="../css/tournees.css" />
    <title>MESGUEN - AC12</title>
</head>
<header><img src="../image/Mesguen.jpg"></header>
<section1></section1>
<section2></section2>
<aside>
    <h1>Modification de tourn&eacute;e</h1>
    <hr />
    <br />
    <br />
    <br />
    <br />
    <br />

    <body>
        <?php
			include 'connectAD.php';
		
			@$TRNNUM = $_GET['tournee'];
		
			$sql = "SELECT VEHIMMAT, CHFNOM, TRNCOMMENTAIRE, TRNDTE
					FROM tournee, chauffeur
					WHERE tournee.CHFID = chauffeur.CHFID
					AND TRNNUM = $TRNNUM";
			
			$result = executeSQL($sql);
			
			$row = mysqli_fetch_array($result, );
			
			$VEHIMMAT = $row['VEHIMMAT'];
			$CHFNOM = $row['CHFNOM'];
			$TRNCOMMENTAIRE = $row['TRNCOMMENTAIRE'];
			$TRNDTE = $row['TRNDTE'];
		?>

        <div id="conteneurgauche">

            <form id="formulaire" action="./AC12modifiertraitement.php" method="get">
                <label for="date">Date :</label>
                <input id="date" name="date" type="text" value="<?php echo "$TRNDTE" ?>" size="15" maxlength="8" />

                <br />
                <br />

                <label for="chauffeur">Chauffeur :</label>

                <?php
				$sql = "SELECT CHFNOM 
						FROM chauffeur"; 
				
				$result = executeSQL($sql);
				
				$cpt = mysqli_num_rows($result);
				
				if ($cpt>0) {
					echo "<select size=\"1\" name=\"chauffeur\" id=\"numero\">";
					
					while ($row = mysqli_fetch_array($result, )) {
						if ($CHFNOM == $row[0]) {
							echo "<option value=$row[0] selected=$CHFNOM>$row[0]</option>";
						} else {
							echo "<option value=$row[0]>$row[0]</option>";
						}
					}
					
				} else {
					echo "<select size=\"1\" name=\"chauffeur\" id=\"chauffeur\" disabled=\"disabled\" >";	
					echo "<option>Aucune information...</option>";
				}
			
				echo "</select>";
    		?>

                <br />
                <br />

                <label for="voiture">V&eacute;hicule :</label>

                <?php
				$sql = "SELECT VEHIMMAT 
						FROM vehicule";
				
				$result = executeSQL($sql);
				
				$cpt = mysqli_num_rows($result);
				
				if ($cpt>0) {
					echo "<select size=\"1\" name=\"voiture\" id=\"voiture\">";
					
					while ($row = mysqli_fetch_array($result, )) {
					if ($VEHIMMAT == $row[0]) {
							echo "<option value=$row[0] selected=$VEHIMMAT>$row[0]</option>";
						} else {
							echo "<option value=$row[0]>$row[0]</option>";
						}
					}
					
				} else {
					echo "<select size=\"1\" name=\"voiture\" id=\"voiture\" disabled=\"disabled\" >";	
					echo "<option>Aucune information...</option>";
				}
			
				echo "</select>";
    		?>

                <br />
                <br />

                <label for="prisEnCharge">Pris en charge le :</label>
                <input id="prisEnCharge" name="prisEnCharge" type="text" value="<?php $date = date("Y/m/d H:i:00"); echo "$date" ?>" readonly size="10" maxlength="8" />

                <br />
                <br />

                <label for="commentaire">Commentaire :</label>
                <textarea name="commentaire" rows="5" cols="15"><?php 
																$sql = "SELECT TRNCOMMENTAIRE
																		FROM tournee
																		WHERE TRNNUM = $TRNNUM";
																
																$result = executeSQL($sql);
																
																$row = mysqli_fetch_array($result, );
																
																echo "$row[0]";
															?>
			</textarea>

                <br />
                <br />

                <input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
                <input id="valider" name="valider" type="submit" value="Valider" <?php
					$sql = "SELECT * FROM etape";
					
					$result = executeSQL($sql);
					
					$cpt = mysqli_num_rows($result);
					
					if ($cpt==0){
						echo("disabled=\"disabled\"");
					}
				?> />

                <input id="cancel" type="button" name="retour" value="Annuler" onclick="location.href='AC11.php'" />
            </form>

        </div>

        <br />
        <br />
        <br />
        <br />
        <br />

        <div id="conteneurdroit">

            <table border="0" style="width:80%">
                <caption>Etapes :</caption>

                <?php
				//si il recois un numero il regarde si il y a des etapes associer .
				echo "<tr>
						<td>Numero de l'etape</td>
						<td>Nom du lieu</td>";
					
				//selection id de la ville
				$sql = "SELECT ETPID, LIEUNOM 
						FROM commune, lieu, etape 
						WHERE commune.VILID = lieu.VILID 
						AND etape.LIEUID = lieu.LIEUID 
						AND TRNNUM = $TRNNUM";
					
				$result = executeSQL($sql);
					
				$cpt = compteSQL($sql);
					
				while ($row = mysqli_fetch_array($result, )) {
					echo "<tr>";
					echo "<td>$row[0]</td>";
					echo "<td>$row[1]</td>";
					echo "<td>
							<form id='supprimer' action='supprimer-etape.php'>
								<input id='idetape' name='idetape' type='hidden' value='$row[0]' />
								<input id='tournee' name='tournee' type='hidden' value='$TRNNUM'/>
								<input id='supprimer' name='supprimer' type='image' src='../image/cross.png' /> 
							</form> </td>";
					
					echo"<td><img src=\"../image/modif02.png\" alt=\"erreur\" onclick=\"location.href='./AC13M.php'\" style=\"cursor:pointer;\" ></td>";
					echo"</tr>";
				}
    		    ?>

            </table>

            <form id="AC13" action="AC13A.php">
                <input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
                <br />
                <input id="ajouter" name="ajouter" type="submit" value="Ajouter" />
            </form>

            <?php 
			if (isset($_GET['message']))
				echo $_GET['message'];
			else
				echo "&nbsp;";
		    ?>
            <div />
</aside>
<footer>

</footer>
</body>

</html>