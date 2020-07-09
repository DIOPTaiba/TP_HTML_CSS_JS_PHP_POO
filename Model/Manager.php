<?php

	require_once ("connexion_bdd_bp.php");
	class Manager
	{

		private $_db; // Instance de PDO

		public function __construct($db)
		{
			$this->setDb($db);
		}

		public function setDb(PDO $db)
		{
			$this->_db = $db;
		}

		public function verifieUserExiste(ResponsableCompte $responsable_compte)
		{
			$req = $this->_db->prepare('SELECT * FROM responsable_compte WHERE login = :login AND mot_de_passe = :mot_de_passe');

			$req->execute(array(
				'login' => $responsable_compte->getLogin(),
				'mot_de_passe' => $responsable_compte->getMotDePasse()
				));

			return $resultat = $req->fetch();

			$req->closeCursor();
		}

		public function verifieClientNonSalarieExiste($identifiant_client)
		{
			$test = $this->_db->prepare('SELECT id_clients FROM client_non_salarie WHERE carte_identite = ? ');
			$test->execute(array($identifiant_client));

			$reponse = $test->fetch();
			return $reponse['id_clients'];
		}

		public function verifieClientSalarieExiste($identifiant_client)
		{
			$test = $this->_db->prepare('SELECT id_clients FROM client_salarie WHERE carte_identite = ? ');
			$test->execute(array($identifiant_client));

			$reponse = $test->fetch();
			return $reponse['id_clients'];
		}

		public function verifieClientMoralExiste($identifiant_entreprise)
		{
			$test = $this->_db->prepare('SELECT id_clients FROM client_moral  WHERE identifiant_entreprise = ?');
			$test->execute(array($identifiant_entreprise));

			$reponse = $test->fetch();
			return $reponse['id_clients'];
		}

		public function addClients(Clients $clients)
		{
			$req = $this->_db->prepare('INSERT INTO clients (adresse, telephone, email, date_inscription,
			type_client, id_responsable_compte) VALUES(:adresse, :telephone, :email, :date_inscription, :type_client,
			:id_responsable_compte)');
			$req->execute(array(
				'adresse' => $clients->getAdresse(),
				'telephone' => $clients->getTelephone(),
				'email' => $clients->getEmail(),
				'date_inscription' => $clients->getDateInscription(),
				'type_client' => $clients->getTypeClient(),
				'id_responsable_compte' => $clients->getIdResponsableCompte()
			));
			$id_client = $this->_db->lastInsertId();
			return $id_client;

			$req->closeCursor();
		}

		public function addClientNonSalarie(ClientNonSalarie $clientNonSalarie/*$nom, $prenom, $carte_identite, $id_clients*/)
		{
			$req = $this->_db->prepare('INSERT INTO client_non_salarie (nom, prenom, carte_identite, id_clients) VALUES(:nom, :prenom, :carte_identite, :id_clients)');
			$req->execute(array(
				'nom' => $clientNonSalarie->getNom(),
				'prenom' => $clientNonSalarie->getPrenom(),
				'carte_identite' => $clientNonSalarie->getCarteIdentite(),
				'id_clients' => $clientNonSalarie->getIdClient()
			));

			$req->closeCursor();	
		}

		public function addClientSalarie(ClientSalarie $clientSalarie)
		{
			$req = $this->_db->prepare('INSERT INTO client_salarie (nom, prenom, carte_identite, profession, 
			salaire, nom_employeur, adresse_entreprise, raison_social, identifiant_entreprise,id_clients) 
			VALUES(:nom, :prenom, :carte_identite, :profession, :salaire, :nom_employeur, :adresse_entreprise, 
			:raison_social, :identifiant_entreprise, :id_clients)');
			$req->execute(array(
			'nom' => $clientSalarie->getNom(),
			'prenom' => $clientSalarie->getPrenom(),
			'carte_identite' => $clientSalarie->getCarteIdentite(),
			'profession' => $clientSalarie->getProfession(),
			'salaire' => $clientSalarie->getSalaire(),
			'nom_employeur' => $clientSalarie->getNomEmployeur(),
			'adresse_entreprise' => $clientSalarie->getAdresseEntreprise(),
			'raison_social' => $clientSalarie->getRaisonSocial(),
			'identifiant_entreprise' => $clientSalarie->getIdentifianteEntreprise(),
			'id_clients' => $clientSalarie->getIdClients()
			));	
		}

		public function addClientMoral(ClientMoral $clientMoral)
		{
			//insertion des Infos dans la table client Moral
			$req = $this->_db->prepare('INSERT INTO client_moral (nom_entreprise, raison_social, 
			identifiant_entreprise, id_clients) VALUES(:nom_entreprise, :raison_social, 
			:identifiant_entreprise, :id_clients)');
			$req->execute(array(
			'nom_entreprise' => $clientMoral->getNomEntreprise(),
			'raison_social' => $clientMoral->getRaisonSocial(),
			'identifiant_entreprise' => $clientMoral->getIdentifiantEntreprise(),
			'id_clients' => $clientMoral->getIdClient()
			));

			$req->closeCursor();
		}

		public function addComptes(Comptes $comptes)
		{
			$req = $this->_db->prepare('INSERT INTO comptes (numero_compte, cle_rib, solde, date_ouverture, 
			numero_agence, id_clients) VALUES(:numero_compte, :cle_rib, :solde, :date_ouverture, :numero_agence,
			:id_clients)');
			$req->execute(array(
				'numero_compte' => $comptes->getNumeroCompte(),
				'cle_rib' => $comptes->getCleRib(),
				'solde' => $comptes->getSolde(),
				'date_ouverture' => $comptes->getDateOuverture(),
				'numero_agence' => $comptes->getNumeroAgence(),
				'id_clients' => $comptes->getIdClients()
			));

			$id_comptes = $this->_db->lastInsertId();
			return $id_comptes;

			$req->closeCursor();
		}

		public function addEtatCompte(EtatCompte $etat_compte)
		{
			$req = $this->_db->prepare('INSERT INTO etat_compte (etat_compte, date_changement_etat, id_comptes) VALUES(:etat_compte, :date_changement_etat, :id_comptes)');
			$req->execute(array(
				'etat_compte' => $etat_compte->getEtatCompte(),
				'date_changement_etat' => $etat_compte->getDateChangementEtat(),
				'id_comptes' => $etat_compte->getIdComptes() 
				));
			$req->closeCursor();
		}

		public function addCompteEpargne(CompteEpargne $compte_epargne)
		{
			$req = $this->_db->prepare('INSERT INTO compte_epargne (frais_ouverture, montant_remuneration, id_comptes) VALUES(:frais_ouverture, :montant_remuneration, :id_comptes)');
			$req->execute(array(
				'frais_ouverture' => $compte_epargne->getFraisOuverture(),
				'montant_remuneration' => $compte_epargne->getMontantRemuneration(),
				'id_comptes' => $compte_epargne->getIdComptes() 
				));
			$req->closeCursor();
		}

		public function addCompteCourant(CompteCourant $compte_courant)
		{
			$req = $this->_db->prepare('INSERT INTO compte_courant (agios, id_comptes) VALUES(:agios, :id_comptes)');
			$req->execute(array(
				'agios' => $compte_courant->getAgios(),
				'id_comptes' => $compte_courant->getIdComptes() 
				));
			$req->closeCursor();
		}

		public function addCompteBloque(CompteBloque $compte_bloque)
		{
			$req = $this->_db->prepare('INSERT INTO compte_bloque (frais_ouverture, montant_remuneration, 
			duree_blocage, id_comptes) VALUES(:frais_ouverture, :montant_remuneration, :duree_blocage, :id_comptes)');
			$req->execute(array(
				'frais_ouverture' => $compte_bloque->getFraisOuverture(),
				'montant_remuneration' => $compte_bloque->getMontantRemuneration(),
				'duree_blocage' => $compte_bloque->getDureeBlocage(),
				'id_comptes' => $compte_bloque->getIdComptes() 
				));
			$req->closeCursor();
		}

		public function getInfoNonSalarie($identifiant_client)
		{
			$req = $this->_db->prepare('SELECT client_non_salarie.nom, client_non_salarie.prenom, 
			client_non_salarie.carte_identite, clients.adresse, clients.telephone, clients.email, 
			clients.date_inscription, clients.type_client FROM client_non_salarie INNER JOIN clients 
			ON client_non_salarie.id_clients = clients.id_clients WHERE carte_identite = ?');

			$req->execute(array($_POST['identifiant_client']));

			return $reponse = $req->fetch();

			$req->closeCursor();

		}

		public function getInfoSalarie($identifiant_client)
		{
			$req = $this->_db->prepare('SELECT client_salarie.nom, client_salarie.prenom, 
			client_salarie.carte_identite, client_salarie.profession, client_salarie.salaire, 
			client_salarie.nom_employeur, client_salarie.adresse_entreprise, client_salarie.raison_social, 
			client_salarie.identifiant_entreprise, clients.adresse, clients.telephone, clients.email, 
			clients.date_inscription, clients.type_client FROM client_salarie INNER JOIN clients 
			ON client_salarie.id_clients = clients.id_clients WHERE carte_identite = ?');

			$req->execute(array($identifiant_client));

			return $reponse = $req->fetch();

			$req->closeCursor();

		}

		public function getInfoClientMoral($identifiant_entreprise)
		{
			$req = $this->_db->prepare('SELECT client_moral.nom_entreprise, client_moral.raison_social, 
			client_moral.identifiant_entreprise, clients.adresse, clients.telephone, clients.email, 
			clients.date_inscription, clients.type_client FROM client_moral INNER JOIN clients ON 
			client_moral.id_clients = clients.id_clients WHERE identifiant_entreprise = ?');

			$req->execute(array($identifiant_entreprise));

			return $reponse = $req->fetch();

			$req->closeCursor();

		}
		

	}