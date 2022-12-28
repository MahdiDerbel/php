function createCookie(name, value, days,addarray) {
    var expires;
	if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
	if(addarray==1){
		var lastvalue=readCookie(name);
		if(lastvalue!=null)var tablastvalue=lastvalue.split('&&');
		else var tablastvalue=new Array();
		var trouve=false;
		console.log('tablastvalue = '+tablastvalue);
		jQuery.each(tablastvalue,function(index,key){
			if (value == key)trouve=true;					   
		 });
		if(!trouve){
			value=lastvalue+value+'&&';
		}else value=lastvalue;
	}
	document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";	
}

function readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
	
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}
function viderliste(name){
	jQuery('#nb_item_compare').html('<a>0</a>');
	eraseCookie(name);
	window.location.href=window.location.href;
}
function viderlisteDevis(name){
	$('#nb_product_devis').html('');
	eraseCookie(name);
	window.location.href=window.location.href;
}
function deletefromlist(itemid){
	if(readCookie('Panierbiosphere')){
		var liste_to_delete= readCookie('Panierbiosphere');
		liste_to_delete=liste_to_delete.split('&&');
		var newvalue="",nb_element=0;
		jQuery.each(liste_to_delete,function(index,value){
			if(value != itemid && value!=null && value != "")	 {
				newvalue+=value+"&&";
				nb_element=nb_element+1;
			}
		});
		// mettre a jour value cookies 	Listcompare
		var expires="";
		 document.cookie = escape('Panierbiosphere') + "=" + escape(newvalue) + expires + "; path=/";	
		return true;
	}else return false;
}
