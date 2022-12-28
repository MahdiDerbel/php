<?php 

class Session {
	
	
	public $session_id='';
	var $session_live='3600';
	var $lang=0;
	var $language=false;
	var $user_id=0;
	var $pharmacien=false;
	var $user=false;
	var $pharmacien_id=0;
	
	function __Construct($lang=false,$a=false){	


		if(!$lang && $lang!='0'){ $this->lang=Router::currentLang(false);}else { $this->lang=$lang;}
		if(!is_numeric($this->lang)) $this->lang=Router::currentLang(false);
		$this->language=new Lang($lang);
		$this->session_id=session_id();
		if(!$this->user)$this->user=self::UserInfo($this->user_id); 

	}
	

	function UserInfo($user_id){
		$db=new bd();
		$sql="select * from #__user where   session_id=".$db->quote(self::getSession());
		$db->setQuery($sql);
		$item=$db->getLine();
		return $item;
	}
	
	function logout(){
		$db=new bd();
		$sql="update #__user set session_id='' where session_id=".$db->quote(self::getSession());
		$db->setQuery($sql);
		$db->execute(); 
		 session_unset() ;
		 session_destroy();
		 //session_regenerate_id (true);
	}

	function setValue($elem,$value){
		$this->$elem=$value;	
	}

	 function getValue($elem){
		
		return $this->$elem;	
	}
	function getSession(){
		return session_id();
		/*if(isset($_COOKIE['PHPSESSID']))return $_COOKIE['PHPSESSID'];
	elseif($this->session_id=='')return session_id();
	else return $this->session_id;	*/
		}
	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

	
}
