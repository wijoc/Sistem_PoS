$(document).ready(function(){
    /* Check file */
    $("#input-ip-file").bind('change', function(){
    	var allowed_ext = ['jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx']
    	if(this.files[0].size <= 2000000){ // 2000000 Byte = 2 MB
	    	if($.inArray($(this).val().split('.').pop().toLowerCase(), allowed_ext) == -1){
                $(this).val('')
                $("#input-ip-file").addClass('is-invalid')
                $("#error-ip-file").css("display", "block")
                $("#error-ip-file").html("Ext harus : "+allowed_ext.join("/ ")+" !")
                $(".custom-file-label").find("p").remove()
                $(".custom-file-label").append("<p>Pilih File Nota</p>")
	        } else {
                $("#input-ip-file").removeClass('is-invalid')
                $("#error-ip-file").css("display", "none")
                $("#error-ip-file").html('')
            }
	    } else {
            $(this).val('')
            $("#input-ip-file").addClass('is-invalid')
            $("#error-ip-file").css("display", "block")
            $("#error-ip-file").html("Ukuran File Maksimal 2 MB !")
            $(".custom-file-label").find("p").remove()
            $(".custom-file-label").append("<p>Pilih File Nota</p>")
	    }
    })

    /* Status Change */
    $("#input-ip-status").change(function (){
        if ($(this).val() == 'BL') {
            $("#input-ip-due").prop("disabled", false)
            $("#input-ip-due").prop("required", true)
        } else {
            $("#input-ip-due").prop("required", false)
            $("#input-ip-due").prop("disabled", true)
        }
    })

    /** Last tenor */
    $("#input-ip-periode-end").change(function (){
        if($(this).val() == max_tenor){
            $("#input-ip-status").val('L')
            $("#input-ip-due").prop("required", false)
            $("#input-ip-due").prop("disabled", true)
        } else {
            $("#input-ip-status").val('BL')
            $("#input-ip-due").prop("disabled", false)
            $("#input-ip-due").prop("required", true)
        }
    })

	/** Submit Purchases */
	$("#form-installment-purchases").on("submit", function(event){
        event.preventDefault()
        var file_data = $('#input-ip-file').prop('files')[0] 
        var form_data = new FormData(this)
        form_data.append('file', file_data)
        $.ajax({
            url     : $("#form-installment-purchases").attr("action"),
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
                        if(result.errorPDate){
                            $("#input-ip-date").addClass('is-invalid')
                            $("#error-ip-date").css("display", "block")
                            $("#error-ip-date").html(result.errorPDate)
                        } else {
                            $("#input-ip-date").removeClass('is-invalid')
                            $("#error-ip-date").css("display", "none")
                        }
                        
                    /** Error input note */
                        if(result.errorIPNote){
                            $("#input-ip-note").addClass('is-invalid')
                            $("#error-ip-note").css("display", "block")
                            $("#error-ip-note").html(result.errorIPNote)
                        } else {
                            $("#input-ip-note").removeClass('is-invalid')
                            $("#error-ip-note").css("display", "none")
                        }

                    /** Error input note file */
                        if(result.errorIPNoteFile){
                            $("#input-ip-file").addClass('is-invalid')
                            $("#error-ip-file").css("display", "block")
                            $("#error-ip-file").html(result.errorIPNoteFile)
                        } else {
                            $("#input-ip-file").removeClass('is-invalid')
                            $("#error-ip-file").css("display", "none")
                        }

                    /** Error input Periode */
                        if(result.errorIPPeriodeStart){
                            $(".input-ip-periode").addClass('is-invalid')
                            $("#error-ip-periode").css("display", "block")
                            $("#error-ip-periode").html(result.errorIPPeriodeStart)
                        } else {
                            $(".input-ip-periode").removeClass('is-invalid')
                            $("#error-ip-periode").css("display", "none")
                        }

                    /** Error input Periode */
                        if(result.errorIPPeriodeEnd){
                            $(".input-ip-periode").addClass('is-invalid')
                            $("#error-ip-periodeb").css("display", "block")
                            $("#error-ip-periodeb").html(result.errorIPPeriodeEnd)
                        } else {
                            $(".input-ip-periode").removeClass('is-invalid')
                            $("#error-ip-periodeb").css("display", "none")
                        }
                        
                    /** Error input Angsuran */
                        if(result.errorIPInstallment){
                            $("#input-ip-installment").addClass('is-invalid')
                            $("#error-ip-installment").css("display", "block")
                            $("#error-ip-installment").html(result.errorIPInstallment)
                        } else {
                            $("#input-ip-installment").removeClass('is-invalid')
                            $("#error-ip-installment").css("display", "none")
                        }
                        
                    /** Error input Status */
                        if(result.errorIPStatus){
                            $("#input-ip-status").addClass('is-invalid')
                            $("#error-ip-status").css("display", "block")
                            $("#error-ip-status").html(result.errorIPStatus)
                        } else {
                            $("#input-ip-status").removeClass('is-invalid')
                            $("#error-ip-status").css("display", "none")
                        }
                        
                    /** Error input Tempo */
                        if(result.errorIPDue){
                            $("#input-ip-due").addClass('is-invalid')
                            $("#error-ip-due").css("display", "block")
                            $("#error-ip-due").html(result.errorIPDue)
                        } else {
                            $("#input-ip-due").removeClass('is-invalid')
                            $("#error-ip-due").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-installment-purchases :input').val('')
                        $('#form-installment-purchases :file').val('')
						$("#input-ip-file").val('')
						/** set label bs-custom-input */
						$("#input-ip-file").next('.custom-file-label').html('Pilih file Nota')
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    })
                    
                    $('input[name="postIPPeriodeStart"]').val(result.min_tenor)
                    option_periode = '';
                    for(a = result.min_tenor; a <= result.max_tenor; a++){
                        option_periode += `<option value="`+a+`">`+a+`</option>`
                    }
                    $("#input-ip-periode-end").html(option_periode)

                    getIntallment()
                }
			},
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception)
            }
		})
	})

    /** Run function */
    getIntallment()
})

/** Get Installment */
function getIntallment(){
    $.ajax({
        url     : installment_url,
        cache   : false,
        contentType : false,
        processData : false,
        datatype    : 'json',
        success : function(result){
            var output = '';
            if(parseInt(result.count_rows) <= 0){
                output = `<tr>
                            <td colspan="5" class="alert-danger">Belum ada pembayaran !</td>
                          </tr>`
            } else {
                for(index in result.iP_data) {
                    output += ` <tr>
                                    <td class="text-center">`+ result.iP_data[index].i_periode +`</td>
                                    <td class="text-center">`+ result.iP_data[index].i_date +`</td>
                                    <td class="text-center">`+ result.iP_data[index].i_payment +`</td>
                                    <td>`+ result.iP_data[index].i_note +`</td>
                                    <td class="text-center">`+ result.iP_data[index].i_file +`</td>
                                    <td class="text-justify">`+ result.iP_data[index].i_ps +`</td>
                                </tr>`
                }
            }
            
            $("#table-installment tbody").html(output)
        },
        error: function(jqxhr, status, exception) {
            alert('Exception:', exception)
        }
    })
}