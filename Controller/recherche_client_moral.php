<!DOCTYPE html>
<html>
<head>
	<title>Page d'accueil Employés</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../Public/script_index.css" />
</head>
<body>

	<header>
		<h1>BIENVENUE DANS LA BANQUE DU PEUPLE</h1>
	</header>


	<?php

		// Connexion à la base de données
		include ("../Model/connexion_bdd_bp.php");
		require ("../Model/Manager.php");

		$manager = new Manager($db);

		extract($_POST);
		

		if($id_clients = $manager->verifieClientMoralExiste($identifiant_entreprise))
		{

			$resultat = $manager->getInfoClientMoral($identifiant_entreprise);

			
				echo "id_client". $id_clients;
	?>

			<form id="form_insert_client_existant_moral" action="insert_compte_client_existant.php" method="post" onsubmit="return verifie_formulaire_entreprise(this)">

				
				<fieldset>
					<legend>Informations du Client</legend>
					<div>
						<label for="nom_entreprise">Nom Entreprise <em>*</em></label>
						<input type="text" id="nom_entreprise" name="nom_entreprise" value="<?php echo $resultat['nom_entreprise'] ?>" readonly />
					</div>
					<div>
						<label for="raison_social">Raison Social <em>*</em></label>
						<input type="text" id="raison_social" name="raison_social" value="<?php echo $resultat['raison_social'] ?>" readonly />
					</div>
					<div>
						<label for="adresse">Adresse Entreprise <em>*</em></label>
						<input type="text" id="adresse" name="adresse" value="<?php echo $resultat['adresse'] ?>" readonly />
					</div>
					<div>
						<label for="telephone">Tel <em>*</em></label>
						<input type="tel" id="telephone" name="telephone" value="<?php echo $resultat['telephone'] ?>" readonly />
					</div>
					<div>
						<label for="email">E-mail </label>
						<input type="text" id="email" name="email" value="<?php echo $resultat['email'] ?>" readonly />
					</div>
					<div>
						<label for="identifiant_entreprise">Identifiant Entreprise <em>*</em></label>
						<input type="text" id="identifiant_entreprise" name="identifiant_entreprise" value="<?php echo $resultat['identifiant_entreprise'] ?>" readonly />
					</div>
					<div>
						<label for="date_inscription">Date Inscription </label>
						<input type="text" id="date_inscription" name="date_inscription" value="<?php echo $resultat['date_inscription'] ?>" readonly />
					</div>
					<div>
						<label for="type_client">Type client </label>
						<input type="text" id="type_client" name="type_client" value="<?php echo $resultat['type_client'] ?>" readonly />
					</div>
					<div>
						<input type="hidden" id="id_clients" name="id_clients" value="<?php echo $id_clients ?>"/>
					</div>
				</fieldset>

				<h2>VEILLEZ SAISIR LES INFORMATIONS DU COMPTE</h2>
				<p><i>Les champs marqué par <em>*</em> sont <em>obligatoires</em></i></p>

				<fieldset>
					<legend>Informations Compte</legend>
						<label class="selection_type_compte">Sélectionnez le type de compte <em>*</em></label>
						<select id="type_compte" name="type_compte" >
						<option>Type de compte</option>
						<option value="compte epargne">Compte Epargne</option>
						<option value="compte courant">Compte Courant</option>
						<option id="compte_bloque" value="compte bloque" onselect="verification_duree_blocage(this)">Compte Bloqué</option>
						</select>
						<span id="erreur_selection"></span>
						<br/><br/>
						
						<div>
							<label for="numero_agence">N° de l'agence <em>*</em></label>
							<input type="text" id="numero_agence" name="numero_agence" placeholder="saisir le N° de l'agence"/>
						</div>
						<div>
							<label for="numero_compte">N° Compte <em>*</em></label>
							<input type="text" id="numero_compte" name="numero_compte" placeholder="saisir le N° de Compte"/>
						</div>
						<div>
							<label for="cle_rib">Clé RIB <em>*</em></label>
							<input type="text" id="cle_rib" name="cle_rib" placeholder="saisir la clé RIB"/>
						</div>
						<div >
							<label for="solde">Solde (optionnel)<em></em></label>
							<input type="text" id="solde" name="solde" />
						</div>
						<div id="frais_ouverture_compte">
							<label for="frais_ouverture">Frais ouverture <em>*</em></label>
							<input type="text" id="frais_ouverture" name="frais_ouverture" value="20000" />
						</div>
						<div id="montant_remuneration_compte">
							<label for="montant_remuneration">Montant Rémuneration <em></em></label>
							<input type="text" id="montant_remuneration" name="montant_remuneration" />
						</div>
						<div id="agios_compte">
							<label for="agios">Agios <em>*</em></label>
							<input type="text" id="agios" name="agios" placeholder="saisir l'agios"/>
						</div>
						<div id="duree_blocage_compte">
							<label for="duree_blocage">Durée Blocage <em>*</em></label>
							<input type="text" name="duree_blocage" id="duree_blocage"  /><span id="mois"> mois </span><span id="erreur_duree"></span>
						</div>
				</fieldset>

					<div class="validation">
						<input type="submit" value="Valider" id="valider" />
						<input type="reset" value="Annuler" />
					</div>

			</form>

	<?php

	
		}
		else{
			echo 'Aucun client trouvé pour cet identifiant : '. $identifiant_entreprise . '<br />';
			echo '<a href="compte_client_moral.php">Réessayer</a>';
		}

	

	?>

	
	<script type="text/javascript" src="../Public/script_index.js"></script>
</body>
</html>