<?php require_once('head.php');?>


<script type="text/javascript"> 

	 jQuery( document ).ready(function($) {

				 
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
								var url='<?php echo Router::base();?>admin-dossier',params=[];
								$('.elemsearch').each(function(){
									if($.trim($(this).val())!='')params.push($(this).attr('name')+'='+$(this).val());
								});
								window.location.href=url+'?'+params.join('&');
							});
							$('body').on('click','.reset',function(){
								window.location.href='<?php echo Router::base();?>admin-dossier';
							});
	});
	</script>
<div class=" content"><?php 
	
			if($this->new == 0 && $this->id == 0){ 
			  
			?>
<section class="panel">
<div class="panel-heading"><strong>Liste des dossiers posté</strong></div>

<div class="backoffice">

               <div class="clear"></div>
               <br>
           
               <input type="hidden" name="task" />
				<table class="table demo" data-filter="#filter" data-filter-text-only="true">
					<thead>
		 <tr>
          <th><input type="text" class="form-control elemsearch"  name="nom" placeholder="<?php echo $lang->text('ESP_NOM'); ?>"
              value="<?php if(isset($this->filtre['nom'])) echo $this->filtre['nom'];?>" /></th>
	
        <th><button type="button" class="starsearch btn btn-sm btn-success"><?php echo $lang->text('ESP_FILTRER');?></button>
            <?php if(count($this->filtre)>0){?>
        <button type="button" class="reset btn btn-sm btn-danger"><?php echo $lang->text('ESP_REINISIALISER');?></button>
        <?php }?>
       </th>
	   </tr>
					<tr>
                        
                        <th data-toggle="true" >Specialite</th>  
                        <th data-toggle="true" >Details</th>
                          
						</tr>
					</thead>
					<tbody>
						<?php if(count($this->all)>0){
						foreach($this->all as $item){
						
							  ?>
						<tr>
                       
                        <td><?php echo $item->nom; ?></td>
						  <td><a target="_blank"  href="<?php  echo Router::base().'admin-module?id_produit='.$item->id; ?>"  >Details</a></td>
						</tr>
                       <?php }}else{ echo "<tr><td colspan='4'> Aucun details </td></tr>" ; } ?>
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
                                <li class="footable-page-arrow left <?php if($this->page==1) echo 'disable';?>"><a <?php if($this->page>1){?>href="<?php echo Router::base().'admin-dossier?page='.($this->page-1);if(count($params)>0) echo "&".implode('&',$params);?>"<?php }?>>«</a></li>
                                <li class="footable-page left "><input type="text" class="form-control " name="page" value="<?php echo $this->page;?>" /> </li>
                               
                                <li class="footable-page-arrow next left <?php if(($this->page+1)>$nbpage) echo 'disable';?>"><a <?php if(($this->page+1)<=$nbpage){?>href="<?php echo Router::base().'admin-dossier?page='.($this->page+1);if(count($params)>0) echo "&".implode('&',$params);?>"<?php }?>>»</a></li>
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
										var url='<?php echo Router::base().'admin-dossier';?>?page='+p;
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
			<?php } ?>
</section>
</div>