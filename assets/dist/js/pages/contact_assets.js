$(document).ready(function(){

    /* Function saat edit satuan di click */
    $(".contactEdit").on("click", function(){
        var contact_id   = $(this).data("id")
        var contact_type = $(this).data("type")
        var url = $(this).data("href")
        $.ajax({
            url : url,
            method : "POST",
            data   : {id : contact_id},
            dataType : 'json',
            success : function(data){
                if(contact_type === 'supp'){
                    $('#formEditSupplier').find('#editSuppID').val(data.edit_id)
                    $('#formEditSupplier').find('#editSuppNama').val(data.edit_name)
                    $('#formEditSupplier').find('#editSuppKontak').val(data.edit_contact)
                    $('#formEditSupplier').find('#editSuppTelp').val(data.edit_telp)
                    $('#formEditSupplier').find('#editSuppEmail').val(data.edit_email)
                    $('#formEditSupplier').find('#editSuppAlamat').val(data.edit_address)
                } else if(contact_type === 'ctm'){
                    $('#formEditCustomer').find('#editCtmID').val(data.data_id)
                    $('#formEditCustomer').find('#editCtmNama').val(data.data_name)
                    $('#formEditCustomer').find('#editCtmTelp').val(data.data_phone)
                    $('#formEditCustomer').find('#editCtmEmail').val(data.data_email)
                    $('#formEditCustomer').find('#editCtmAddress').val(data.data_address)
                }
            }
        })
    })

    /* Alert */
    if(typeof flashStatus !== "undefined" && flashMsg !== "undefined" ){
        if(flashStatus == "successInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil menambahkan kontak supplier ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
            })
        } else if(flashStatus == "failedInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal menambahkan kontak supplier ! Silahkan ulangi proses input <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
            })
        } else if(flashStatus == "successUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil mengubah data kontak ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
            })
        } else if(flashStatus == "failedUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal mengubah data product ! Silahkan ulangi proses edit. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
            })
        }
    }
})