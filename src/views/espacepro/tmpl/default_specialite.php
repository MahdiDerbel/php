<?php require_once('head.php'); ?>
<div class="backoffice">
	<section class="panel">
		<div class="panel-heading"><strong>Spécialié</strong></div><?php 
		if($this->id == 0 && $this->new == 0){ ?>
			<div class="panel-body">
				<div class="input-group left">
                	<input id="filter" class="input-sm form-control" type="text" placeholder="<?php echo $lang->text('FILTRER');?>" />
                </div>
                <a class="btn right btn-small" href="<?php echo Router::base().'admin-specialite?new=1'; ?>">
                   		<?php echo $lang->text('ADD'); ?>
                </a>
                <div class="clear"></div>
                </div>
                <div class="table-responsive">
				<table class="table demo" data-filter="#filter" data-filter-text-only="true">
					<thead>
						<tr>
							<th data-toggle="true"><?php echo $lang->text('NOM'); ?></th>
						
							<th data-hide="phone"><?php echo $lang->text('OPERATIONS'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($this->all)>0){
						foreach($this->all as $item){ ?>
						<tr>
							<td><?php echo $item->nom; ?></td>
						
							<td>
								<a href="<?php echo Router::root().'admin-specialite?id='.$item->id; ?>" style="color:#093;" title="modifier">
									<i class="fa fa-cog"></i>
								</a>
								<?php $link = Router::root().'espacepro?task=deleteSpecialite&id='.$item->id; ?>
                                <a title="Supprimer" href="<?php echo $link; ?>" onclick="return confirm('<?php echo $lang->text('CONTINUER_LA_SUPPRESSION');?>')" style="color:#cc0000;" >
                                     <i class="fa fa-trash-o"></i>
                                </a>
							</td>
						</tr>
						<?php }}else{ echo "<tr><td colspan='4'> Aucun details </td></tr>" ; } ?>
					</tbody>
					<tfoot class="hide-if-no-paging">
						<tr>
							<td colspan="4">
								<div class="pagination pagination-centered"></div>
							</td>
						</tr>
					</tfoot>
				</table>
                </div>
                <footer>
                <div class="panel-footer">
                	<div class="pagination"></div>
                </div>
                </footer>
            <?php
		} 
		if(($this->id > 0)||($this->new > 0)){ ?>
        	<div class="panel-heading bg-white">
                <a class="right btn btn-white transition " href="<?php echo Router::base().'admin-specialite'; ?>" >
                	<i class="fa fa-arrow-left"></i>
                	<?php echo $lang->text('RETURN_TO_LIST'); ?>
                </a>
        		<div class="clear"></div>
           	</div> 
			<div class="table-responsive"><div class="clear"></div><br>
                <form action="<?php echo Router::base(); ?>espacepro" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    <input type="hidden" name="task" value="saveSpecialite"/>
					<input type="hidden" name="token" value="<?php echo $session->token; ?>" />
                   <div class="col-sm-6 left">
                        <div class="input-group">
                          <span class="input-group-addon"><?php echo $lang->text('NOM'); ?> <span class="star">*</span></span>
                          <?php $value = ''; if($this->id > 0){$value = $this->details->nom; } ?>
                          <input type="text" class="form-control required" name="nom"  value="<?php echo $value; ?>" placeholder="<?php echo $lang->text('NOM'); ?>" aria-describedby="basic-addon2">
                        </div>
                    </div>
                   
                    <div class="clear"></div>
                    <div  class=" panel-body bt">
                    	<?php if($this->id > 0){ ?>
                        	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
                        <?php } ?>
                        <input id="formsubmitaddcategorie" type="submit" class="right btn btn-success" value="<?php echo $lang->text('SAVE'); ?>"/>
                        <a class="btn btn-danger double right" href="<?php echo Router::base();?>admin-specialite"><?php echo $lang->text('CANCEL');?></a>
                        <div class="clear"></div>
                    </div>
                   <div class="clear"></div>
                </form>
            </div>
            
    <?php } ?>
	</section>
</div>
