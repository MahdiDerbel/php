<?php 
class Lang{
	var $file=array(0=>'fr.ini',1=>'en.ini');
	var $fichier='fr.ini';
	var $params=array();
	var $default_lang=0;
	function __Construct($lang=0){
		$file=array(0=>'fr',1=>'en');
		if($key=array_search($lang,$file) && !is_numeric($lang))$lang=$key;
		if(!$lang && $lang!='0')$lang=$this->default_lang; 
		$this->fichier=$this->file[$lang];
		$this->default_lang=$lang;
		
		$this->params=parse_ini_file($this->file[$lang]);
	}
	/*function Lang($lang=0){
		$file=array(0=>'fr',1=>'en');
		if($key=array_search($lang,$file))$lang=$key;
		$this->fichier=$this->file[$lang];
		$this->params=parse_ini_file($this->file[$lang]);
		
		
	}*/

	function text($var){
		if(isset($this->params[$var]))return $this->params[$var];	
		return;
	}
	
	function sprintfi($var,$args){
	//die('"'.implode('","',$args).'"');
$p=implode('","',$args);
		if(isset($this->params[$var]))  return call_user_func_array('sprintf',array_merge((array)$this->params[$var],$args));
		return;
	}
	
	
}