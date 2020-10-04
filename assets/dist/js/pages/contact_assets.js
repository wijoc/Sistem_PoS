$(document).ready(function(){

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
            	$("#alert-supplier").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil menambahkan kontak supplier ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal menambahkan kontak supplier ! Silahkan ulangi proses input <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "successUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil mengubah data kontak ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-supplier").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal mengubah data product ! Silahkan ulangi proses edit. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        }
    }
})