$(document).ready(function(){
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
});