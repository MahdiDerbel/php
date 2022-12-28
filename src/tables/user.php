<?php 
class TableUser extends bd{
	var $id='';
	var $nom_prenom='';
	var $password=0;
	var $email='';
	var $etat=0;
	var $derniere_visite='';
	var $date_inscript=0;
	var $id_role="";
	var $site="";
	var $activite="";
	var $fonction="";
	var $matricule="";	
	var $sign="";	
	var $session_id="";
	function __Construct(){
		$this->table = '#__user';	
	}
	
	}