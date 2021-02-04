$(document).ready(function(){
    /* Sweetalert */
    if(typeof flashStatus !== "undefined" && flashMsg !== "undefined" ){
        if(flashStatus == "success"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
              if(site_url !== ''){
                $("#alert-proses").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +'<a href="' + site_url + '" class="alert-link">Klik untuk melihat daftar data.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              } else {
                $("#alert-proses").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              }
            })
        } else {
          Swal.fire({
              position: "center",
              showConfirmButton: true,
              timer: 2500,
              icon: "success",
              title: flashMsg
          }).then((result) => {
            if(site_url == ''){
              $("#alert-proses").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +'<a href="' + site_url + '" class="alert-link">Klik untuk melihat data.</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
              $("#alert-proses").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
          })
        }
    }
  
  })