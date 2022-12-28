<?php

class Config
{
	var  $host_name="192.168.1.13";
	var  $username="root";
	var  $db_name="module";
	var  $port="3306";
	var  $password_db="12345";
	var $sitename='Gestion des Modules';
	var $prefix="gesss_";
	var $fromname='Gestion des Modules';
	var $bcc='lahiani.mayssa@medicacom.tn';
	var $emailfrom='contact@medicacom.tn';
	var $emailto='contact@medicacom.tn';
	static function getInfo($label){
		return $this->$label;	
	}
	
	
}