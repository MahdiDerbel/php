<?php 
require_once(JPATH_MODELS.'/espacepro.php');//die('view');
class EspaceproView extends view {
	
	function __Construct(){}
	
	function display($params=array())
	{
		
		$session = $this->checkSession();
		$user=$session->user;	
	
		self::addMeta();	
		$lang=$session->language;		
		$lang=new Lang();
		if($user && $user->id>0){
			header('Location: '.Router::base().'admin-dossier');}
		//$this->title=$lang->text('TITLE_ESPACEPRO_LOGIN');		
		require_once('tmpl/default.php');
	}
	
	function addMeta(){
		$this->meta=array();	
		$this->meta[]='<meta name="robots" content="noindex" />';
	}
	
	function checkSession(){	
		self::addMeta();
		$user_id=0;
		if(isset($this->session->user->id))$user_id=$this->session->user->id;
	
		if($user_id==0){	
			//header('Location: '.Router::base());
		}
		return $this->session;		
	}
	
	function specialite($params=array()){
		$session = self::checkSession();
		$user = $session->user;
		$lang = $session->language;
		$data = $_REQUEST;
		$model = new Espacepro();
		$this->id = $this->new = 0;
		if($user){
		if($user->type==0 ){
		if(isset($data['id']) && is_numeric($data['id'])) $this->id = $data['id'];
		if(isset($data['new']) && is_numeric($data['new'])) $this->new = $data['new'];
		$this->filtre=array();
		$this->all = $model->getSpecialite();
		$this->etat=array(1=>$lang->text('PUBLIEE'),0=>$lang->text('NON_PUBLIEE'));
		$this->details = false;
		if($this->id > 0){
			$this->details = $model->getDetailsSpecialite($this->id);	
			if($this->details){}
			else $this->id = 0;
		}	
		
		
		$this->layoutName='specialite';
		require_once('tmpl/default_specialite.php');}
		else{header('Location: '.Router::base());}
	}else{header('Location: '.Router::base());}
	}

function tableau($params=array())
	{
		
		$session = $this->checkSession();	
		$user=$session->user;
		$lang=$session->language;
		$this->layoutName='tableau';
		//$this->title=$lang->text('TITLE_ESPACEPRO_LOGIN');
		self::addMeta();
		if($user && $user->id>0){require_once('tmpl/default_tableau.php');}
	
		
	}
function soumission($params=array())
	{
		
		$session = $this->checkSession();
		$user=$session->user;
			$lang=new Lang();
			$lang=$session->language;
		if($user && $user->id>0){
				self::addMeta();

		$this->layoutName='nouvelle soumission';	
			$model= new Espacepro();
			$this->module= $model->getModule();			
			require_once('tmpl/default_soumission.php');		
		}else{header('Location: '.Router::base());}
		
		//$this->title=$lang->text('TITLE_ESPACEPRO_LOGIN');
		
		
}	
function detailsmodule($params=array())
	{
		
		$session=$this->session;	
		$user=$session->user;
			$lang=new Lang();
				$lang=$session->language;
		$data=$_REQUEST;
			if($user && $user->id>0){			
			$this->id=$this->id_module=$this->id_module=0;
			if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
			if(isset($data['id_module']) && is_numeric($data['id_module']))$this->id_module = $data['id_module'];			
			if(isset($data['id_produit']) && is_numeric($data['id_produit']))$this->id_produit = $data['id_produit'];
					
			$this->layoutName='detailsmodule';
			$model= new Espacepro();
		$this->module= $model->getModule();
					
		self::addMeta();
		if($this->id >0){								
			$this->fichier = $model->getDetailsChapitreModule($this->id,$this->id_produit);			
			$this->chapitre = $model->detailsChapitre($this->id);		
			$this->dateInsert = $model->getDateInsertChapitre($this->id,$this->id_produit);	
			require_once('tmpl/default_detailsmodule.php');
		}
	}else{header('Location: '.Router::base());}
		
}
function module($params=array())
	{
		
		$session=$this->session;	
		$user=$session->user;
		$lang=new Lang();
		$lang=$session->language;
		$data=$_REQUEST;
			if($user && $user->id>0){			
			$this->id=$this->new=$this->id_produit=0;
			if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
			if(isset($data['id_produit']) && is_numeric($data['id_produit']))$this->id_produit = $data['id_produit'];
					
			$this->layoutName='module';
			$model= new Espacepro();
		$this->module= $model->getModule();
					
		self::addMeta();
		if($this->id >0)		{		
						
			$this->chapitre = $model->getChapitreModule($this->id);	
			$this->dateInsert = $model->getDateInsert($this->id,$this->id_produit);	
			require_once('tmpl/default_module.php');
		}else{			
			require_once('tmpl/default_soumission.php');	
		}
	}else{header('Location: '.Router::base());}
	
		//$this->title=$lang->text('TITLE_ESPACEPRO_LOGIN');
		

		
		
}
function import($params=array())
	{
		
		$session=$this->session;	
		$user=$session->user;
		$lang=new Lang();
		$data=$_REQUEST;	
		$lang=$session->language;
		//$this->title=$lang->text('TITLE_ESPACEPRO_LOGIN');
		self::addMeta();	
		
		$this->layoutName='import';
		$this->id =$this->id_produit=$this->id_chapitre=0;
		if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
		if(isset($data['id_produit']) && is_numeric($data['id_produit']))$this->id_produit = $data['id_produit'];
		if(isset($data['id_chapitre']) && is_numeric($data['id_chapitre']))$this->id_chapitre= $data['id_chapitre'];
		if($user && $user->id>0){require_once('tmpl/default_import.php');}else{header('Location: '.Router::base());}
	
		
}
	function password($params=array()){
		$session= $this->session;
		$user_id=$session->user->id;
		$lang=new Lang();
		//$this->name='user';
		if($user_id){
			header('Location: '.Router::base().'admin-utilisateur');
		}
		$code=array();
		if(isset($_REQUEST['code']))$code=base64_decode($_REQUEST['code']);
		$code=explode('_',$code);
	
		if(count($code)!=3) {Router::setRedirect('404');}
		elseif(1){
			$model=new Espacepro();	
			
			$this->run=true;
			if((time()-$code[2])>(24*60*60))$this->run=false;
			if($this->run){
				$this->user=$model->getuserCode($code[0],$code[1]);
				if(!$this->user)Router::page(Router::base().'404');
			}
		}
		self::addMeta();
		require_once('tmpl/default_reset.php');
	}
	

	

	
	
