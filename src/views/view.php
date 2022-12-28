<?php

 class View {
	var $name='site';
	var $title='Gestions des documents';
	var $description;
	var $chemin;
	var $js=array();
	var $css=array();
	var $meta=array();
	var $tab=false;
	var $sitename='Gestions des documents';
	var $layout='';
	var $alias='';
	var $root=false;
	var $menu=array();
	var $session=false;
	var $keywords = '';
	var $m_description = '';
	var $lang = '';
	
	function __Construct($alias='404',$params=array()){
		$sitename='Gestions des documents';
		if($alias=='index.php')$alias='';
	
			$db=new bd();
			$sql="select * from #__root where alias=404 or alias=".$db->quote($alias);
		
			$db->setQuery($sql);
			$items=$db->getLignes('alias');

				if(!isset($items[$alias])){					$item=$items[404];
				}else $item=$items[$alias];
	
				$namefile=strtolower($item->view).'.view.php';
				require_once(JPATH_VIEWS.DIRECTORY_SEPARATOR.$item->view.DIRECTORY_SEPARATOR.$namefile);//die(PATH_VIEWS.DIRECTORY_SEPARATOR.$item->view.DIRECTORY_SEPARATOR.$namefile);
				$classname=$item->view.'View';
				$view=new $classname();
			
				if(isset($params['session']))$view->session=$params['session'];//die(print_r($view->session->language));
				$lang=$view->session->language;
			
				$langue=$view->session->lang;
				if(!method_exists($view,$view->layout)){$view->layout='Error';}
					ob_start();
					if($item->view=='site'){
					$model=new site();
					
					}
				
				if($item->id_pour!='' && $item->id_pour>0)$_REQUEST['id']=$item->id_pour;
					$view->lang=$view->session->language;
					$view->root=$item;
					$view->layout=$item->layout; 
					$view->alias=$item->alias; 
					$view->name=strtolower($item->view);
					$layout=$item->layout;
					$d=array('msg'=>'','type'=>'');
					if(isset($params['msg']))$d['msg']=$params['msg'];
					if(isset($params['type']))$d['type']=$params['type'];
					if(method_exists($view,$layout))$view->$layout($d);else {/** appele fonction 404**/}
					$content = ob_get_clean();
					require_once('template.php');
	}
			function addMeta(){
		$this->meta=array();	
		$this->meta[]='<meta name="robots" content="noindex" />';
	}
	
	function getAlias($titre){
 		$charset='utf-8';
      $str = htmlentities(trim($titre), ENT_NOQUOTES, $charset);
      
      $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
      $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
      $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
      $str = str_replace(" ", "-", $str);
      $str = str_replace(",", "", $str);
      $str = str_replace("/", "", $str);
      $str = str_replace("--", "-", $str);
      $str = str_replace("-", "-", $str);
      $str = strtolower($str);
      return $str;
     
	}
	
	function getValue($value){
		
		if(isset($this->$value))return $this->$value;
	}
}