<?php require_once('head.php');?>


<script type="text/javascript"> 

	 jQuery( document ).ready(function($) {
		 
		 		 
		 
		  jQuery('body').on('click' ,'#valider', function() {
			  
			  
			 var email = jQuery('#email').val(),idUser=<?php echo $this->id; ?>; 
					
					
						  jQuery.ajax({
							   type:'POST',
							   url: '<?php echo Router::base();?>user',
							   data:{ task:'getUsernameLogin','email':email ,'id':idUser},
							   success: function(html){
								  
								   if ($.trim(html)=="2" ) { 
									  jQuery('#email').val('').addClass('error') ; 
									  jQuery(".email").html('<?php echo $lang->text('ESP_EMAIL_EXISTE');?>').css("color", "red") ;
									  jQuery("#username").removeClass('error');
								   } 
								   else  { jQuery("form").submit() ; }
							   }
				 });
				  	
				 
				
					
				  });
				 
		 
			jQuery('body').on('blur' ,'#email', function() {

                   var email = jQuery('#email').val(); 
				  	
			      jQuery.ajax({
					   type:'POST',
					   url: '<?php echo Router::base();?>user',
					   data:{ task:'getEmail','email':email<?php if($this->id) echo ',id:'.$this->id;?>},
					   success: function(html){
						  jQuery('.email').html(html); 
					   }
					}); 
			});
				 
				 
$('body').on('submit','form',function(){
		var elem=$(this);	
		var $return =true;
		elem.find('.required').each(function(){
				if($.trim($(this).val())=='' || $.trim($(this).val())==0 || ($(this).attr('name')=='email' && (!IsEmail($(this).val()) ||$(this).hasClass('echec'))) || ($(this).attr('name')=='password' && $(this).val().length<6)){
					$(this).addClass('error');
					$return =false;
				}else{
					$('.message').removeClass('inline').html('');
					$(this).removeClass('error');
				}
		});
	return $return;
	});	  
				 
		
		
		
							$('body').on('click','.starsearch',function(){
								var url='<?php echo Router::base();?>admin-utilisateur',params=[];
								$('.elemsearch').each(function(){
									if($.trim($(this).val())!='')params.push($(this).attr('name')+'='+$(this).val());
								});
								window.location.href=url+'?'+params.join('&');
							});
							$('body').on('click','.reset',function(){
								window.location.href='<?php echo Router::base();?>admin-utilisateur';
							});
						});
	</script>
