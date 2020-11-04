$(document).ready(function(){
    /* Alert */
    if(typeof flashStatus !== "undefined" && flashMsg !== "undefined" ){
    	if(flashStatus == "successUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
            	$("#alert-profile").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        } else if(flashStatus == "failedUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "error",
                title: flashMsg
            }).then((result) => {
            	$("#alert-profile").append('<div class="alert alert-danger text-center" style="opacity: 0.8" role="alert">'+ flashMsg +' Silahkan ulangi proses edit. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            })
        }
    }
})