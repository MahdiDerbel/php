<?php 

class Table extends bd{
	var $table;
	function insert($values){
		foreach($values as $key=>$value){
					if(isset($this->$key))$insert[$key]=$this->quote($value);
				}				$keys=array_keys($insert);
				$values=array_values($insert);
				$sql="insert into ".$this->table." (`".implode('`,`',$keys)."`) values (".implode(',',$values).")";
				
				$this->setQuery($sql);
				$f=$this->execute();//die($sql);
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
				$myquery="SHOW COLUMNS FROM ".$this->table;//echo $myquery;
				$this->setQuery($myquery);
				$colun=array_keys($this->getLignes('Field'));
			if($update){
				$args=array();
				foreach($values as $key=>$value){
					if(property_exists ($this,$key)  && $key!=$primary  && in_array($key,$colun)){
						$args[]=' `'.$key.'` = '.$this->quote($value);$this->$key=$value;
						}
				}
			$args=implode(' , ',$args);
				$sql="update ".$this->table." set ".$args." where ".$primary."=".$this->quote($values[$primary]);
		
				$this->setQuery($sql);
				$this->id=$values[$primary];
			}else{
				$myquery="SHOW COLUMNS FROM ".$this->table;//echo $myquery;
				$this->setQuery($myquery);
				$colun=array_keys($this->getLignes('Field'));
				
				foreach($values as $key=>$value){
					if(isset($this->$key) && in_array($key,$colun)){
						if(!$value)
						$insert[$key]="''";
						else
						if($this->connection){
								$insert[$key]=$this->connection->quote($value);
						}else 	$insert[$key]=$this->quote($value);
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
	}
	function getId(){
	 return $this->id;	
	}
	
	function savemultiple($insert){
		//$db=parent::cnx(true);
		$elems=array();
		$i=0;
				foreach($insert as $values ){
					foreach($values as $key=>$value){
						if(isset($this->$key)){
							$elems[$i][$key]=$this->quote($value);
							$this->$key=$value;
						}
						
					}	
					$i++;
				}
				$keys=array();
				if(count($elems)>0){
				foreach(array_keys($elems[0]) as $i){
					$keys[]='`'.$i.'`';//$this->quote($i);
				}
				$stringelem=array();
			
				foreach($elems as $elem){
						$values=array_values($elem);
					$stringelem[]='('.implode(',',$values).')';
					
				}
				if(count($keys)>0){
				$sql="insert into ".$this->table." (".implode(',',$keys).") values ".implode(',',$stringelem);

				$this->setQuery($sql);
				$f=$this->bind();
				}}
				 return;
				
	}
	
}