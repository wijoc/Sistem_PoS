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

    $("#input-rc-status").on("change", function(){
        if($(this).val() == "U") {
            $("#input-rc-cash").prop("disabled", false)
            $("#input-rc-cash").prop("required", true)
        } else {
            $("#input-rc-cash").prop("disabled", true)
            $("#input-rc-cash").prop("required", false)
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

                    /** Error input biaya pengembalian dana */
                        if(result.errorRSCashIn){
                            $("#input-rs-cash-in").addClass('is-invalid')
                            $("#error-rs-cash-in").css("display", "block")
                            $("#error-rs-cash-in").html(result.errorRSCashIn)
                        } else {
                            $("#input-rs-cash-in").removeClass('is-invalid')
                            $("#error-rs-cash-in").css("display", "none")
                        }

                    /** Error input biaya return */
                        if(result.errorRSCashOut){
                            $("#input-rs-cash-out").addClass('is-invalid')
                            $("#error-rs-cash-out").css("display", "block")
                            $("#error-rs-cash-out").html(result.errorRSCashOut)
                        } else {
                            $("#input-rs-cash-out").removeClass('is-invalid')
                            $("#error-rs-cash-out").css("display", "none")
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

    /** Submit return supplier */
    $("#form-add-rc").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-add-rc").serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                    /** Error ID Trans Sales */
                        if(result.errorRCTSID){
                            Swal.fire({
                                position: "center",
                                showConfirmButton : true,
                                timer	: 2500,
                                icon	: 'error',
                                title	: result.errorRCTSID
                            })
                        }

                    /** Error Keranjang kosong */
                        if(result.errorRCCart){
                            Swal.fire({
                                position: "center",
                                showConfirmButton : true,
                                timer	: 2500,
                                icon	: 'error',
                                title	: result.errorRCCart
                            })
                        }

                    /** Error input date */
                        if(result.errorRCDate){
                            $("#input-rc-date").addClass('is-invalid')
                            $("#error-rc-date").css("display", "block")
                            $("#error-rc-date").html(result.errorRCDate)
                        } else {
                            $("#input-rc-date").removeClass('is-invalid')
                            $("#error-rc-date").css("display", "none")
                        }

                    /** Error input status */
                        if(result.errorRCStatus){
                            $("#input-rc-status").addClass('is-invalid')
                            $("#error-rc-status").css("display", "block")
                            $("#error-rc-status").html(result.errorRCStatus)
                        } else {
                            $("#input-rc-status").removeClass('is-invalid')
                            $("#error-rc-status").css("display", "none")
                        }

                    /** Error input biaya return */
                        if(result.errorRCCash){
                            $("#input-rc-cash").addClass('is-invalid')
                            $("#error-rc-cash").css("display", "block")
                            $("#error-rc-cash").html(result.errorRCCash)
                        } else {
                            $("#input-rc-cash").removeClass('is-invalid')
                            $("#error-rc-cash").css("display", "none")
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