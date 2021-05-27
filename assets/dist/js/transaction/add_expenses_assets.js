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
                console.log(result)
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

                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })
})