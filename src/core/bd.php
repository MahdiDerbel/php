<?php 
class bd extends Config{
	var $query;
	var $id=0;
	private   $connection=false;
	public function __construct(){
		try {
			$pdo = new PDO('mysql:host='.$this->host_name.';dbname='.$this->db_name,  $this->username,$this->password_db);
			//$pdo = new PDO('mysql:host=mysql51-41.pro;dbname=wemdevnews',  'wemdevnews','t7Vu6rP3');
		//	$pdo->query("SET NAMES UTF8");
			$this->connection= $pdo;
		} catch(PDOException $e) {
			echo 'OERROR: ' . $e->getMessage();
		}
	}
	public function getId(){
	 return $this->id;	
	}
	public function cnx() 
    {
		try {
			$c=new Config();
			$pdo = new PDO('mysql:host='.$c->host_name.';dbname='.$c->db_name,  $c->username,$c->password_db);
			//$pdo->query("SET NAMES UTF8");
			//$pdo = new PDO('mysql:host=mysql51-41.pro;dbname=wemdevnews',  'wemdevnews','t7Vu6rP3');
			$this->connection= $pdo;
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
    }
	
	function quote($string){
		 if(!$this->connection)self::cnx(); 	
		 return $this->connection->quote($string); 
	}
	function setQuery($sql){
		
		if(!$this->connection)self::cnx();
		//$pdo= self::cnx();
		$sql=str_replace('#__',$this->prefix,$sql);
		$this->query=$this->connection->prepare($sql);
		$id=$this->query->execute();
	 //die(print_r( $this->query->fetchAll(PDO::FETCH_OBJ)));
	//
		
	}
	function closedpo(){
		$this->query->closeCursor();
	}
	function getQuery(){
		return $this->query;	
	}
	function execute(){
		//$pdo= self::cnx();
		if(!$this->connection)self::cnx();
		$f=$this->connection->exec($this->query->queryString);
		return $f;
	}
	function bind(){
		//$pdo= self::cnx();
		if(!$this->connection)self::cnx();
		$id= $this->connection->lastInsertId();
		return $id;
	}
	function delete($table,$condition=array()){
	
		//$pdo= self::cnx();
		if(!$this->connection)self::cnx();
		$sql="delete from ".$this->prefix.$table;
		if(count($condition)>0)$sql.=" where  ".implode(',',$condition); 
		$f=$this->connection->exec($sql);
		return $f;
	}
	 function getLine(){
		$row=$this->query->fetch(PDO::FETCH_OBJ);
		return $row;
	}
	 function getLignes($sort=''){
		$data=array();
		while($row=$this->query->fetch(PDO::FETCH_OBJ)){
			if($sort=='')$data[]=$row;
			else $data[$row->$sort]=$row;
		}
		return $data;
	}
	
	function simplify($name){
		setlocale(LC_ALL, 'fr_FR');

		$name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
		$name=strtolower($name);
		$name=str_replace(array('-','/','\\','&','.','-',','),'',$name);
		$name=str_replace(array(' ',"'",'"'),'_',$name);
		$name=str_replace(array('!','?'),'',$name);
		$name=str_replace(array('é','è','È','É','Ê','Ë','ê','ë','é'),'e',$name);
		$name=str_replace(array('à','À','Á','Â','Ã','Ä','Å','á','â','ã','ä','å','Ã','Ã¢','Ã?','Ã?'),'a',$name);
		$name=str_replace(array('Ç','ç','Ã§','Ã?'),'c',$name);
		$name=str_replace(array('Ì','Í','Î','Ï','ì','í','î','ï'),'i',$name);
		$name=str_replace(array('Ò','Ó','Ô','Õ','Ö','ð','ò','ó','ô','õ','ö'),'o',$name);
		$name=str_replace(array('Ù','Ú','Û','Ü','ù','ú','û','ü'),'u',$name);
		return $name;
	}
	

function save($values,$primary='id'){

		$insert=array();
		if(count($values)){
			
			$update=false;
			if(isset($values[$primary]) && $values[$primary]!=''){
				$sql="select * from ".$this->table." where ".$primary."=".$this->quote($values[$primary]);
				$this->setQuery($sql);
				$r=$this->getLine();
				if($r)$update=true;
			}
			if($update){
				$args=array();
				foreach($values as $key=>$value){
					if(property_exists ($this,$key)  && $key!=$primary ){$args[]=' `'.$key.'` = '.$this->quote($value);$this->$key=$value;}
				}
			$args=implode(' , ',$args);
				$sql="update ".$this->table." set ".$args." where ".$primary."=".$this->quote($values[$primary]);
		
				$this->setQuery($sql);
				$this->id=$values[$primary];
			}else{
				
				foreach($values as $key=>$value){
					if(isset($this->$key)){
						$insert[$key]=$this->quote($value);
						$this->$key=$value;
					}
					
				}	
				$keys=array();
				foreach(array_keys($insert) as $i){
					$keys[]='`'.$i.'`';//$this->quote($i);
				}
				
				$values=array_values($insert);
				if(count($keys)>0){
				$sql="insert into ".$this->table." (".implode(',',$keys).") values (".implode(',',$values).")";

				$this->setQuery($sql);
				$f=$this->bind();
				
				$this->id=$f;
				
				}
			}
		}
	
		return ;
	}}