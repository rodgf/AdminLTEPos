	function money(){
		$(".money").blur(function() {
			//var angka=parseInt(cleanString($(this).val()));
			var angka=parseFloat(cleanString($(this).val()));
			if(angka ==''){
				$(this).val(0);	
			}else{
				if(isNaN(angka))
				{
					angka=0;
				}
				$(this).val(addCommas(angka));	
			}
		});

		$(".money").focus(function(e){
			if(e.which === 9){
				return false;
			}
			$(this).select();
		});
	}
	function decimal(){
		$(".decimal").blur(function(){
			var angka=parseFloat($(this).val());
			if(isNaN(angka))
			{
				angka=0;
			}
			$(this).val(angka);		
		});

		$(".decimal").focus(function(e){
			if(e.which === 9){
				return false;
			}
			$(this).select();
		});
	}
	$(function() {  

		$(document).on( 'scroll', function()
		{
			if ($(window).scrollTop() > 100) {
				$('.scroll-top-wrapper').addClass('show');
			} else {
				$('.scroll-top-wrapper').removeClass('show');
			}
		});
		$('.scroll-top-wrapper').on('click', scrollToTop);
	});
	
	

	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

	function cleanString (str) 
	{
		return str.replace(/[^0-9.-]/g, "")
	}

	function set_focus(element){
		setTimeout(function() {
			$(element).focus();
		}, 600); 
	}

	function proccess_waiting(element,text){
		if(text != null){
			var kata=text;
		}else{
			var kata='Please wait, is proccessing... ';
		}
		$(element).html('<i class="fa fa-refresh fa-spin"></i> '+kata);
	}
	function scrollToTop() {
		verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
		element = $('body');
		offset = element.offset();
		offsetTop = offset.top;
		$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
	}


	$.notifyDefaults({
		type: 'success',
		delay: 500
	});

	$(document).on("blur",".ui-autocomplete-input",function(){
		$(this).removeClass("working");
	});

	function loading_start()
	{
		$("#loadbargood").removeClass("hidden");

	}
	function loading_stop()
	{
		$("#loadbargood").addClass("hidden");
	}
