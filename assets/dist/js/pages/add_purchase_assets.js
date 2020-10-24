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
            	$("#alert-trans").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil menambahkan transaksi ! <a class="alert-link" href="'+ site_url +'">Klik untuk melihat data transaksi.</a> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-trans").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal menambahkan transaksi ! Silahkan ulangi proses input, atau <a class="alert-link" href="'+ site_url +'">Klik untuk melihat data transaksi.</a> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
	            	$(".custom-file-label").append("<p>Pilih File Nota Pembelian</p>");
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
	            	$(".custom-file-label").append("<p>Pilih File Nota Pembelian</p>");
	            })
	    }
    })

	/* Perubahan Status pembayaran */
	$("#inputTransStatus").change(function(){
		if($(this).val() == "K"){
			$(".tenortempo").prop("required", true);
			$(".tenortempo").prop("disabled", false);
			$("#inputTransAngsuran").prop("required", true);
			$("#inputTransAngsuran").prop("disabled", false);
			$("#inputTransTempo").prop("required", true);
			$("#inputTransTempo").prop("disabled", false);
		} else {
			$(".tenortempo").prop("required", false);
			$(".tenortempo").prop("disabled", true);
			$("#inputTransAngsuran").prop("required", false);
			$("#inputTransAngsuran").prop("disabled", true);
			$("#inputTransTempo").prop("required", false);
			$("#inputTransTempo").prop("disabled", true);
		}
	})

	/* perubahan Metode */
	$("#inputTransMetode").change(function(){
		if($(this).val() == 'TF'){
			$("#formpartRekening").removeAttr("style").show();
	        $("#inputTransRek").prop("required", true);
	        $("#inputTransRek").prop("disabled", false);
		} else {
	        $("#inputTransRek").prop("required", false);
	        $("#inputTransRek").prop("disabled", true);
			$("#formpartRekening").hide();
		}
	});

	/* Autocomplete on Nama atau Barcode Product */
	$("#inputNamaPrd").autocomplete({
		source: autocompleteUrl,

		select: function(event, ui){
			$('[name="postIdPrd"]').val(ui.item.prd_id);
			$('[name="postNamaPrd"]').val(ui.item.label);
			$('[name="postHargaPrd"]').val(ui.item.prd_harga_beli);
		}
	})
});

function totalBayar(page){
	var prdJumlah = $("#inputJumlahPrd").val();
	var prdHarga  = $("#inputHargaPrd").val();
	if(page == 'sales'){
		var prdPotongan = $("#inputPotonganPrd").val();
		var potongan = (prdPotongan != '')? prdPotongan : 0 ;
		var total = parseInt(prdJumlah) * parseFloat(prdHarga) - parseFloat(potongan);
	} else {
		var total = parseInt(prdJumlah) * parseFloat(prdHarga);
	}

	if(isNaN(total)){
		$("#inputTotalPrd").val(0);
	} else {
		$("#inputTotalPrd").val(total);
	}
}

function hitungPayment(){
	var totalBayar = $("#inputTransTotalBayar").val();
	var dibayar	   = $("#inputTransPembayaran").val();
	var kurangan   = parseFloat(totalBayar) - parseFloat(dibayar); 

	if(isNaN(dibayar) || dibayar == ''){
		$("#inputTransKurang").val(totalBayar);
	} else {
		if(kurangan > 0){
			$("#inputTransStatus option[value=BL]").attr("selected", "selected");
			$("#inputTransStatus option[value=L]").removeAttr("selected");
			$(".tenortempo").prop("disabled", false);
	        $(".tenortempo").prop("required", true);
			$("#inputTransKurang").val(kurangan);
		} else {
			$("#inputTransStatus option[value=L]").attr("selected", "selected");
			$("#inputTransStatus option[value=BL]").removeAttr("selected");
			$(".tenortempo").prop("disabled", true);
	        $(".tenortempo").prop("required", false);
			$("#inputTransKurang").val(0);
		}
	}
}