	function utilisateur($params=array())
	{
		$session = $this->checkSession();
		$user=$session->user;
		$lang=$session->language;
		$data=$_REQUEST;
		if($user->id_role==1){
		$this->tab=true;
		$this->filtre=array();
		
		$model= new Espacepro();
		$this->limit_page=60;
		$this->page=1;
		if(isset($data['page']) && is_numeric($data['page']))$this->page=$data['page'];
		if(isset($data['nom']))$this->filtre['nom']=$data['nom'];
		$this->all=$this->allaffiche=$this->all1=$this->allaffiche1=array();
		$this->allaffiche= $model->getAllUser($this->filtre);	
		$this->role= $model->getRole();
		if(count($this->allaffiche)>0)
		{
			$p=($this->page-1)*$this->limit_page;
			if($p>count($this->allaffiche)){$this->page=1;$p=0;}
			
			$this->all=array_slice($this->allaffiche,$p,$this->limit_page);
			
		}
	
		$this->js[]=Router::root().'assets/js/chosen.jquery.js';
		$this->id=$this->new=0;
		if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
		if(isset($data['new']))$this->new =$data['new'];
		if($this->id > 0){
			$this->details = $model->detailsUser($this->id);	
		}
		$this->layoutName='utilisateur';
	require_once('tmpl/default_utilisateur.php');}
else{header('Location: '.Router::base());}
	}

