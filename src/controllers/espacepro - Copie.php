
<?php
require_once(JPATH_CORE . '/media.php');
require_once(JPATH_PLUGINS . '/fpdi/src/autoload.php');
require_once(JPATH_PLUGINS . '/fpdf/fpdf.php');
require_once(JPATH_PLUGINS . '/fpdi/src/Fpdi.php');
require_once(JPATH_PLUGINS . '/fpdi/src/FpdfTpl.php');
require_once(JPATH_PLUGINS . '/fpdi/src/FpdiTrait.php');
class EspaceproController extends bd
{
	function checksessin()
	{
		$session = new Session();
		if (!$session->user) Router::page(Router::base() . 'espaceadmin');
		return $session;
	}
	function generermdp($longueur = 8)
	{
		$mdp = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		$longueurMax = strlen($possible);
		if ($longueur > $longueurMax) {
			$longueur = $longueurMax;
		}
		$i = 0;
		while ($i < $longueur) {
			// prendre un caractère aléatoire
			$caractere = substr($possible, mt_rand(0, $longueurMax - 1), 1);

			// vérifier si le caractère est déjà utilisé dans $mdp
			if (!strstr($mdp, $caractere)) {
				// Si non, ajouter le caractère à $mdp et augmenter le compteur
				$mdp .= $caractere;
				$i++;
			}
		}
		return $mdp;
	}

	/***************** saveficher *****************/

	function saveligneficher()
	{
		$this->checksessin();
		$data = $_REQUEST;
		$lang = new Lang();
		$msg = $lang->text('ESP_ECHEC_SAVE');
		$type = 'error';
		$url = Router::base();
		$item = false;
		$book = true;
		die(print_r($data));

		$sql = "select * from #__chapitre where id_module=" . intval($data['id_module']);
		$this->setQuery($sql);
		$this->chapitre = $this->getLignes('code');

		if ($data['id_module'] > 0) {
			$files = scandir("./media/module");
			$table = new TableFichier();
			$table->save($data, 'id');
			$id = $table->getId();
			if (count($files) > 0) {
				foreach ($files as $f) {
					$nb = strlen($f) - 4;
					$nom = substr($f, 0, $nb);
					if (isset($this->chapitre[$nom])) {
						$array = array('date' => date('Y-m-d'), 'id_module' => $data['id_module'], 'id_chapitre' => $this->chapitre[$nom]->id, 'fichier' => $f, "id_fichier" => $id);
						$table = new TableLigneFichier();
						$table->save($array, 'id');
					}
				}
			}
		} else {
			$table = new TableLigneFichier();
			$table->save($data, 'id');
			$id = $table->getId();
		}
		if ($id > 0) {
			$msg = $lang->text('ESP_ENREGISTRER');
			$type = "success";
			$url .= '?id=' . $id;
		}
		if ($data['id_module'] > 0) die("1");
		else {
			die("2");
		}
	}


	function saveficher()
	{
		$this->checksessin();
		$data = $_REQUEST;
		$lang = new Lang();
		$msg = $lang->text('ESP_ECHEC_SAVE');
		$type = 'error';
		$url = Router::base();
		$item = false;
		$book = true;

		if ($book) {
			$data['date'] = date('Y-m-d');

			if (trim($_FILES['fichier']['name']) != '') {
				$data['fichier'] = Media::upload('fichier', array('pdf'), 'media/files');
				if ($data['fichier'] != '') {
					$uploadPath = 'media/files/' . $data['fichier'];
				}
			}

			$sql = "select * from #__chapitre where id_module=" . intval($data['id_module']);
			$this->setQuery($sql);
			$this->chapitre = $this->getLignes('code');

			if ($data['id_module'] > 0) {
				$files = scandir("./media/module");
				$table = new TableFichier();
				$table->save($data, 'id');
				$id = $table->getId();
				if (count($files) > 0) {
					foreach ($files as $f) {
						$nb = strlen($f) - 4;
						$nom = substr($f, 0, $nb);
						if (isset($this->chapitre[$nom])) {
							$array = array('date' => date('Y-m-d'), 'id_module' => $data['id_module'], 'id_chapitre' => $this->chapitre[$nom]->id, 'fichier' => $f, "id_fichier" => $id);
							$table = new TableLigneFichier();
							$table->save($array, 'id');
						}
					}
				}
			} else {
				$data['date']=date('Y-m-d');
				$table = new TableLigneFichier();
				$table->save($data, 'id');
				$id = $table->getId();
			}
			if ($id > 0) {
				$msg = $lang->text('ESP_ENREGISTRER');
				$type = "success";
				$url .= '?id=' . $id;
			}
		}
		if ($data['id_module'] > 0) die("1");
		else {
			die("2");
		}
	}


