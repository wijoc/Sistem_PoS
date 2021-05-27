$(document).ready(function() {
	/** Metode Pembayaran */
	$("#input-method").change(function () {
		if ($(this).val() == "TF") {
			$(".method-tf").css("display", "block")
			$("#input-account").prop("disabled", false)
			$("#input-account").prop("required", true)
		} else {
			$(".method-tf").css("display", "none")
			$("#input-account").prop("disabled", true)
			$("#input-account").prop("required", false)
		}
	})

    /** Submit Expense */
    $("#form-add-expenses").on("submit", function(event){
        event.preventDefault()
        var file_data = $('#input-e-file').prop('files')[0]
        var form_data = new FormData(this)
        form_data.append('file', file_data)
        $.ajax({
            url     : $("#form-add-expenses").attr("action"),
            method  : 'POST',
            data    : form_data,
            cache   : false,
            contentType : false,
            processData : false,
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success : function(result){
                if(result.error){
                    /** Error input date */
                        if(result.errorEDate){
                            $("#input-e-date").addClass('is-invalid')
                            $("#error-e-date").css("display", "block")
                            $("#error-e-date").html(result.errorEDate)
                        } else {
                            $("#input-e-date").removeClass('is-invalid')
                            $("#error-e-date").css("display", "none")
                        }

                    /** Error input necessity */
                        if(result.errorENecessity){
                            $("#input-e-necessity").addClass('is-invalid')
                            $("#error-e-necessity").css("display", "block")
                            $("#error-e-necessity").html(result.errorENecessity)
                        } else {
                            $("#input-e-necessity").removeClass('is-invalid')
                            $("#error-e-necessity").css("display", "none")
                        }

                    /** Error input No Nota */
                        if(result.errorENote){
                            $("#input-e-note").addClass('is-invalid')
                            $("#error-e-note").css("display", "block")
                            $("#error-e-note").html(result.errorENote)
                        } else {
                            $("#input-e-note").removeClass('is-invalid')
                            $("#error-e-note").css("display", "none")
                        }

                    /** Error input File Nota */
                        if(result.errorEFileNote){
                            $("#input-e-file").addClass('is-invalid')
                            $("#error-e-file").css("display", "block")
                            $("#error-e-file").html(result.errorEFileNote)
                        } else {
                            $("#input-e-file").removeClass('is-invalid')
                            $("#error-e-file").css("display", "none")
                        }

                    /** Error input Payment method */
                        if(result.errorEMethod){
                            $("#input-method").addClass('is-invalid')
                            $("#error-e-method").css("display", "block")
                            $("#error-e-method").html(result.errorEMethod)
                        } else {
                            $("#input-method").removeClass('is-invalid')
                            $("#error-e-method").css("display", "none")
                        }

                    /** Error input Rekening */
                        if(result.errorEAccount){
                            $("#input-e-account").addClass('is-invalid')
                            $("#error-e-account").css("display", "block")
                            $("#error-e-account").html(result.errorEAccount)
                        } else {
                            $("#input-e-account").removeClass('is-invalid')
                            $("#error-e-account").css("display", "none")
                        }

                    /** Error input Rekening */
                        if(result.errorEPayment){
                            $("#input-e-payment").addClass('is-invalid')
                            $("#error-e-payment").css("display", "block")
                            $("#error-e-payment").html(result.errorEPayment)
                        } else {
                            $("#input-e-payment").removeClass('is-invalid')
                            $("#error-e-payment").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-add-expenses :input').val('')
                        $('#form-add-expenses :file').val('')
						$("#input-e-file").val('')
						/** set label bs-custom-input */
						$("#input-e-file").next('.custom-file-label').html('Pilih file Nota')
						/** disable method */
						$(".method-tf").css("display", "none")
						$("#input-account").prop("disabled", true)
						$("#input-account").prop("required", false)
                    }

                    $('#table-transaction').DataTable().ajax.reload();

                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    })                    
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })

    /** Submit Revenues */
    $("#form-add-revenues").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-add-revenues").serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success : function(result){
                if(result.error){
                    /** Error input date */
                        if(result.errorRDate){
                            $("#input-r-date").addClass('is-invalid')
                            $("#error-r-date").css("display", "block")
                            $("#error-r-date").html(result.errorRDate)
                        } else {
                            $("#input-r-date").removeClass('is-invalid')
                            $("#error-r-date").css("display", "none")
                        }

                    /** Error input necessity */
                        if(result.errorRSource){
                            $("#input-r-necessity").addClass('is-invalid')
                            $("#error-r-necessity").css("display", "block")
                            $("#error-r-necessity").html(result.errorRSource)
                        } else {
                            $("#input-r-necessity").removeClass('is-invalid')
                            $("#error-r-necessity").css("display", "none")
                        }

                    /** Error input Payment method */
                        if(result.errorMethod){
                            $("#input-method").addClass('is-invalid')
                            $("#error-r-method").css("display", "block")
                            $("#error-r-method").html(result.errorMethod)
                        } else {
                            $("#input-method").removeClass('is-invalid')
                            $("#error-r-method").css("display", "none")
                        }

                    /** Error input Rekening */
                        if(result.errorAccount){
                            $("#input-r-account").addClass('is-invalid')
                            $("#error-r-account").css("display", "block")
                            $("#error-r-account").html(result.errorAccount)
                        } else {
                            $("#input-r-account").removeClass('is-invalid')
                            $("#error-r-account").css("display", "none")
                        }

                    /** Error input Biaya */
                        if(result.errorRPayment){
                            $("#input-r-payment").addClass('is-invalid')
                            $("#error-r-payment").css("display", "block")
                            $("#error-r-payment").html(result.errorRPayment)
                        } else {
                            $("#input-r-payment").removeClass('is-invalid')
                            $("#error-r-payment").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-add-revenues')[0].reset()
						/** disable method */
						$(".method-tf").css("display", "none")
						$("#input-account").prop("disabled", true)
						$("#input-account").prop("required", false)
                    }

                    $('#table-transaction').DataTable().ajax.reload();

                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    })                    
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })
})