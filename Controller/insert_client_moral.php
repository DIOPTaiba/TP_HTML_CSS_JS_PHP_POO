<?php

	require_once "../Config/autoload.php";
	require_once ("../Model/connexion_bdd_bp.php");

	$manager = new Manager($db);

	extract($_POST);

	$date_inscription = date('yy-m-d h:i:s');
	$date_ouverture = date('yy-m-d h:i:s');
	$date_changement_etat = date('yy-m-d h:i:s');

	// Insertion des infos dans la table clients
	$clients = new Clients ($adresse, $telephone, $email, $date_inscription, $type_client, $id_responsable_compte);
	$id_clients = $manager->addClients($clients);

	//insertion des infos dans la table client Moral
	$clientMoral = new ClientMoral ($nom_entreprise, $identifiant_entreprise, $raison_social, $id_clients);
	$manager->addClientMoral($clientMoral);


	// Insertion infos sur la tables compte général
	$comptes = new Comptes($numero_compte, $cle_rib, $solde, $date_ouverture, $numero_agence, $id_clients);
	$id_comptes = $manager->addComptes($comptes);


	// Insertion état comptes lors de leurs créations
	$etat_compte = new EtatCompte('actif', $date_changement_etat, $id_comptes);
	$manager->addEtatCompte($etat_compte);

	
	// Insertion de données selon le type de compte choisit
	if($type_compte == 'compte epargne')
	{
		$compte_epargne = new CompteEpargne($frais_ouverture, $montant_remuneration, $id_comptes);
		$manager->addCompteEpargne($compte_epargne);
	}
	else if ($type_compte == 'compte courant')
	{
		$compte_courant = new CompteCourant($agios, $id_comptes);
		$manager->addCompteCourant($compte_courant);
	}
	else
	{
		$compte_bloque = new CompteBloque($frais_ouverture, $montant_remuneration, $duree_blocage, $id_comptes);
		$manager->addCompteBloque($compte_bloque);	
	}


	echo "Les informations sont bien enregistrées";

	// Redirection du visiteur vers la page d'accueil accueil_responsable

	header('Location: ../View/accueil_responsable.php');


?>
