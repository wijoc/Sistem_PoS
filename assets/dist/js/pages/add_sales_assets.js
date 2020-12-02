$(document).ready(function(){

    /* Function saat edit satuan di click 
    $("#ctm-search").on("keyup", function(){
    	var searchTerm = $(this).val();
        $.ajax({
            url : ctmSearchUrl,
            method : "POST",
            data   : {term : searchTerm},
            success : function(data){
            	$("#ctm-data").html(data)
            }
        })
    })*/
});

/* Function cari customer */
function searchCtm(){
	var searchTerm = $("#ctm-search").val();
	$.ajax({
		url : ctmSearchUrl,
		method : "POST",
		data   : {term : searchTerm},
		success : function(data){
			$("#ctm-data").html(data)
        }
    })
}

/* Function select customer */
function ctmSelected(ctm_id){
	$("#ctm-search").val('');
	searchCtm();
	console.log(ctm_id);
}