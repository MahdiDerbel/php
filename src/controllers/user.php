<?php 
require_once(JPATH_CORE.'/PHPMailer/mail.php');
class UserController extends Session{
	function connect(){
		$lang=new Lang();

		$data=$_REQUEST;
		if($this->user_id==0 && filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			$db=new bd();
			$sql="select * from #__user where  email=".$db->quote($data['email'])." and password=".$db->quote(md5($data['password']));
			$db->setQuery($sql);
			$item=$db->getLine();
			
			if($item ){
				if($item->etat==1){
				$this->user_id=$item->id;
				$sql="update #__user set derniere_visite=".$db->quote(date('Y-m-d H:i:s')) .", session_id=".$db->quote($this->getSession())." where id=".intval($this->user_id);
				$db->setQuery($sql);
				$db->execute();
				
				
				Router::page(Router::base().'admin-dossier');
				}else{
					Router::page(Router::base(),$lang->text('ESP_VOTRE_COMPTE_EST_BLOQUE'),'warning');
				}
			}else{
	
				Router::page(Router::base(),$lang->text('ESP_COORDONNEE_ERROR',Router::base()),'error');
			}
		}else {
		
			Router::page(Router::base(),$lang->text('ESP_FORMAT_MAIL_INVALIDE',Router::base()),'error');
		}
	}
	function logout(){
		parent::logout();
			Router::page(Router::base());	
	}
	
	function  generateconde($limit){
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_!?;.,';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $limit; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); 
	}
	
	function resetpassword(){
		$data=$_REQUEST;
		$url='index';
		$lang=$this->language;
		$msg=$lang->text('ESP_VERIF_DONNEE');$type='error';
		if(isset($data['password1']) && isset($data['password2']) && trim(isset($data['password1']))!='' && isset($data['password1'])==isset($data['password2'])){
			$email=base64_decode($data['code']);
			$db=new bd();
			$sql="select * from #__user where email=".$db->quote($email);
			$db->setQuery($sql);
			$user=$db->getLine();
		
			if(!$user){
				$msg=$lang->text('ESP_USER_NOT_EXIST');
			}else{
				$insert=array('id'=>$user->id,'activation'=>'','password'=>md5($data['password1']));
				$table=new TableUser();
				$table->save($insert,'id');
				$msg=$lang->text('ESP_MOD_PASSE_MODIFIER');$type='success';			
			}
		}
		Router::page($url,$msg,$type);
	}
	
