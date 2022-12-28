<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width = device-width, initial-scale = 1.0">
		
         <meta name="Identifier-URL" content="<?php echo Router::root(); ?>"/>
        <link rel ="canonical" href="<?php echo Router::root() ;  ?>">
        <meta name="generator" content="medicacom" />
		<meta name="theme-color" content="rgb(0 146 179)">
        <meta property="og:url"  content="<?php echo Router::root() ;  ?>" />
        <meta property="og:type"  content="website" />
        <meta property="og:title"  content="Gestions des fichiers" />
        <meta property="og:description"  content="Gestions des fichiers" />
        <meta property="og:image" content="<?php echo Router::root() ;?>media/logo.png" />
        <meta property="og:image:width" content="100" />
        <meta property="og:image:secure_url" content="<?php echo Router::root() ;?>media/logo.png" />
        <meta name="keywords" content="Gestions des fichiers" /> 
	
      <link rel="icon" href="<?php echo Router::root();?>favicon.ico" />

		<title><?php if($view->title != '') echo $view->title;elseif($view->root)echo $view->root->meta_title;?> </title>
		<?php 
		?>
		<script type="text/javascript" src="<?php echo Router::root();?>assets/js/jquery-1.11.1.min.js"></script>   
<script >
/*jQuery(document).bind("contextmenu",function(e) {
		 e.preventDefault();
		});
		document.onkeydown = function (e) { 
					if (event.keyCode == 123) { 
						return false; 
					} 
					if (e.ctrlKey && e.shiftKey && e.keyCode == 'i'.charCodeAt(0)) { 
						return false; 
					} 
					if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { 
						return false; 
					}
					if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) { 
						return false; 
					} 
					if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { 
						return false; 
					} 
					if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { 
						return false; 
					} 
				}

if($(window).width()<1024){
if ("serviceWorker" in navigator) {
  if (navigator.serviceWorker.controller) {
  console.log("[PWA Builder] active service worker found, no need to register");
  } else {
    // Register the service worker
    navigator.serviceWorker
      .register("pwabuilder-sw.js", {
        scope: "./"
      })
      .then(function (reg) {
      console.log("[PWA Builder] Service worker has been registered for scope: " + reg.scope);
      });
  }
}
}
self.addEventListener('install', function(event) {});  <link rel="manifest" href="<?php echo Router::root();?>manifest.json">*/

</script>

		<?php 
		
		
		if(count($view->css)>0)foreach($view->css as $css){ ?>
			<link href="<?php echo $css?>" rel="stylesheet" type="text/css" /><?php
		}
		if(count($view->js)>0)
			foreach($view->js as $js){ ?>
				<script type="text/javascript" src="<?php echo $js; ?>"></script><?php 
			}
		if(count($view->meta)>0)
			foreach($view->meta as $meta) echo $meta; ?>
<?php if($view->name=='espacepro'  ){?>
		<script src="<?php echo Router::root();?>assets/js/backoffice.js"></script>
        <script src="<?php echo Router::root();?>assets/js/espace.js"></script>
        <script src="<?php echo Router::root();?>assets/js/fooTable.js" type="text/javascript"></script>
        <script src="<?php echo Router::root();?>assets/js/fooTable.Filter.js" type="text/javascript"></script> 
		<script src="<?php echo Router::root();?>assets/js/addtohomescreen.js" type="text/javascript"></script>
        <script src="<?php echo Router::root();?>assets/js/footable.paginate.js" type="text/javascript"></script>
		<script src="<?php echo Router::root();?>assets/js/footable.sort.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo Router::root();?>assets/css/icone.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo Router::root();?>assets/espacepro.css" type="text/css" />
		
  <?php }?>    

<script type="text/javascript">






		  jQuery(document).ready(function($) {
			
			  if($(window).width()<1025){$('#nav').addClass('inline'); }
			  $('.totop').fadeOut();
				$('body').on('click','.totop',function(){
					$('html,body').animate({scrollTop:0},300);
				});
			  $(window).on('scroll',function(){
				var scrolle = $(document).scrollTop();
				if(scrolle>30){
					
					$('.header_fixed').removeClass('fadeInUp').addClass(' animated ').addClass('fadeInDown');	
					$('body').addClass('scroll');
					$('.totop').fadeIn();
				}else {
				   $('.header_fixed').removeClass(' fadeInDown').addClass('fadeInUp');
				   
					$('body').removeClass('scroll');
					
					 $('.totop').fadeOut();
				}
			});
           
        });
		   </script>
        

	</head>
	<body class="<?php echo "page".$view->root->layout;  ?>  " >
      
	<?php 
		if($view->root->view == 'espacepro'  ) { ?>
        <div class="message"> <?php require_once('message.php');?></div>
		
        <link rel="stylesheet" href="<?php echo Router::root();?>assets/css/jQueryTab.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo Router::root();?>assets/css/chosen0.css" type="text/css" />
				<script type="text/javascript" src="<?php echo Router::root()?>assets/js/tab.js"></script>
        <?php 		  echo $content; ?>  
        <?php if($view->root->layout=='display'){?></div><?php }?>
		
				
        <a href="#" class="hide slide-nav-block active" data-toggle="class:slide-nav slide-nav-left" data-target="body"></a>
 		<link rel="stylesheet" href="<?php echo Router::root();?>assets/css/animation.css" type="text/css" />
		
		<?php }  		?>   


		
        
        
  <div class="totop"></div>
	</body>
</html>