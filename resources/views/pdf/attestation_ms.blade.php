<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<style type="text/css">

		body {
			border-style: solid;
			border-width: 3px;
			border-radius: 10px;
			padding : 40px;
			margin: 30px;
			width: 21cm;
  			height: 29.7cm; 
		}

		.header {
			text-align: center;
			position: relative;
			right : 280px;
			font-weight: bold;
		}

		.titre {
			text-align: center;
			font-weight: bold;
			font-size: 30px;
			text-decoration: underline;

		}

		.infos {
			margin : 20px;
			margin-left: 30px;
			font-size: 18px;
		}

		.footpage {
			text-align: center;
			font-size: 25px;
			text-decoration: underline;
		}

	</style>
</head>
<body>
<div class="header">
	<p>
		Royaume du Maroc<br/>
		Ministére de l'Intérieur<br/>
		Wilaya de la Région Marrakech-Safi<br/>
		Préfecture de Marrakech<br/>
		Secrétariat Général<br/>
		DRH/SFC<br/>
		----------------------
	</p>
</div>

<br/><br/><br/><br/><br/>

<div class="titre">
	&nbsp;Certificat de stage&nbsp;
</div>

<br/><br/>

<div class="infos">
	<table>
		<tr>
			<td>- Nom et Prénom du Stagiaire</td>
			<td>: <?php echo $stagiaire->nom . " " . $stagiaire->prenom; ?></td>
		</tr>
		<tr>
			<td>- Etablissement de formation</td>
			<td>: <?php echo $stagiaire->etablissement; ?></td>
		</tr>
		<tr>
			<td>- Filiaire</td>
			<td>: <?php echo $stagiaire->filiaire; ?></td>
		</tr>
		<tr>
			<td>- Division d'acceuil</td>
			<td>: <?php echo $stagiaire->dept_nom; ?></td>
		</tr>
		<tr>
			<td>- Periode de stage</td>
			<td>: <?php echo $stagiaire->datefrom . " à " . $stagiaire->dateend; ?></td>
		</tr>
	</table>
</div>

<br/><br/><br/><br/>
<div class="footpage">
	<p>Cachet et Signature du Service d'accueil</p>
</div>
</body>
</html>