	function deleteimage()
	{
		$data = $_GET;
		$session = $this->checksessin();
		$lang = new Lang();
		$ty = '';
		$type = "error";
		$msg = $lang->text('ESP_VERIF_DONNEE');
		if (isset($data['id']) && is_numeric($data['id'])) {
			$insert['fichier'] = '';
			$insert['id'] = $data['id'];

			$sql = "select * from #__fichier where id=" . intval($data['id']);
			$this->setQuery($sql);
			$this->data = $this->getLine();
			//die(print_r($this->data));
			if ($this->data) {
				if (trim($this->data->fichier) != '') {
					unlink('media/files/' . $this->data->fichier);
					$msg = $lang->text('ESP_IMAGE_SUPPRIMER');
					$type = 'success';
				}
				$row = new TableFichier();
				$row->save($insert, 'id');
			}
		}
		Router::page(Router::base() . 'admin-fichier?id=' . $data['id'], $msg, $type);
	}

	function deletefichier()
	{
		$session = $this->checksessin();
		$user = $session->user;
		$lang = $session->language;
		$data = $_REQUEST;
		$msg = $lang->text('ESP_VERIF_DONNEE');
		$type = "error";
		if (isset($data['id'])) {

			if (is_numeric($data['id']) && $data['id'] > 0) $id = intval($data['id']);
			else
			if (is_array($data['id'])) $id = implode(',', $data['id']);
			if ($id) {
				$sql = "select * from #__fichier where id in(" . $id . ")";
				$this->setQuery($sql);
				$offre = $this->getLignes();

				if ($offre) {
					$sql = "delete from #__fichier where id in(" . $id . ")";
					$this->setQuery($sql);
					$msg = $lang->text('ESP_SUPPRIMER');
					$type = "success";
				} else {
					$msg = $lang->text('ESP_INTROUVABLE');
				}
			}
		}
		Router::page(Router::base() . 'admin-dossier', $msg, $type);
	}


	/***************** module *****************/
	function saveajoutmodule()
	{
		$this->checksessin();
		$data = $_REQUEST;
		$lang = new Lang();
		$msg = $lang->text('ESP_ECHEC_SAVE');
		$type = 'error';
		$url = Router::base();
		$item = false;
		$book = true;
		if (isset($data['id']) && is_numeric($data['id'])) {
			$sql = "select * from #__module where id=" . intval($data['id']);
			$this->setQuery($sql);
			$item = $this->getLine();
			if (!$item) $book = false;
		}
		if ($book) {

			$table = new TableModule();
			$table->save($data, 'id');
			$id = $table->getId();
			if ($id > 0) {
				$msg = $lang->text('ESP_ENREGISTRER');
				$type = "success";
				$url .= '?id=' . $id;
			}
		}
		Router::page(Router::base() . 'admin-ajoutmodule', $msg, $type);
	}


	/***************** chapitre *****************/
	function savechapitre()
	{
		$this->checksessin();
		$data = $_REQUEST;
		$lang = new Lang();
		$msg = $lang->text('ESP_ECHEC_SAVE');
		$type = 'error';
		$url = Router::base();
		$item = false;
		$book = true;
		if (isset($data['id']) && is_numeric($data['id'])) {
			$sql = "select * from #__chapitre where id=" . intval($data['id']);
			$this->setQuery($sql);
			$item = $this->getLine();
			if (!$item) $book = false;
		}
		if ($book) {

			$table = new TableChapitre();
			$table->save($data, 'id');
			$id = $table->getId();
			if ($id > 0) {
				$msg = $lang->text('ESP_ENREGISTRER');
				$type = "success";
				$url .= '?id=' . $id;
			}
		}
		Router::page(Router::base() . 'admin-chapitre', $msg, $type);
	}
}
