jQuery(function($){
	//$('#footer').remove();
	
	
	$=jQuery.noConflict();
	
		$('body').on('click', '#selectfile', function(){
			$('#media_input').click();
		});
		$('body').on('change','#media_input',function(){
			file = document.getElementById('media_input').files;
			for(var i=0; i < file.length; i++){
			    $('#imageuploded').html('<div class="li_image">'+file[i].name+'<div class="load_image hide right"><img src="assets/images/loading.gif" /></div> </div>'); 
			}
		});
		$('body').on('click', '#selectfile_pdf', function(){
			$('#media_input_pdf').click();
		});
		$('body').on('change','#media_input_pdf',function(){
			console.log(file);
			file = document.getElementById('media_input_pdf').files;
			for(var i=0; i < file.length; i++){
			    $('#imageuploded_pdf').html('<div class="li_image">'+file[i].name+'<div class="load_image hide right"><img src="assets/images/loading.gif" /></div> </div>'); 
			}
		});
		$('body').on('click', '#selectfile_csv', function(){
			$('#media_input_csv').click();
		});
		$('body').on('change','#media_input_csv',function(){
			file = document.getElementById('media_input_csv').files;
			for(var i=0; i < file.length; i++){
			    $('#imageuploded_csv').html('<div class="li_image">'+file[i].name+'<div class="load_image hide right"><img src="assets/images/loading.gif" /></div> </div>'); 
			}
		});
		$('body').on('click', '#selectfile_logo', function(){
			$('#media_input_logo').click();
		});
		$('#media_input_logo').change(function(){
			file = document.getElementById('media_input_logo').files;
			for(var i=0; i < file.length; i++){
			    $('#imageuploded_logo').html('<div class="li_image">'+file[i].name+'<div class="load_image hide right"><img src="assets/images/loading.gif" /></div> </div>'); 
			}
		});
		
		
		$('body').on('click', '.uploadaction', function(){
			var id=$(this).attr('id');
			$('#'+id).click();
		});
		$('body').on('change','.btnhiddenupload',function(){
			var id=$(this).attr('id');
			file = document.getElementById(id).files;
			for(var i=0; i < file.length; i++){
			    $('.'+id).html('<div class="li_image">'+file[i].name+'<div class="load_image hide right"><img src="assets/images/loading.gif" /></div> </div>'); 
			}
		});
		
		/*$('body').on('click','.add.buttons',function(){
			$('.modifier_ancien.opened').animate({
						    height: "auto"
						  }, 1500,"linear").removeClass('opened').addClass('closed');
			$('.ajouter').animate({
						    height: "auto"
						  }, 1500,"linear").removeClass('closed').addClass('opened');
			$(this).addClass('hide');
		});*/
		$('body').on('click','.edit.buttons',function(){
			var id = $(this).parent().attr('id');
			$('#'+id+' .modifier_ancien.closed').animate({
						    height: "auto"
						  }, 1500,"linear").removeClass('closed').addClass('opened');
			$(this).addClass('active');
			$('#'+id+' .modifier_ancien').parent().css({'background':'rgba(113, 113, 113, 0.22)'});
		});
		$('body').on('click','.show.buttons',function(){
			var id = $(this).parent().attr('id');
			$('#'+id+' .modifier_ancien.closed').animate({
						    height: "auto"
						  }, 1500,"linear").removeClass('closed').addClass('opened');
			$(this).addClass('active');
			$('#'+id+' .modifier_ancien').parent().css({'background':'rgba(113, 113, 113, 0.22)'});
		});
		$('body').on('click','.down_arrow.buttons',function(){
			var str = $(this).parent().attr('id');
			var id = str.substr(5); console.log('.famille_'+id);
			$('.last_element.famille_'+id).removeClass('hide');
			$('#'+str+' .up_arrow.buttons').removeClass('hide');
			$(this).addClass('hide');
		});
		$('body').on('click','.up_arrow.buttons',function(){
			var str = $(this).parent().attr('id');
			var id = str.substr(5);
			$('.famille_'+id).addClass('hide');
			$('#'+str+' .down_arrow.buttons').removeClass('hide');
			$(this).addClass('hide');
		});
		$('body').on('click','.cancel',function(){
			var id = $(this).attr('rel');
			$('#edit_last_'+id).removeClass('opened').addClass('closed');
			$('#elem_'+id+' .edit').removeClass('active');
			$('#elem_'+id).css({'background':'rgba(238, 238, 238, 0.3)'});
		});
		$('.masterTooltip').hover(function(){
					// Hover over code
					var title = $(this).attr('title');
					$(this).data('tipText', title).removeAttr('title');
					$('<p class="tooltip"></p>')
					.text(title)
					.appendTo('body')
					.fadeIn('slow');
			}, function() {
					// Hover out code
					$(this).attr('title', $(this).data('tipText'));
					$('.tooltip').remove();
			}).mousemove(function(e) {
					var mousex = e.pageX + 20; //Get X coordinates
					var mousey = e.pageY + 10; //Get Y coordinates
					$('.tooltip')
					.css({ top: mousey, left: mousex })
			});
			
			
				$('table').footable().bind('footable_filtering', function (e) {
				  var selected = $('.filter-status').find(':selected').text();
				  if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				  }
				});
			
			$('.clear-filter').click(function (e) {
			  e.preventDefault();
			  $('.filter-status').val('');
			  $('table.demo').trigger('footable_clear_filter');
			});
		
			$('.filter-status').change(function (e) {
			  e.preventDefault();
			  $('table.demo').trigger('footable_filter', {filter: $('#filter').val()});
			});
		
			$('.filter-api').click(function (e) {
			  e.preventDefault();
		
			  //get the footable filter object
			  var footableFilter = $('table').data('footable-filter');
		
			  alert('about to filter table by "tech"');
			  //filter by 'tech'
			  footableFilter.filter('tech');
		
			  //clear the filter
			  if (confirm('clear filter now?')) {
				footableFilter.clearFilter();
			  }
			});

	});		