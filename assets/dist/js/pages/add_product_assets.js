$(document).ready(function(){
    $("#submitForm").on("click", function(event){
        event.preventDefault()
        $.ajax({
            url     : $("#formAddPrd").attr("action"),
            method  : 'post',
            data    : $("#formAddPrd").serialize(),
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
                            $("#errorIsi").css("display", "noen")
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
                            $("#inputStokOP").removeClass('is-invalid')
                            $("#errorStockOP").css("display", "none")
                        }
                } else {
                    if(data.status == 'successInsert'){
                        $("#formAddPrd").trigger('reset')
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        $("#alert-proses").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<a href="' + data.redirect + '" class="alert-link">Klik untuk melihat daftar data.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    })
                }
            }
        })
    })
})