<?php 
class TableChapitre extends bd{
	var $id='';
	var $id_module='';
	var $parent="";
	var $code="";
	var $nom="";

	function __Construct(){
		$this->table = '#__chapitre';	
	}
	
	}