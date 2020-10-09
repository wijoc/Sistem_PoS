$(document).ready(function(){

    /* Sweetalert */
    if(typeof flashStatus !== "undefined" && flashMsg !== "undefined" ){
        if(flashStatus == "successInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-product").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil menambahkan data product ! <a href="' + site_url + '" class="alert-link">Klik untuk melihat daftar produk.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedInsert"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-product").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal menambahkan data product ! Silahkan ulangi proses input, atau <a href="' + site_url + '" class="alert-link">Klik untuk melihat daftar produk.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "successUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-product").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil mengubah data product ! <a href="' + site_url + '" class="alert-link">Klik untuk melihat daftar produk.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-product").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">Gagal mengubah data product ! Silahkan ulangi proses edit, atau <a href="' + site_url + '" class="alert-link">Klik untuk melihat daftar produk.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        }
    }

})