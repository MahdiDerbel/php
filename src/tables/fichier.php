<?php
class TableFichier extends Table
{
	var $id = '';
	var $nom = '';
	var $reference = '';
	var $date = '';
	var $fichier='';
	var $id_module='';
	var $id_produit='';
	function __Construct()
	{
		$this->table='#__fichier';	
	}
}