<div class=" content"><?php 
	
			if($this->new == 0 && $this->id == 0){ 
			  
			?>
<section class="panel">
<div class="panel-heading"><strong>Liste des utilisateurs</strong></div>

<div class="backoffice">
	
            
				
                    <a class="add buttons btn right btn-sm btn-success" href="<?php echo Router::root().'admin-utilisateur?new=1'; ?>">
                   		<?php echo $lang->text('ESP_ADD'); ?>
                    </a>
               <div class="clear"></div>
               <br>
           
               <input type="hidden" name="task" />
				<table class="table demo" data-filter="#filter" data-filter-text-only="true">
					<thead>
		 <tr>
          <th><input type="text" class="form-control elemsearch"  name="nom" placeholder="<?php echo $lang->text('ESP_NOM'); ?>"
              value="<?php if(isset($this->filtre['nom'])) echo $this->filtre['nom'];?>" /></th>
		<th>-</th>
        <th><button type="button" class="starsearch btn btn-sm btn-success"><?php echo $lang->text('ESP_FILTRER');?></button>
            <?php if(count($this->filtre)>0){?>
        <button type="button" class="reset btn btn-sm btn-danger"><?php echo $lang->text('ESP_REINISIALISER');?></button>
        <?php }?>
       </th>
	   </tr>
					<tr>
                        
                        <th data-toggle="true" ><?php echo $lang->text('ESP_NOM');?></th>
                        <th data-toggle="true" ><?php echo $lang->text('ESP_EMAIL');?></th>
						<th data-hide="phone"><?php echo $lang->text('ESP_OPERATIONS'); ?></th>
                          
						</tr>
					</thead>
					<tbody>
						<?php if(count($this->all)>0){
						foreach($this->all as $item){
						
							  ?>
						<tr>
                       
                        <td><?php echo $item->nom_prenom; ?></td>
                         <td><?php echo $item->email; ?></td> 
							<td>
								
                            
                            <div class="btn-group"> 
                            <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <?php echo $lang->text('ESP_ACTION');?>
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu">
                             <li><a href="<?php echo Router::base().'admin-utilisateur?id='.$item->id; ?>"><?php echo $lang->text('ESP_EDIT');?></a></li>	
							<?php $link = Router::base().'user?task=deleteUtilisateur&id='.$item->id; ?>
                             <li><a href="<?php echo $link; ?>"onclick="return confirm('<?php echo $lang->text('ESP_CONTINUER_LA_SUPPRESSION');?>')"><?php echo $lang->text('ESP_DELETE');?></a></li>
                             
                             	 
                               </ul> 
                              </div>
                              
							</td>
                            
						</tr>
                       <?php }}else{ echo "<tr><td colspan='6'> Aucun details </td></tr>" ; } ?>
					</tbody>
				
				</table>
                </form>
                <footer>
                <div class="panel-footer">
                	
                    
            
                <div class="pagination1 pagination-centered left">
                                  <ul>
                                <?php $params=array();foreach($this->filtre as $k1=>$v1)if(trim($v1)!='' && $v1 )$params[]=$k1.'='.$v1;
								$nbpage=(int)(count($this->allaffiche)/$this->limit_page);
								if((count($this->allaffiche)%$this->limit_page)>0)$nbpage++;
								?>
                                <li class="footable-page-arrow left <?php if($this->page==1) echo 'disable';?>"><a <?php if($this->page>1){?>href="<?php echo Router::base().'admin-utilisateur?page='.($this->page-1);if(count($params)>0) echo "&".implode('&',$params);?>"<?php }?>>«</a></li>
                                <li class="footable-page left "><input type="text" class="form-control " name="page" value="<?php echo $this->page;?>" /> </li>
                               
                                <li class="footable-page-arrow next left <?php if(($this->page+1)>$nbpage) echo 'disable';?>"><a <?php if(($this->page+1)<=$nbpage){?>href="<?php echo Router::base().'admin-utilisateur?page='.($this->page+1);if(count($params)>0) echo "&".implode('&',$params);?>"<?php }?>>»</a></li>
                                </ul>
                                </div>
                                 <div class="left nbpage">
                                 sur <?php if($nbpage==0) echo '1'; else echo $nbpage;?>
                                </div>
                                <script type="text/javascript">
								jQuery(document).ready(function($) {
                                    $('body').on('blur','input[name=page]',function(){
										var maxi=<?php echo $nbpage;?>;
										var p=$(this).val().replace(/[^0-9\.]/g,'');
										
										if(p>maxi)p=1;
										$(this).val(p);
										var url='<?php echo Router::base().'admin-utilisateur';?>?page='+p;
										<?php  if(count($params)>0) echo 'url+="&'.implode('&',$params).'";';?>
										if(<?php echo $this->page;?>!=p)
										window.location.href=url;
									});
									
                                });
								</script>
               
                
               <div class="clear"></div>
                </div>
                </footer>
		</section>
		</div>
		

		</div>	
			<?php } ?><?php		if($this->id > 0||$this->new > 0){			?>
           
         <section class="panel">


<div class="backoffice">       
            	<div class="return_backoffice">
                  <a href="<?php echo Router::base().'admin-utilisateur'; ?>" class="transition btn btn-success right" >
                        <i class="fa fa-arrow-left"></i>
                        <?php echo $lang->text('ESP_RETURN_TO_LIST'); ?>
                    </a>
                </div>
                <br clear="all" />
           
			 <div class="ajouter ">
                <form action="<?php echo Router::base(); ?>user" method="POST" enctype="multipart/form-data" id="form_login" autocomplete="off" class="form-horizontal">
                    <input type="hidden" name="task" value="saveUtilisateur"/>
                    
                   
                     
               <div class="col-md-6">
                   <div class="input-group">
                          <span class="input-group-addon"><?php echo $lang->text('ESP_NOM'); ?>  <span class="star">*</span></span>
                          <?php $value = ''; if($this->id > 0){$value = $this->details->nom_prenom; } ?>
                          <input type="text" class="form-control required" name="nom_prenom" id="nom"  value="<?php echo $value; ?>"  placeholder="<?php echo $lang->text('ESP_NOM'); ?>" />
                        </div>
                    </div>
                    
                
                    <div class="col-md-6">
                   		
                        <div class="input-group">
                          <span class="input-group-addon"><?php echo $lang->text('ESP_EMAIL'); ?>  <span class="star">*</span></span>
                          <?php $value = ''; if($this->id > 0){$value = $this->details->email; } ?>
                          <input type="text" class="form-control required " name="email" id="email"<?php  echo ' autocomplete="off" ';?> value="<?php echo $value; ?>"  placeholder="<?php echo $lang->text('ESP_EMAIL'); ?>" />
                        
                        </div>  <div class="email"> </div>
                    </div>
                  
                     <div class="col-md-6 ">
                   		<div class="label"> </div>
                        <div class="input-group">
                          <span class="input-group-addon"><?php echo $lang->text('ESP_MOT_PASSE'); ?> </span>
                          <input type="password" class="form-control  <?php if($this->id==0) echo 'required';?>" autocomplete="new-password"  name="password" id="password" />
                        </div>
                    </div>

			
				<div class="col-md-6 ">
                        <div class="input-group">
                          <span class="input-group-addon"><?php echo $lang->text('ROLE'); ?> <span class="star">*</span> </span>
                  <select name="id_role"  class="form-control required" >
					<option value="0">Selectionnez role</option>
					<?php if(count($this->role)>0)foreach($this->role as $k=>$v){ ?>
					<option value="<?php echo $k; ?>" <?php if($this->id > 0){ if($k==$this->details->id_role) echo 'selected' ;} ?>><?php echo $v->role; ?></option>
					<?php }?>
			</select>
			</div>
			</div>	
   <div class="clear"></div>
			<div class="col-md-6 left">
                         <div class="input-group">
                          <span class="input-group-addon"><?php echo $lang->text('ACTIVATION'); ?></span>
                          <?php $valueetat = ''; if($this->id > 0){$valueetat = $this->details->etat; } ?>
						  <select name="etat" class="form-control " >
							  <option  value="1" <?php  if($this->id > 0){ if ($valueetat==1) echo 'selected';  } ?> ><?php echo $lang->text('ESP_OUI');?> </option>
							  <option value="0" <?php if($this->id > 0){ if ($valueetat==0) echo 'selected';  } ?> > <?php echo $lang->text('ESP_NON');?> </option>
						  </select>
                        </div>
			</div>
  <div class="clear"></div>
			
                    <div style="text-align:left;">
                    	<?php if($this->id > 0){ ?>
                        	<input type="hidden" name="id" value="<?php echo $this->id; ?>" />	
                        <?php } ?>
                        <input  class="right bouton  btn btn-success btn-sm"  id="valider" type="submit"  value="<?php echo $lang->text('ESP_SAVE'); ?>" />   
			<a class="btn btn-danger btn-sm double right" href="<?php echo Router::base();?>admin-utilisateur" ><?php echo $lang->text('ESP_CANCEL');?></a>
					
                    </div>
                    <div class="clear"></div>
                </form>
            </div>
    <?php } ?>
</div>
</section>
</div>