	function ajoutmodule($params=array())
	{
		$session = $this->checkSession();
		$user=$session->user;
		$lang=$session->language;
		$data=$_REQUEST;
		
		$this->tab=true;
		$this->filtre=array();
		
		$model= new Espacepro();
		$this->limit_page=60;
		$this->page=1;
		if(isset($data['page']) && is_numeric($data['page']))$this->page=$data['page'];
		if(isset($data['nom']))$this->filtre['nom']=$data['nom'];
		$this->all=$this->allaffiche=array();
		$this->all= $model->getModule($this->filtre);
	
		
		$this->id=$this->new=0;
		
		if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
		if(isset($data['new']))$this->new =$data['new'];
		if($this->id > 0){
			$this->details = $model->detailsModule($this->id);	
		}
		$this->layoutName='ajoutmodule';
		require_once('tmpl/default_ajoutmodule.php');
	}
	

	
	function chapitre($params=array())
	{
		$session = $this->checkSession();
		$user=$session->user;
		$lang=$session->language;
		$data=$_REQUEST;
		
		$this->tab=true;
		$this->filtre=$this->js=$this->css=array();
		
		$model= new Espacepro();
		$this->limit_page=60;
		$this->page=1;
		if(isset($data['page']) && is_numeric($data['page']))$this->page=$data['page'];
		if(isset($data['nom']))$this->filtre['nom']=$data['nom'];
		if(isset($data['code']))$this->filtre['code']=$data['code'];
		$this->all=$this->allaffiche=array();
		$this->all= $model->getChapitre($this->filtre);		
		$this->module= $model->getModule();
	
		$this->js[]=Router::root().'assets/plugins/select/select2.min.js';
		$this->css[]=Router::root().'assets/plugins/select/select2.css';
		
		$this->id=$this->new=0;
		
		if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
		if(isset($data['new']))$this->new =$data['new'];
		if($this->id > 0){
			$this->details = $model->detailsChapitre($this->id);	
		}
		$this->layoutName='chapitre';
		require_once('tmpl/default_chapitre.php');
	}

	function qrcode($params=array()){
		$session = self::checkSession();
		$user = $session->user;
		$lang = $session->language;
		$data = $_REQUEST;
		$model = new Espacepro();
		 $this->qrcode=0;	
		if(isset($data['qrcode'])) $this->qrcode = $data['qrcode'];
		$this->layoutName='qrcode';
		if(isset($user->id) ){
		require_once('tmpl/default_qrcode.php');}
		else{header('Location: '.Router::base().'error');}
	}
	
	function dossier($params=array())
	{
		$session = $this->checkSession();
		$user=$session->user;
		$lang=$session->language;
		$data=$_REQUEST;
		
		$this->tab=true;
		$this->filtre=array();
		
		$model= new Espacepro();
		$this->limit_page=60;
		$this->page=1;
		if(isset($data['page']) && is_numeric($data['page']))$this->page=$data['page'];
		if(isset($data['nom']))$this->filtre['nom']=$data['nom'];
		$this->all=$this->allaffiche=array();
		$this->allaffiche= $model->getSpecialite($this->filtre);
		$this->module=$model->getModule();
		if(count($this->allaffiche)>0)
		{
			$p=($this->page-1)*$this->limit_page;
			if($p>count($this->allaffiche)){$this->page=1;$p=0;}
			$this->all=array_slice($this->allaffiche,$p,$this->limit_page);
			
		}
		
		
		$this->id=$this->new=0;
		
		if(isset($data['id']) && is_numeric($data['id']))$this->id = $data['id'];
		if(isset($data['new']))$this->new =$data['new'];
		if($this->id > 0){
			$this->details = $model->detailsFichier($this->id);	
		}
		$this->layoutName='dossier';
		require_once('tmpl/default_dossier.php');
	}

	
	function Error($params=array()){
		$lang=new Lang();
		$this->title=$lang->text('ESP_PAGE_INTROUVABLE');
		$this->meta=array();	
		$this->meta[]='<meta name="robots" content="noindex" />';
		require_once('tmpl/not_found.php');
	}
}