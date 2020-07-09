<?php

class ClientMoral
{
	private $nom_entreprise;
	private $identifiant_entreprise;
	private $raison_social;
	private $id_clients;


	public function __Construct($nom_entreprise, $identifiant_entreprise, $raison_social, $id_clients)
	{
		$this->nom_entreprise = $nom_entreprise;
		$this->identifiant_entreprise = $identifiant_entreprise;
		$this->raison_social = $raison_social;
		$this->id_clients = $id_clients;
	}

	//Définition des gett
	public function getNomEntreprise() { return $this->nom_entreprise; }
	public function getIdentifiantEntreprise() { return $this->identifiant_entreprise; }
	public function getRaisonSocial() { return $this->raison_social; }
	public function getIdClient() { return $this->id_clients; }

	// public function setNomEntreprise($nom_entreprise) 
	// { 
	// 	$this->nom_entreprise = $nom_entreprise; 
	// }

	// public function setIdentifiantEntreprise($identifiant_entreprise) 
	// { 
	// 	$this->identifiant_entreprise = $identifiant_entreprise; 
	// }

	// public function setRaisonSocial($raison_social) 
	// { 
	// 	$this->raison_social = $raison_social; 
	// }

	// public function setIdClient($id_clients) 
	// { 
	// 	$this->id_clients = $id_clients; 
	}
   

}