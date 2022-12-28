<?php require_once('head.php'); ?>
 <script type="text/javascript">
						   jQuery(document).ready(function($) {
							$('body').on('click','.starsearch',function(){
								var url='<?php echo Router::base();?>admin-chapitre',params=[];
								$('.elemsearch').each(function(){
									if($.trim($(this).val())!='')params.push($(this).attr('name')+'='+$(this).val());
								});
								window.location.href=url+'?'+params.join('&');
							});
							$('body').on('click','.reset',function(){
								window.location.href='<?php echo Router::base();?>admin-chapitre';
							});
						});
	</script>
	
<div class="backoffice">
	<section class="panel">
		<?php 
		if($this->id == 0 && $this->new == 0){ ?>
			<div class="panel-body">
				
                <a class="btn right btn-small" href="<?php echo Router::base().'admin-chapitre?new=1'; ?>">
                   		<?php echo $lang->text('ADD'); ?>
                </a>
                <div class="clear"></div>
                </div>

 

	<table class="table" data-sort="true" >
		<thead>
		 <tr>	
		 <th><input type="text" class="form-control elemsearch"  name="code" placeholder="Code"
              value="<?php if(isset($this->filtre['code'])) echo $this->filtre['code'];?>" /></th>
		 <th><input type="text" class="form-control elemsearch"  name="nom" placeholder="<?php echo $lang->text('ESP_NOM'); ?>"
              value="<?php if(isset($this->filtre['nom'])) echo $this->filtre['nom'];?>" /></th>

        <th><button type="button" class="starsearch btn btn-sm btn-success"><?php echo $lang->text('ESP_FILTRER');?></button>
            <?php if(count($this->filtre)>0){?>
        <button type="button" class="reset btn btn-sm btn-danger"><?php echo $lang->text('ESP_REINISIALISER');?></button>
        <?php }?>
       </th>
	   
       </tr>
		<tr>
		<th data-sort-initial="true">Numéro chapitre</th>
		<th data-sort-initial="true">Nom chapitre </th>		
		<th data-sort-initial="true">Module</th>			
	    <th data-sort-ignore="true">Opération</th>
		</tr>
		</thead>
		<tbody>
		 <?php if(count($this->all)>0){ ?>
		<?php foreach($this->all as $k=>$v) { ?>
		<tr  title="">
		<td><?php echo $v->code; ?></td>
		<td><?php echo $v->nom; ?></td>
		<td><?php echo $this->module[$v->id_module]->nom; ?></td>
		  <td>
			<div class="btn-group"> 
                            <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <?php echo $lang->text('ESP_ACTION');?>
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">
                             <li><a href="<?php echo Router::base().'admin-chapitre?id='.$v->id; ?>"><?php echo $lang->text('ESP_EDIT');?></a></li>	

							</ul> 
                              </div>
                              
		 </td>
		</tr>
		<?php }}else{ ?>
		<tr>
		<td colspan="3"><?php echo $lang->text('AUCUN_PATIENT'); ?></td>
		</tr>
		 <?php } ?>
		</tbody>
		<tfoot class="hide-if-no-paging">
						<tr>
							<td colspan="4">
								<div class="pagination pagination-centered"></div>
							</td>
						</tr>
	</tfoot>
	</table>
	
<?php } if($this->new>0 || $this->id>0){ ?>	<div class="return_backoffice">
                <a href="<?php echo Router::base().'admin-chapitre'; ?>" class="transition btn btn-success right" >
                        <i class="fa fa-arrow-left"></i>
                        <?php echo $lang->text('ESP_RETURN_TO_LIST'); ?>
                    </a>
                </div>
                <br clear="all" />
           
			 <div class="ajouter ">
                <form action="<?php echo Router::base(); ?>espacepro" method="POST" enctype="multipart/form-data" id="form_login" autocomplete="off" class="form-horizontal">
                    <input type="hidden" name="task" value="savechapitre"/>
                    
                   
                     
					<div class="col-md-6">
                   <div class="input-group">
                          <span class="input-group-addon">Numéro chapitre  <span class="star">*</span></span>
                          <?php $value = ''; if($this->id > 0){$value = $this->details->code; } ?>
                          <input type="text" class="form-control required" name="code" id="code"  value="<?php echo $value; ?>"  placeholder="Numéro chapitre" />
                        </div>
                    </div>
					
					<div class="col-md-6">
					   <div class="input-group">
							  <span class="input-group-addon"><?php echo $lang->text('ESP_NOM'); ?>  <span class="star">*</span></span>
							  <?php $value = ''; if($this->id > 0){$value = $this->details->nom; } ?>
							  <input type="text" class="form-control required" name="nom" id="nom"  value="<?php echo $value; ?>"  placeholder="<?php echo $lang->text('ESP_NOM'); ?>" />
							</div>
					</div> 	
					
					<div class="col-md-6">
                   <div class="input-group">
                          <span class="input-group-addon">Module <span class="star">*</span></span>
									  <select name="id_module" class="form-control  required">
									  <option value="">Choisissez Module</option>
									  <?php foreach($this->module as $k=>$module){ ?>
									  <option value="<?php echo $k; ?>" <?php if(($this->id>0))if($this->details->id_module==$k){ echo 'selected'; } ?>><?php echo $module->nom; ?></option>
									  <?php } ?>
									  </select>
									  
				 </div>	 </div>
					
					<div class="col-md-6">
					   <div class="input-group">
							  <span class="input-group-addon">Ordre <span class="star">*</span></span>
							  <?php $value = ''; if($this->id > 0){$value = $this->details->parent; } ?>
							  <input type="text" class="form-control required" name="parent" id="parent"  value="<?php echo $value; ?>"  placeholder="Ordre" />
							</div>
					</div> 		

                    <div class="clear"></div>
                    <div style="text-align:left;">
                    	<?php if($this->id > 0){ ?>
                        	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
                        <?php } ?>
                        <input  class="right bouton  btn btn-success btn-sm"  id="valider" type="submit"  value="<?php echo $lang->text('ESP_SAVE'); ?>" />   
			<a class="btn btn-danger btn-sm double right" href="<?php echo Router::base();?>admin-chapitre" ><?php echo $lang->text('ESP_CANCEL');?></a>
					
                    </div>
                    <div class="clear"></div>
                </form>
            </div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("select2").select2();
		$('body').on('submit','#form_login',function(){
								var $return=true;
								$(this).find('.required').each(function(key,value){
									if($.trim(jQuery(this).attr('name'))!=''){
									if($.trim($(this).val())=='' || (jQuery(this).attr('name')=='nom' && jQuery(this).hasClass('echec')  ) || (jQuery(this).attr('name')=="sexe" && $(this).attr('checked')!=='checked')){
										$return=false;
										$(this).addClass('error');	
										$(this).parent().find('.span_error').remove();
										$(this).parent().append('<br><span class="span_error">Ce champ est obligatoire.</span>');
									}else{
										$(this).removeClass('error');	
										$(this).parent().find('.span_error').remove();
									}}
								});
								return $return;
							});	});

</script>
<?php } ?>
  <div class="clear"></div>
	</section>  <div class="clear"></div>
</div>  <div class="clear"></div> 