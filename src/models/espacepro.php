<?php 
class Espacepro extends bd{
	
	function getUserCode($email,$code){
		$sql="select 	* from #__user where email like ".$this->quote($email)." and activation like ".$this->quote($code);//die($sql);
		$this->setQuery($sql);
		$lines=$this->getLine();
		return $lines;	
	}
	
	
	function getUtilisateur($filtre=array())
	{
		$query =" SELECT u.* FROM #__user u where groupe=1 " ; 
		$this->setQuery($query);
		$this->liste = $this->getLignes('id');
		return $this->liste;
	}
		
	function getRole()
	{
		$query =" SELECT g.* FROM #__Role g  " ; 
		$this->setQuery($query);
		$this->liste = $this->getLignes('id');
		return $this->liste;
	}
	
	function detailsUtilisateur($id)
	{
		$query = 'SELECT * FROM #__user WHERE id = '.intval($id);				  
		$this->setQuery($query);
		$return = $this->getLine();
		return $return;
	}

	public function getAllUser($filtre=array()){
		$sql = "select * from #__user  ";
		$condition=array();
		if(count($filtre)>0)
		foreach($filtre as $key=>$value)
		switch(trim(strtolower($key))){
		   case 'nom':$condition[]=' nom_prenom like '.$this->quote('%'.$value.'%');break;	
		}
		if(count($condition)>0)$sql.=' where  '.implode(' and ',$condition);
		$sql.=" order by id desc";
		$this->setQuery($sql);
		$this->data = $this->getLignes('id'); 
		 return $this->data;
   
   }
   
public function getModule($filtre=array()){
	$sql = "select * from #__module  ";
	$condition=array();
	if(count($filtre)>0)
	foreach($filtre as $key=>$value)
	switch(trim(strtolower($key))){
	   case 'nom':$condition[]=' nom like '.$this->quote('%'.$value.'%');break;	
	}
	if(count($condition)>0)$sql.=' where  '.implode(' and ',$condition);
	$sql.=" order by id asc";
	$this->setQuery($sql);
	$this->data = $this->getLignes('id'); 
	 return $this->data;

}
	
public function getChapitre($filtre=array()){
	$sql = "select * from #__chapitre  ";
	$condition=array();
	if(count($filtre)>0)
	foreach($filtre as $key=>$value)
	switch(trim(strtolower($key))){
		case 'nom':$condition[]=' nom like '.$this->quote('%'.$value.'%');break;	
		case 'code':$condition[]=' code like '.$this->quote('%'.$value.'%');break;	
	}
	if(count($condition)>0)$sql.=' where  '.implode(' and ',$condition);
	$sql.=" order by id desc";
	$this->setQuery($sql);
	$this->data = $this->getLignes('id'); 
	 return $this->data;

}
public function getDateInsert($id,$id_produit){	
	$sql = 'SELECT * FROM #__fichier WHERE id_produit='.intval($id_produit).' and id_module = '.intval($id).' order by id desc';
	$this->setQuery($sql);
	$items=$this->getLine();
	return $items;	
}
public function getDateInsertChapitre($id,$id_produit){	
	$sql = 'SELECT * FROM #__lignefichier WHERE id_produit='.intval($id_produit).' and id_chapitre = '.intval($id).' order by id desc';
	$this->setQuery($sql);
	$items=$this->getLine();
	return $items;	
}
function getSpecialite(){
	$sql="select * from #__specialite ";
	$this->setQuery($sql);
	$items=$this->getLignes('id');//die(print_r($items));
	return $items;	
}		
public function getDetailsChapitreModule($id,$id_produit){	
	$sql = 'SELECT * FROM #__lignefichier WHERE id_produit='.intval($id_produit).' and id_chapitre = '.intval($id).' order by id desc';
	$this->setQuery($sql);
	$items=$this->getLignes();
	return $items;	
}
function getDetailsSpecialite($id){
	$sql="select * from #__specialite  WHERE id = ".$id;
	$this->setQuery($sql);
	$items=$this->getLine();//die(print_r($items));
	return $items;		
}
public function detailsUser($id){	
	$sql = 'SELECT * FROM #__user WHERE id = '.intval($id);
	$this->setQuery($sql);
	$items=$this->getLine();
	return $items;	
}
public function getChapitreModule($id){	
	$sql = 'SELECT * FROM #__chapitre WHERE id_module = '.intval($id);
	$this->setQuery($sql);
	$items=$this->getLignes();
	return $items;	
}

public function detailsModule($id){	
	$sql = 'SELECT * FROM #__module WHERE id = '.intval($id);
	$this->setQuery($sql);
	$items=$this->getLine();
	return $items;	
 }

public function detailsChapitre($id){	
	$sql = 'SELECT * FROM #__chapitre WHERE id = '.intval($id);
	$this->setQuery($sql);
	$items=$this->getLine();
	return $items;	
 }	
	public function getFile($filtre=array()){
		 $sql = "select * from #__fichier   ";
		 $condition=array();
		 if(count($filtre)>0)
		 foreach($filtre as $key=>$value)
		 switch(trim(strtolower($key))){
			case 'nom':$condition[]=' nom like '.$this->quote('%'.$value.'%');break;
			case 'reference':$condition[]=' reference like '.$this->quote('%'.$value.'%');break;	
			case 'date':$condition[]=' date = '.$this->quote($value);break;	
		 }
		 if(count($condition)>0)$sql.=' where '.implode(' and ',$condition);
		 $sql.=" order by id desc";
         $this->setQuery($sql);
         $this->data = $this->getLignes('id'); 
     	 return $this->data;
	
	}
	
	public function detailsFichier($id){
		$sql = "select * from #__fichier where id = ".intval($id);
		$this->setQuery($sql);
		$items=$this->getLine();
		return $items;	
	}
}