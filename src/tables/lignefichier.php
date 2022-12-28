<?php
class TableLigneFichier extends Table
{
	var $id = '';
	var $id_chapitre = '';
	var $id_fichier = '';
	var $date = '';
	var $fichier='';
	var $id_module='';
	var $id_produit='';
	function __Construct()
	{
		$this->table='#__lignefichier';	
	}
}