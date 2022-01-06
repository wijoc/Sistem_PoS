$(document).ready(function(){
    $("#submitForm").on("click", function(event){
        event.preventDefault()
        var file_data = $('#inputImg').prop('files')[0]; 
        var form_data = new FormData(this.form);
        form_data.append('file', file_data);    
        $.ajax({
            url     : product_url,
            method  : 'POST',
            data    : form_data,
            cache   : false,
            contentType : false,
            processData : false,
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            statusCode: {
                200: function (response) {
                    console.log(response)
                },
                201: function (response) {
                    console.log(response)
                },
            },
            // success : function(data){ // Pakai ini jika ajax success
            // },
            error: function(jqxhr, status, error) {
                alert('error:', error);
                console.log('jqxhr : ' + jqxhr)
                console.log('status : ' + status)
                console.log('error : ' + error)
            }
        })
    })

    /** Submit form mutation */
    $("#form-stock-mutation").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : "POST",
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                    if(result.errorPrdID){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 1500,
                            icon: "error",
                            title: result.errorPrdID
                        })
                    }
                    
                    /** Error Stock Tgl */
                    if(result.errorStockDate){
                        $("#input-stock-date").addClass('is-invalid')
                        $("#error-stock-date").css("display", "block")
                        $("#error-stock-date").html(result.errorStockDate)
                    } else {
                        $("#input-stock-date").removeClass('is-invalid')
                        $("#error-stock-date").css("display", "none")
                    }
                    
                    /** Error Stock from */
                    if(result.errorStockA){
                        $("#input-stock-from").addClass('is-invalid')
                        $("#error-stock-from").css("display", "block")
                        $("#error-stock-from").html(result.errorStockA)
                    } else {
                        $("#input-stock-from").removeClass('is-invalid')
                        $("#error-stock-from").css("display", "none")
                    }

                    /** Error Stock to  */
                    if(result.errorStockB){
                        $("#input-stock-to").addClass('is-invalid')
                        $("#error-stock-to").css("display", "block")
                        $("#error-stock-to").html(result.errorStockB)
                    } else {
                        $("#input-stock-to").removeClass('is-invalid')
                        $("#error-stock-to").css("display", "none")
                    }

                    /** Error Qty */
                    if(result.errorStockQty){
                        $("#input-stock-qty").addClass('is-invalid')
                        $("#error-stock-qty").css("display", "block")
                        $("#error-stock-qty").html(result.errorStockQty)
                    } else {
                        $("#input-stock-qty").removeClass('is-invalid')
                        $("#error-stock-qty").css("display", "none")
                    }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: result.statusIcon,
                        title: result.statusMsg
                    }).then((r) => {
                        if(result.status == 'successInsert'){
                            window.location.replace(result.redirect);
                        }
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })
})