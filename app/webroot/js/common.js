$(document).ready(function(){
	
	var confCommon = {
		masDir		:	'/',
		//masDir		:	'/markaspot/',
		searchLabelAddress : 'nach Ort suchen',
		searchLabelContent : 'in Hinweisen suchen',
		searchSubmitValueLoc : 'Ort suchen',
		searchSubmitValueMarker : 'Hinweis suchen',
		searchMap : 'karte',
		searchSearch : 'search',
		commentPublish : 'veröffentlichen',
		commentHide : 'sperren',
		commentDelete : 'delete'
	};

	//fadeout flash messages on click
	$('.cancel').click(function(){
		$(this).parent().fadeOut();
		return false;
	});
	
	$(".search").append('<div><label for="SearchWhereSearch">'+ confCommon.searchLabelContent +'<input type="radio" name="data[Search][where]" id="SearchWhereSearch" value="'+ confCommon.searchSearch +'"  /></label><label for="SearchWhereKarte">'+ confCommon.searchLabelAddress +'<input type="radio" name="data[Search][where]" id="SearchWhereKarte" value="'+ confCommon.searchMap +'" checked="checked" /></label></div>');

	$("#SearchAddForm").attr("action", confCommon.masDir + confCommon.searchMap);
	$("#SearchAddForm").attr("method", 'get');
	$("#SearchQ").val("Straße und Hausnummer");
	$("input[type='submit']").val(confCommon.searchSubmitValueLoc);
	$("#SearchAddForm").attr("method", 'get');
	$("#SearchQ").focus(function(){
	 	$('#SearchQ').val(""); 
	    return false;
	});
	
	$(".required > label").append("*");
	
	$('#SearchWhereKarte').click(function() { 
		$("#SearchAddForm").attr("action",$(this).val());
		$("#SearchAddForm").attr("method", 'get');
		$("input[type='submit']").val("Ort suchen");
		$("#SearchQ").val("Straße und Hausnummer");
		$("#SearchAddForm").attr("method", 'get');
	}); 
	
	$('#SearchWhereSearch').click(function() { 
		$("#SearchAddForm").attr("action",$(this).val());
		$("#SearchAddForm").attr("method", 'post');
		$("#SearchQ").val("Schlagloch");
		$("input[type='submit']").val(searchSubmitValueMarker);
	}); 
		 
	$('#addFormPersonalsDiv').hide(); 
	$('#addFormMediaDiv').hide(); 
	
	$('#addFormPersonals > a').click(function (e){
		e.preventDefault();
	    $('#addFormPersonalsDiv').slideToggle('slow'); 
	});
	
	$('#addFormMedia > a').click(function (e){
		e.preventDefault();
	    $('#addFormMediaDiv').slideToggle('fast'); 
	});  	
		$('.toggletabList > a').click(function(e) { 
		e.preventDefault();
	   			 $("#tabAll").fadeIn('slow'); 
	 	}
		);
		$('.toggletabMylist > a').click(function(e) { 
		e.preventDefault();
	   			 $("#tabMy").fadeIn('slow'); 
	 	}
		);
		$('#MarkerEventStart').datepicker();
	$('#tabMenu>a').click(function() { 
	 		    $("#tabAll").show('slow'); 
	});
	
	$('#MarkerSubject').css("color","#666");
	if ($('#MarkerSubject').val() == "z.B: Gullideckel fehlt") {
	 	$('#MarkerSubject').val(""); 
	};
	
	$('#MarkersAddForm').submit(function() {
	  if ($('#MarkerSubject').val() == "z.B: Gullideckel fehlt") {
	 	$('#MarkerSubject').val(""); 
	    return false;
	  }
	});
 	
  	
	
	
	$("a.lightbox").fancybox();
	$('#flashMessage').trigger('click');
	
	
	$("#flashMessage").fancybox({
		'overlayOpacity'	:	0.7,
		'overlayColor'		:	'#FFF'
	});
	
	$("a.zoom2").fancybox({
		'zoomSpeedIn'		:	500,
		'zoomSpeedOut'		:	500
	});
	
	$('a.attachment_del').click(function(e) {
			e.preventDefault();
			var parent = $(this).parent().parent();
			alert(parent.attr('id'));
			$.ajax({
				type: 'get',
				url: '/markers/delete/'+ parent.attr('title'),
				beforeSend: function() {
					parent.animate({'backgroundColor':'#fb6c6c'},1300);
				},
				success: function() {
					parent.slideUp(300,function() {
						parent.remove();
					});
				}
			});
		});

	$('a.comment_publish').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		
		$.get('/comments/free/'+ parent.attr('title'), function(data){
			id=parent.attr('title');
			if (data == 1) {   	
				$('#publish_'+id).html(confCommon.commentHide);
				$('#comment_'+id).find("p").removeClass('c_hidden');
				$('#comment_'+id).find("p").addClass('c_publish');
			} else {   	
				$('#publish_'+id).html(confCommon.commentPublish);
				$('#comment_'+id).find("p").removeClass('c_publish');
				$('#comment_'+id).find("p").addClass('c_hidden');
			}
		});
	});
	$('a.comment_delete').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		
		$.get('/comments/delete/'+ parent.attr('title'), function(data){
			id=parent.attr('id');
			if (data == 1) {   	
				$('#comment_'+id).find("a.commentDelete").html(confCommon.commentDelete);
				parent.animate({'backgroundColor':'#fb6c6c'},1300);
				parent.slideUp(300,function() {
					parent.remove();
				});


			} else  {
			 	alert("failed");
			}
		});
	});

  	$('a.link_view').wrapInner(document.createElement("span"));
  	$('a.add').wrapInner(document.createElement("span"));
  	$('a.view').wrapInner(document.createElement("span"));

  	$('a.link_edit').wrapInner(document.createElement("span"));
  	$('a.link_delete').wrapInner(document.createElement("span"));
  	$('a.link_rss').wrapInner(document.createElement("span"));

	$('#cycleNav').append('<div id="zurueck">&lt;&lt;</div><div id="weiter">&gt;&gt;</div>');
	
	$('#info').cycle({ 
	 	timeout:       5000,  // milliseconds between slide transitions (0 to disable auto advance) 
	    speed:         1200,  // speed of the transition (any valid fx speed value) 
	    next:          '#weiter',  // id of element to use as click trigger for next slide 
	    prev:          '#zurueck',  // id of element to use as click trigger for previous slide 
	    before:        null,  // transition callback (scope set to element to be shown) 
	    after:         null,  // transition callback (scope set to element that was shown) 
	    height:       'auto', // container height 
	    sync:          1,     // true if in/out transitions should occur simultaneously 
	    fit:           1,     // force slides to fit container 
	    pause:         1,     // true to enable "pause on hover" 
	    delay:         0,     // additional delay (in ms) for first transition (hint: can be negative) 
	    slideExpr:     null   // expression for selecting slides (if something other than all children is required) 	
	});
  
    // fade out good flash messages after 3 seconds 
 
    $('.flash_success').animate({opacity: 1.0}, 5000).fadeOut();  
    $('.flash_error').animate({opacity: 1.0}, 3000).fadeOut();  
  	
	$('.sf-menu').superfish({ 
            delay:       300,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast',                          // faster animation speed 
            autoArrows:  true,                           // disable generation of arrow mark-up 
            dropShadows: false,                            // disable drop shadows 
		onShow: function() {
		$(this).addClass('open')
		},
		onHide: function() {
		$(this).addClass('open')
		}
	}); 
});



