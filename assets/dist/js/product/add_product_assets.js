$(document).ready(function(){
    $("#submitForm").on("click", function(event){
        event.preventDefault()
        var file_data = $('#inputImg').prop('files')[0]; 
        var form_data = new FormData(this.form);
        form_data.append('file', file_data);    
        $.ajax({
            url     : $("#formAddPrd").attr("action"),
            method  : 'post',
            data    : form_data,
            cache   : false,
            contentType : false,
            processData : false,
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success : function(data){
                if(data.error){
                    /** Error input nama */
                        if(data.errorNama){
                            $("#inputNama").addClass('is-invalid')
                            $("#errorNama").css("display", "block")
                            $("#errorNama").html(data.errorNama)
                        } else {
                            $("#inputNama").removeClass('is-invalid')
                            $("#errorNama").css("display", "none")
                        }

                    /** Error input kategori */
                        if(data.errorKategori){
                            $("#inputKategori").addClass('is-invalid')
                            $("#errorKategori").css("display", "block")
                            $("#errorKategori").html(data.errorKategori)
                        } else {
                            $("#inputKategori").removeClass('is-invalid')
                            $("#errorKategori").css("display", "none")
                        }
                        
                    /** Error input Harga Beli */
                        if(data.errorHrgBeli){
                            $("#inputHargaBeli").addClass('is-invalid')
                            $("#errorHargaBeli").css("display", "block")
                            $("#errorHargaBeli").html(data.errorHrgBeli)
                        } else {
                            $("#inputHargaBeli").removeClass('is-invalid')
                            $("#errorHargaBeli").css("display", "none")
                        }
                        
                    /** Error input Harga Jual */
                        if(data.errorHrgJual){
                            $("#inputHargaJual").addClass('is-invalid')
                            $("#errorHargaJual").css("display", "block")
                            $("#errorHargaJual").html(data.errorHrgJual)
                        } else {
                            $("#inputHargaJual").removeClass('is-invalid')
                            $("#errorHargaJual").css("display", "none")
                        }
                        
                    /** Error input Satuan */
                        if(data.errorSatuan){
                            $("#inputSatuan").addClass('is-invalid')
                            $("#errorSatuan").css("display", "block")
                            $("#errorSatuan").html(data.errorSatuan)
                        } else {
                            $("#inputSatuan").removeClass('is-invalid')
                            $("#errorSatuan").css("display", "none")
                        }
                        
                    /** Error input Isi */
                        if(data.errorIsi){
                            $("#inputIsi").addClass('is-invalid')
                            $("#errorIsi").css("display", "block")
                            $("#errorIsi").html(data.errorIsi)
                        } else {
                            $("#inputIsi").removeClass('is-invalid')
                            $("#errorIsi").css("display", "none")
                        }
                        
                    /** Error input Stok Awal */
                        if(data.errorStockG){
                            $("#inputStockG").addClass('is-invalid')
                            $("#errorStockG").css("display", "block")
                            $("#errorStockG").html(data.errorStockG)
                        } else {
                            $("#inputStockG").removeClass('is-invalid')
                            $("#errorStockG").css("display", "none")
                        }
                        
                    /** Error input Stok Rusak */
                        if(data.errorStockNG){
                            $("#inputStockNG").addClass('is-invalid')
                            $("#errorStockNG").css("display", "block")
                            $("#errorStockNG").html(data.errorStockNG)
                        } else {
                            $("#inputStockNG").removeClass('is-invalid')
                            $("#errorStockNG").css("display", "none")
                        }
                        
                    /** Error input Stok Opname */
                        if(data.errorStockOP){
                            $("#inputStockOP").addClass('is-invalid')
                            $("#errorStockOP").css("display", "block")
                            $("#errorStockOP").html(data.errorStockOP)
                        } else {
                            $("#inputStockOP").removeClass('is-invalid')
                            $("#errorStockOP").css("display", "none")
                        }
                    
                    /** Error input Image */
                        if(data.errorImg){
                            $("#errorImg").css("display", "block")
                            $("#errorImg").html(data.errorImg)
                        } else {
                            $("#errorImg").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(data.status == 'successInsert'){
                        $('#formAddPrd :input').val('');
                        $('#formAddPrd :file').val('');
                        $(".dropify-clear").trigger("click")
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        $("#alert-proses").html('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<a href="' + data.redirect + '" class="alert-link">Klik untuk melihat daftar data.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    })
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
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