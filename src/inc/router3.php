<?php

 class Router{

	public $url;
	public $msg="";
	public $type="";
	public $view=array();
	public $controllers=array();
	public $session=false;
	public $user=false;
	public $multilang=true;
	public $current_lang=0;
	public function __Construct(){
		$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' ); 
		//$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );die($uri);
		$uri=$this->str_replace_first( $uri,'',$_SERVER['REQUEST_URI']);
		$uri = urldecode( $uri );
		$tab = explode('?',$uri); 
		$this->url= $tab[0];	
		if($this->multilang ){
			$tab=explode('/',$uri);
			unset($tab[0]);
			$tab=array_values($tab);
			 if(count($tab)>0 && !isset($_REQUEST['task'])){
			$tab2=$tab;
			unset($tab2[0]);
			$tab2=array_values($tab2);
			$_REQUEST=array_merge($tab,$_REQUEST);
		   
		   }
		}
		if($this->multilang && count($tab)>=1){
			$file=array(0=>'fr',1=>'en');
			if(isset($tab[0]) && !is_numeric($tab[0])){
				if($key=array_search($tab[0],$file))$this->current_lang=$key;
				else if(count($tab)==1){
					Router::page(Router::base().$tab[0]);
				}
			}			
		
		
	
		$params = explode("/", $tab[0]);
		
	
		if(isset($tab[2]))$_REQUEST['id'] = $tab[2]; 
		
		
		
		}
	//	die(print_r(Session::startsession($this->current_lang)));
//if(!is_numeric($this->current_lang))die('h**'.$this->current_lang);
		$this->session=new Session($this->current_lang);//die(print_r($this->session));
		$this->user=$this->session->user;
	}	
	function str_replace_first($from, $to, $subject)
	{
		$from = '/'.preg_quote($from, '/').'/';
		return preg_replace($from, $to, $subject, 1);
	}


	static function currentLang($path=true){
		return '';
		$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' );
		$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
		$uri = urldecode( $uri );
		$tab = explode('?',$uri);
			$tab=explode('/',$uri);
			unset($tab[0]);
			$tab=array_values($tab);
		if(count($tab)>0){
			$file=array(0=>'fr',1=>'en',2=>'es');
			if(isset($tab[0]) && !is_numeric($tab[0])){
				if($key=array_search($tab[0],$file))
				if(!$path) return $key; else 	return $file[$key].'/';
			}
		}
		if(!$path)return 0;else return 'fr';
	}
	public function display($params=array()){
		//if(!$this->session)$this->startsession();
		if(isset($_SESSION['msg'])){
			$params['msg']=$_SESSION['msg'];	
			$params['type']=$_SESSION['type'];
			unset($_SESSION['msg']);
			unset($_SESSION['type']);	
		}
		$fic_tmp = explode( "/", $this->url );
		unset($fic_tmp[0]);
		$parametres=array_values($fic_tmp);
		
		$controler=false;
		$index=0;
		if($this->multilang)$index=1;
		
		if(isset($parametres[$index]))$controler=$parametres[$index];
		
		//if(isset($fic_tmp[3])
		$view=false;
		

		if( isset($_REQUEST['task']) ){
		
			$namecontroler=$parametres[$index];
			if(isset($_REQUEST['task'])){
				$go=true;
					$nameaction=$_REQUEST['task'];
					if($nameaction!='connect' && $nameaction!='decnx'){
						
						if($this->session->user_id==0) $go= false;
					}
				$file=JPATH_CONTROLLERS.'/'.$namecontroler.'.php';
				require_once $file;
				
				$classname=$namecontroler.'Controller';
				$contoller= new $classname();
				if(method_exists($contoller,$nameaction)){
					$contoller->$nameaction();
					
				}else $go= false;
				if(!$go)	{
					$params['session']=$this->session;
					$view=new View('404',$params);
					//$view=view::search('404',$params);
				}
			}
			
		}else{
			
			$alias='';
			if(isset($parametres[$index]))$alias=$parametres[$index];
			$params['session']=$this->session;//die(print_r($params));
			$view=new View($alias,$params);
			//$view=view::search($alias,$params);
			// if(!$view){$view=view::search('404',$params);}
		 
		}
	}
	
	
	static function page($page,$msg='',$type=''){//die($page);
		unset($_REQUEST['task']);
		
		if($page=='index'){
			$page=self::base();
			//$this->url='';
		}else{
		
		/*	if(strpos ($page,'http://') !== false && strpos ($page,'https://') !== false){}else{$page=self::base().$page;}*/
		
			
		}
		if(trim($msg)!=''){
		$_SESSION['msg']=$msg;
		$_SESSION['type']=$type;
		}
		
		header('Location: '.$page);
	}
	function setRedirect($url){
		if($url=='index') $url=self::base();
			if(strpos ($url,'http://') !== false && strpos ($url,'https://') !== false){}else{$url=self::base().$url;}
		header('Location: '.$url);
	}
	static function base(){
		  $currentPath = $_SERVER['PHP_SELF']; 
  
		// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
		$pathInfo = pathinfo($currentPath); 
		 
		// output: localhost
		$hostName = $_SERVER['HTTP_HOST']; 
		
		// output: http://echo 
		//$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https://':'http://';
		//$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
		 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$lang=self::currentLang();
		
		// return: http://localhost/myproject/
		//return $protocol.$hostName.$pathInfo['dirname']."/".$lang;
		$url= $protocol.$hostName.$pathInfo['dirname'].'/'.$lang;//."/";//.$lang;//."/";
		if($url[(strlen($url)-1)]!='/')$url.='/';
		return $url;
	}
	
	static function root(){
		  $currentPath = $_SERVER['PHP_SELF']; 
  
		// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
		$pathInfo = pathinfo($currentPath); 
		 
		// output: localhost
		$hostName = $_SERVER['HTTP_HOST']; 
		
		// output: http://
		//$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https://':'http://';
	//	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		// return: http://localhost/myproject/
		$url= $protocol.$hostName.$pathInfo['dirname'];//."/";
		if($url[(strlen($url)-1)]!='/')$url.='/';
		return $url;
	}
	static function getSegment1(){
	  $uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' ); 
	  //$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );die($uri);
	  $uri=self::str_replace_first( $uri,'',$_SERVER['REQUEST_URI']);
	  $uri = urldecode( $uri );
	  $tab = explode('?',$uri); 
	  $tab=explode('/',$uri); 
	  if(strpos($tab[1], '?'))$tab=explode('?',$tab[1]);
	  $index=1;  
	 // if($this->multilang)$index=1;
	  if(count($tab)>$index){
	   for($i=0;$i<=$index;$i++){
		if(trim($tab[$i])=="")unset($tab[$i]);
	   }
	   $tab=array_values($tab);
	   
	   return $tab;
	  }else return array();
	 }
	function CurrentPath(){
		$url=$_SERVER['PHP_SELF'];
		return $url;
	}
}