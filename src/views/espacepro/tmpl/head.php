

        <nav id="nav" class="nav-primary  nav-vertical">
        
         <header class="header clearfix">
 <button type="button" id="toggleMenu" class="toggle_menu">   <i class="fa fa-bars"></i> </button>
 </header>
        <div class="nav-menu">
        <div class="reduire"> </div>

   <div class="logo_espace"> <a href="<?php echo Router::base(); ?>"><img src="<?php echo Router::root(); ?>media/espacepro.png" alt="" /></a> </div> 
     
         <ul id="js-menu" class="menu">  
<?php if($user->id_role==1){ ?>
	<li class="menu--item <?php if($this->layoutName=='utilisateur') echo 'active';?>">
				<a href="<?php echo Router::base(); ?>admin-utilisateur" class="menu--link" title="utilisateur">
				  <i class="menu--icon  fa fa-user"></i>
				  <span class="menu--label">Utilisateur</span>
				</a>
		 </li>
		 
		 <li class="menu--item <?php if($this->layoutName=='ajoutmodule') echo 'active';?>">
				<a href="<?php echo Router::base(); ?>admin-ajoutmodule" class="menu--link" title="Module">
				  <i class="menu--icon  fa fa-file"></i>
				  <span class="menu--label">Module</span>
				</a>
		 </li>
		 <li class="menu--item <?php if($this->layoutName=='specialite') echo 'active';?>">
				<a href="<?php echo Router::base(); ?>admin-specialite" class="menu--link" title="Specialite">
				  <i class="menu--icon  fa fa-list"></i>
				  <span class="menu--label">Spécialite</span>
				</a>
		 </li>
		 <li class="menu--item <?php if($this->layoutName=='chapitre') echo 'active';?>">
				<a href="<?php echo Router::base(); ?>admin-chapitre" class="menu--link" title="Chapitre">
				  <i class="menu--icon  fa fa-file"></i>
				  <span class="menu--label">Chapitre</span>
				</a>
		 </li>
<?php } ?>
		<li class="menu--item <?php if($this->layoutName=='dossier' || $this->layoutName=='module') echo 'active';?>">
				<a href="<?php echo Router::base(); ?>admin-dossier" class="menu--link" title="Dossier posté">
				  <i class="menu--icon  fa fa-file-o"></i>
				  <span class="menu--label">Dossier</span>
				</a>
		 </li>		 
		
		 <li class="menu--item">
				<a href="<?php echo Router::base().'user?task=logout' ?>" class="menu--link" title="<?php echo $lang->text('ESP_LOGOUT');?>">
				  <i class="menu--icon  fa fa-power-off"></i>
				  <span class="menu--label"><?php echo $lang->text('ESP_LOGOUT');?></span>
				</a>
		 </li>
     
     
     
       </ul>
       

    </nav>

</div>
<div id="content">

 <div class="navbar ">

        <div class="left panel-heading mgb0  ">
   <div class="title-page"><strong><?php
   $title_page='';
   switch(trim(strtolower($this->layoutName))){
		case 'profil':  $title_page=$lang->text('ESP_PROFILE');break;   
		case 'utilisateur':  $title_page='Gestion des utilisateur';break;
		case 'dossier':  $title_page='Gestion des dossiers';break;	
		case 'chapitre':  $title_page='Gestion des chapitres';break;
		case 'module':  $title_page='Gestion des modules';break;	
		case 'specialite':  $title_page='Gestion des spécialites';break;	
   }
   echo  $title_page /*.'-'.$this->layoutName*/;?></strong></div>


    </div>
	<ul class="nav navbar-nav navbar-avatar pull-right "> 
   
    <li class="dropdown"> 
    	<a href="#" class="dropdown-toggle line39" data-toggle="dropdown" > 
        	<span class="hidden-xs-only user-fa"></span>
        </a> 
        <ul class="dropdown-menu pull-right">            
            <li> <a href="<?php echo Router::base().'user/?task=logout&return='.base64_encode(Router::base());?>" class="menu--link" >
              <i class="menu--icon  fa fa-power-off"></i>
              <span><?php echo $lang->text('ESP_LOGOUT');?></span>
            </a></li>
        </ul>
      </li> 
      </ul>
   
    </div> 
<script type="text/javascript" src="<?php echo Router::root();?>assets/js/chosen.jquery.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		
		$('body').on('click','.reduire',function(){
			if($('#nav').hasClass('inline')){
				$('#nav').removeClass('inline');
				}else{
				$('#nav').addClass('inline');
			}
		});
		
		$(document).on('click','[data-toggle^="class"]',function(e){e&&e.preventDefault();var $this=$(e.target),$class,$target;!$this.data('toggle')&&($this=$this.closest('[data-toggle^="class"]'));$class=$this.data()['toggle'].split(':')[1];$target=$($this.data('target')||$this.attr('href'));$target.toggleClass($class);$this.toggleClass('active');});
		
		
		
		$('body').on('click','.subMenuBackoffice',function(){
			if($('.main_info_menu').hasClass('closed')){
				$('.main_info_menu').removeClass('closed');
				$('.main_info_menu').slideDown(500);
			}else{
				$('.main_info_menu').slideUp().addClass('closed');
			}
			
		});
		
		$('body').on('click','.icon_bottom',function(event){
		var p=$(this).parent().parent('.groupbtn');
		var m=p.find('.submenu');
		if(m.hasClass('hide')){
			m.removeClass('hide');
			
			$('html').one('click',function() {m.addClass('hide'); });
			 event.stopPropagation();
		}else{
			m.addClass('hide');
		}
	});
	if($('.tab_content_wrapper ').size()>0)
	setTimeout(function(){
	var h=$('.tab_content.active'),hei=h.height();
		hei+=100;
		h.parent().css('height',hei+'px');
		
	},3000);
	$('body').on('click','.tabs li,.editparticipation,.editmembre',function(){
		var h=$('.tab_content.active'),hei=h.height();
		hei+=100;
		h.parent().css('height',hei+'px');
		//$('.tabs-1').css('height',hei+'px');
	});
	$('body').on('click','.navAdmin',function(){
		if($(this).hasClass('inline')){
			$(this).removeClass('inline');
		}else{
			$(this).addClass('inline'); 
			
			$('html,body').on('click',function(event) { 
				if(!$(event.target).closest('.navAdmin').length) {
					$('.navAdmin').removeClass('inline');
				}        
			});
	
		}
		
		 
	});
	
	
	
	
	$('body').on('blur','.setalias',function(){	
	
		if($(this).hasClass('double') && $.trim($('body').find('input[name=meta_title]').val())==''){
			$('body').find('input[name=meta_title]').val($(this).val());
		}
		var alias=$(this).val();
		alias=alias.replace('é','e').replace('è','e').replace('à','a');
		alias=alias.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
		alias=alias.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'-');
		alias=alias.toLowerCase();
		if($.trim($('body').find('input[name=alias]').val())=='')$('body').find('input[name=alias]').val(alias);	
	});
	$('body').on('blur','.setDesc',function(){
		var alias=$(this).val().slice(0,120).toLowerCase()+'...';
		if($.trim($('body').find('textarea[name=meta_description]').val())=='')
		$('body').find('textarea[name=meta_description]').val(alias);	
	});



		
	});
</script>