	function forgetpassword(){
		/*Enviyer code actiation si user exist*/
		$data=$_REQUEST;
		$lang=$this->language;
		$msg=$lang->text('ESP_VERIF_DONNEE');$type='error';
		$url=Router::base();
		if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			$db=new bd();
			$sql="select * from #__user where email like ".$db->quote($data['email']);//die($sql);
			$db->setQuery($sql);
			$line=$db->getLine();
			
			if($line){
				$c=new Config();
				$activation=self::generateconde(9);
				$link=Router::base().'reset/?code='.base64_encode($data['email'].'_'.$activation.'_'.time());
				//die($activation.'<br />'.$link);
				$siteName=$c->fromname;
				$content="Vous avez demandé à recevoir cet email afin de réinitialiser votre mot de passe associé à votre compte cidco.</div><div style='margin:4px; text-align:justify;'>Si vous n’êtes pas à l’origine de cette demande, nous vous prions d’ignorer cet email.</div> <div style='margin:4px; text-align:justify;'>Si vous en êtes à l’origine, veuillez tenir compte des instructions suivantes.
Afin de réinitialiser votre mot de passe, nous vous invitions à cliquer sur le bouton ci-dessous :</div> <div style='margin:4px; padding:10px; border-top:1px solid #f1f1f1; text-align:justify;'><center><a style='display:inline-block; padding:10px; width:280px;font-size:15px; color:#fff; background:#ed1c24; ' href='".$link."'>Je réinitialise mon mot de passe</a></center></div><div style='margin:4px; text-align:justify;'>Si le bouton semble ne pas fonctionner, copiez le lien suivant et collez-le dans la barre d’adresse de votre navigateur : <span style='color:#5F5F5F'>".$link."</span></div></div><div style='margin:2px; text-align:justify;'>Vous serez redirigé vers <span style='color :#ed1c24'>".$siteName." </span>et vous pourrez ainsi modifier votre mot de passe en toute sécurité.</div> <div style='margin:4px; text-align:justify;'>Pour des questions de sécurité, le lien est valide pendant une durée maximale de 24h, passé ce délai vous devrez faire une nouvelle demande.<br /><br /><br />Merci pour votre confiance. <br />À bientôt sur <span style='color :#ed1c24'>".$siteName."</span><br />L'équipe <span style='color :#ed1c24'>".$siteName."</span> </div></div></center>";
		
			$mail = new PHPMailer(true);   
		 $body="<center><div style='width:780px; padding:10px; background:#fff; line-height:24px; border:2px solid #ED1C24; '><img src='".Router::base()."media/logo.png' /><div style='text-align:left; margin:20px 0 0;'>Bonjour  ".$line->nom.",<br /> <div style='margin:4px; text-align:justify;'>".$content;
					$user=new TableUser();
					$insert=array('id'=>$line->id,'activation'=>$activation);
					$user->save($insert,'id');die($body);
			try {
				$mail->setFrom($c->emailfrom);
				   
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject =$lang->text('SUBJECT_MAIL_RENIT');
				$mail->Body    = $body;
				$mail->CharSet='utf-8';
				$mail->addAddress($line->email);
				$mail->send();	
				$user=new TableUser();
					$insert=array('id'=>$line->id,'activation'=>$activation);
					$user->save($insert,'id');
				$msg=$lang->text('ESP_SUCCESS_ENVOIE_MAIL');$type='succes';	
			} catch (Exception $e) {$msg=$lang->text('ESP_EHEC_SEND_MAIL').var_dump($b); 	$type="warning";}
			}else{
				$msg=$lang->text('ESP_USER_NOT_EXIST');	
			}
		}else{
			$msg=$lang->text("ESP_VERIF_FORMAT_MAIL");
		}
		Router::page($url,$msg,$type);
	}
	
	function getUsernameLogin() {
	
		$session=$this->checksessin();
		 $message='' ; 
		 $db=new bd();
		 $data = $_REQUEST;
		/*if(isset($data['username'] ) && trim($data['username'] )!=''){
			 if(strip_tags($data['username'] )==$data['username'] ){
		  $username= $data['username']  ; 
		 $sql = "select *  from #__user where  username = ".$db->quote($username);
		 if(isset($data['id']) && is_numeric($data['id']) && $data['id']>0)$sql.= " and id !=".intval($data['id']);
         $db->setQuery($sql);
		 $requser = $db->getLignes(); 
		 if ($requser && count($requser) >'0')  $message .='1' ; 	
			 }	
		 }else  $message .='1' ; */
		 if(isset($data['email'] ) && trim($data['email'] )!='' ){
			 if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
				  $email= $data['email']  ;
				 $sql2 = "select *  from #__user where  email = ".$db->quote($email);
				 if(isset($data['id']) && is_numeric($data['id']) && $data['id']>0)$sql2.= " and id !=".intval($data['id']);
				 $db->setQuery($sql2);
				 $requser2 = $db->getLignes(); 
				 if ($requser2 && count($requser2) >'0')  $message .='2' ;  
			 }
		 }else $message .='2' ; 
		die(''.$message) ; 
	}
	
	
	function getUsername() {
		
		 $session=$this->checksessin();	
		 $message='' ; 
		 $db=new bd();
		 $data = $_REQUEST;
		 $lang=$session->language;
		 if(isset($data['email'] ) && trim($data['email'] )!='' ){
		 $username= $data['email']  ; 
		
		$sql = "select *  from #__user where  email = ".$db->quote($username);
		 if(isset($data['id']) && is_numeric($data['id']) && $data['id']>0)$sql.= ' and id !='.intval($data['id']);
         $db->setQuery($sql);
		 $requser = $db->getLignes(); 
		 if ($requser && count($requser) >'0') {$message .='2'; 	}
		 }
		die(''.$message) ; 
	}
	
	function getEmail() {
	$session=$this->checksessin();
	$lang=$session->language;
		 $message='' ; 
		 $data = $_POST;
		 if(isset($data['email']) && trim($data['email'])!='' && filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
		 $db = new bd();
		 $sql = "select *  from #__user where  email = ".$db->quote($data['email']);
		 if(isset($data['id']) && is_numeric($data['id']) && $data['id']>0)$sql.= ' and id !='.intval($data['id']);
         $db->setQuery($sql);
		 $requser = $db->getLignes(); 
		 if ($requser && count($requser) >0) 	{ $message .=''.$lang->text('ESP_EMAIL_EXISTE');} 
			 
		}
		die(''.$message) ; 
	}
	
	function saveClient(){
		$session=$this->checksessin();
		$data=$_REQUEST;
		$lang=$session->language;
			$type='error';$msg=$lang->text('ESP_VERIF_DONNEE');
			if(isset($data['id']) && is_numeric($data['id']) && $data['id']>0){
			
			$sql = "select * from #__user where  id =".intval($data['id']) ;
			$this->setQuery($sql);
			$reqUser = $this->getLigne();
			 if($reqUser){
			 if($reqUser->password!=$data['password'] )  {  $data['password']=md5($data['password']);   }
			  else { $data['password'] =$data['password'];  }			
			
			$data['name']='Client' ;					
			$row = new TableUser();
			$row->save($data);
			$msg=$lang->text('ESP_UTILISATEUR_ENREGISTREE');$type=true;
			 }else {$msg=$lang->text('ESP_USER_INTROUVABLE');}
		
			}
		Router::page(Router::base().'espacepro-configuration',$msg,$type);
		}
		
		
		function deleteUtilisateur(){
			$session=$this->checksessin();
		$data=$_REQUEST;
		$db=new bd();
		$lang=$session->language;
		$type='error';$msg=$lang->text('ESP_VERIF_DONNEE');
		if(isset($data['id'])  ){
			$id=false;
		if(is_numeric($data['id']) && $data['id']>0)$id=intval($data['id']);
		else if(is_array($data['id']))$id=implode(',',$data['id']);
		if($id){
			$sql="select * from #__user where id in(".$id.")";
			$db->setQuery($sql);
			$this->data = $db->getLignes();
			if($this->data){
				$sql="delete from #__user where id in(".$id.")";
				$db->setQuery($sql);
				$msg=$lang->text('ESP_UTILISATEUR_SUPPRIMER');$type='success';
			}else $msg=$lang->text('ESP_USER_INTROUVABLE');
		}
			
		}
			Router::page(Router::base().'admin-utilisateur',$msg,$type);
		}
		
		function construire_mail($echo){
			$session=new Session();
			$lang=$session->language;
			$config = new Config();
			 $body = '<table style="width:600px;padding:20px; font-family:calibri;  margin:0 auto; color:#263476; border:1px solid rgb(0, 165, 231);"><tr><td colspan="3" style="text-align:center;"><img src="'.Router::root().'media/logo.png" alt="'.$config->sitename.'" width="150" /></td></tr>';
			$body .= $echo;
			$body .= '<tr><td colspan="3" style="padding:20px 0;"></td></tr>';
			$body .= '<tr><td colspan="4" style="padding-top:15px;text-align:center; font-size:12px; border-top:1px dashed rgb(0, 165, 231); ">'.$lang->text('FOOTER_MAIL').'</td></tr>';
			$body .= '</table>';
			return $body;
		}
		
		
		function saveUtilisateur(){
			$session=$this->checksessin();
			$data=$_REQUEST;
			$db=new bd();
			$lang=$session->language;
			
			$type='error';$msg=$lang->text('ESP_VERIF_DONNEE');
			if(isset($data['email']) && trim($data['email'])!='' && filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			$reqUser=false;
			$data['date_inscript']=date("Y-m-d H:i");
			if(isset($data['id']) && is_numeric($data['id']) && $data['id']>0){
				$sql = "select * from #__user where  id =".intval($data['id']) ;
				$db->setQuery($sql);
			 	$reqUser = $db->getLine();			
			}
			
			if($reqUser==false){
			if( trim($data['password'])!=''){
				$password=$data['password'];
				$data['password'] =md5($data['password']); 
			}}
			else
			{
				if(trim($data['password'])!='' && md5($data['password'])!=$reqUser->password){
					$password=$data['password'];
					$data['password'] =md5($data['password']); 
			}
			else{$data['password']=$reqUser->password;}
			}
				$table=new TableUser();
				$table->save($data);
				$msg=$lang->text('ESP_UTILISATEUR_ENREGISTREE');
				$type='success';
				
			
		
		
				}
			
			
		 Router::page(Router::base().'admin-utilisateur',$msg,$type);
		}
		
		
		
	function checksessin(){
		$session=new Session();
		if(!$session->user)Router::page(Router::base());
		return $session;
	}
}