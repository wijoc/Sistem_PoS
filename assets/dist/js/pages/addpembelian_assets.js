$(document).ready(function(){
	/* Set nilai awal saat pertama kali halaman dibuka */
	var awalTotal = $("#inputTransBeli").val();
	$("#inputTransKurang").val(awalTotal);

	/* perubahan Metode */
	$("#inputTransMetode").change(function(){
		if($(this).val() == 'TF'){
			$("#formpartRekening").removeAttr("style").show();
	        $("#editID").prop("required", true);
	        $("#editID").prop("disabled", false);
		} else {
	        $("#editID").prop("required", false);
	        $("#editID").prop("disabled", true);
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

function totalBayar(){
	var prdJumlah = $("#inputJumlahPrd").val();
	var prdHarga  = $("#inputHargaPrd").val();
	var total = parseInt(prdJumlah) * parseFloat(prdHarga);

	if(isNaN(total)){
		$("#inputTotalPrd").val(0);
	} else {
		$("#inputTotalPrd").val(total);
	}
}

function hitungPayment(){
	var totalBayar = $("#inputTransBeli").val();
	var dibayar	   = $("#inputTransBayar").val();
	var kurangan   = parseFloat(totalBayar) - parseFloat(dibayar); 

	console.log(dibayar);

	if(isNaN(dibayar) || dibayar == ''){
		$("#inputTransKurang").val(totalBayar);
	} else {
		$("#inputTransKurang").val(kurangan);
		if(kurangan > 0){
			$("#inputTransStatus option[value=BL]").attr("selected", "selected");
			$("#inputTransStatus option[value=L]").removeAttr("selected");
		} else {
			$("#inputTransStatus option[value=L]").attr("selected", "selected");
			$("#inputTransStatus option[value=BL]").removeAttr("selected");
		}
	}
}