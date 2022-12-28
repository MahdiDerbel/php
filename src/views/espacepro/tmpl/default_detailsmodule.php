<?php require_once('head.php'); ?>

<div class="backoffice">
<div class="return_backoffice">
                  <a href="<?php echo Router::base().'admin-module?id_produit='.$this->id_produit.'&id='.$this->chapitre->id_module; ?>" class="transition btn btn-success right" >
                        <i class="fa fa-arrow-left"></i>
                        <?php echo $lang->text('ESP_RETURN_TO_LIST'); ?>
                    </a>
                </div>
                <br clear="all" />
	<section class="  panel">
		<h1  class="left">Date dernière soumission: <?php if($this->dateInsert) echo $this->dateInsert->date; ?></h1>
		<div class="clear"></div>
		<h1 class="titre-module"><?php echo $this->chapitre->nom;  ?>    <a href="<?php echo Router::base().'admin-import?id_produit='.$this->id_produit.'&id_chapitre=' .$this->id; ?>" class="transition btn btn-success " style="margin-left: 20px;font-size: 20px;" >
                         Importer
                    </a></h1>

		<hr>
		<div class="bloc2">
			<?php if ($this->fichier > 0) {
				foreach ($this->fichier as $k => $f) {
			?>
				<h1  class="left">Date insertion : <?php echo $f->date; ?></h1>
				<iframe src="<?php echo Router::base().$f->fichier; ?>#toolbar=0&navpanes=0" width="100%" height="600"></iframe>
			<div class="clear"></div>	
			<hr>	
			<?php }
			} ?>
		</div>
		<div class="clear"></div>
	</section>
	<div class="clear"></div>
</div>