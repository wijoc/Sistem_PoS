$(document).ready(function(){

    /* Alert */
    if(typeof flashStatus !== "undefined" && flashMsg !== "undefined" ){
        if(flashStatus == "successInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-trans").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +' <a class="alert-link" href="'+ site_url +'">Klik untuk melihat data transaksi.</a> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-trans").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">'+ flashMsg +' Silahkan ulangi proses input, atau <a class="alert-link" href="'+ site_url +'">Klik untuk melihat data transaksi.</a> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "successUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-trans").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil mengubah data transaksi ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-trans").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal mengubah data transaksi ! Silahkan ulangi proses edit. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        }
    }

    /* Check file */
    $("#inputTransFileNota").bind('change', function(){
    	var allowed_ext = ['jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx'];
    	if(this.files[0].size <= 2000000){ // 2000000 Byte = 2 MB
	    	if($.inArray($(this).val().split('.').pop().toLowerCase(), allowed_ext) == -1){
	           Swal.fire({
	                position: "center",
	                showConfirmButton: true,
	                timer: 2500,
	                icon: "error",
	                title: "Format yang diijinkan : "+allowed_ext.join(", ")+" !"
	            }).then((result) => {
	            	$(this).val('');
	            	$(".custom-file-label").find("p").remove();
	            	$(".custom-file-label").append("<p>Pilih File Nota Pembayaran</p>");
	            })
	        }
	    } else {
	            Swal.fire({
	                position: "center",
	                showConfirmButton: true,
	                timer: 2500,
	                icon: "error",
	                title: "Ukuran File Maksimal 2 MB !"
	            }).then((result) => {
	            	$(this).val('');
	            	$(".custom-file-label").find("p").remove();
	            	$(".custom-file-label").append("<p>Pilih File Nota Pembayaran</p>");
	            })
	    }
    })
});