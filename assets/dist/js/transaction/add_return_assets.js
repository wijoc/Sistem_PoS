$(document).ready(function(){
    /** Input biaya return */
    $("#input-rs-status").on("change", function(){
        if($(this).val() == "U") {
            $("#input-rs-cash-in").prop("disabled", false)
            $("#input-rs-cash-in").prop("required", true)
        } else {
            $("#input-rs-cash-in").prop("disabled", true)
            $("#input-rs-cash-in").prop("required", false)
        }
    })

    /** Submit return supplier */
    $("#form-add-rs").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-add-rs").serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                    /** Error ID Trans Purchase */
                        if(result.errorRSTPID){
                            Swal.fire({
                                position: "center",
                                showConfirmButton : true,
                                timer	: 2500,
                                icon	: 'error',
                                title	: result.errorRSTPID
                            })
                        }

                    /** Error Keranjang kosong */
                        if(result.errorRSCart){
                            Swal.fire({
                                position: "center",
                                showConfirmButton : true,
                                timer	: 2500,
                                icon	: 'error',
                                title	: result.errorRSCart
                            })
                        }

                    /** Error input date */
                        if(result.errorRSDate){
                            $("#input-rs-date").addClass('is-invalid')
                            $("#error-rs-date").css("display", "block")
                            $("#error-rs-date").html(result.errorRSDate)
                        } else {
                            $("#input-rs-date").removeClass('is-invalid')
                            $("#error-rs-date").css("display", "none")
                        }

                    /** Error input status */
                        if(result.errorRSStatus){
                            $("#input-rs-status").addClass('is-invalid')
                            $("#error-rs-status").css("display", "block")
                            $("#error-rs-status").html(result.errorRSStatus)
                        } else {
                            $("#input-rs-status").removeClass('is-invalid')
                            $("#error-rs-status").css("display", "none")
                        }

                    /** Error input biaya return */
                        if(result.errorRSCash){
                            $("#input-rs-cash").addClass('is-invalid')
                            $("#error-rs-cash").css("display", "block")
                            $("#error-rs-cash").html(result.errorRSCash)
                        } else {
                            $("#input-rs-cash").removeClass('is-invalid')
                            $("#error-rs-cash").css("display", "none")
                        }
                } else {
                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    }).then((r) => {
                        if(result.status == 'successInsert'){
                            window.location.replace(result.redirect);
                        }
                    })
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })
})