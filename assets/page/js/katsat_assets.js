$(document).ready(function(){
    $(".table-katsat").DataTable({
        "responsive": true,
        "autoWidth": false,
    });

	/* Setting content tab-pane */
    $(".tabs-pilihan").click(function(){
        $(".tab-content").find(".tab-pane").removeClass("active");
        $($(this).attr("href")).addClass("active");
    })

    /* Function saat edit kategori di click */
    $(".ktgrEdit").click(function(){
    	var id   = $(this).data("id");
    	var nama = $(this).data("nama");
        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);
    	$("#modal-edit").find("#editID").val(id);
    	$("#modal-edit").find("#editNama").val(nama);
    	$("#formEdit").attr("action", "editKategoriProses");
    })

    /* Function saat edit satuan di click */
    $(".satuanEdit").click(function(){
    	var id   = $(this).data("id");
    	var nama = $(this).data("nama");
        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);
    	$("#modal-edit").find("#editID").val(id);
    	$("#modal-edit").find("#editNama").val(nama);
    	$("#formEdit").attr("action", "editSatuanProses");
    })

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
                if(flashInput == "kategori"){
                    $(".tab-content").find(".tab-pane").removeClass("active");
                    $(".tabs-pilihan").removeClass("active");
                    $("#pilihan-kategori").addClass("active");
                    $("#kategori").addClass("active");
                    $("#alert-kategori").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil menambahkan data kategori product !</div>');
                } else if (flashInput === "satuan"){
                    $(".tab-content").find(".tab-pane").removeClass("active");
                    $(".tabs-pilihan").removeClass("active");
                    $("#pilihan-satuan").addClass("active");
                    $("#satuan").addClass("active");
                    $("#alert-satuan").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">Berhasil menambahkan data satuan</div>');
                }
            })
        }
    }
})