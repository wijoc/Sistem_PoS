$(document).ready(function(){
    $(".table-catunit").DataTable({
        "responsive": true,
        "autoWidth": false,
    });

	/* Setting content tab-pane */
    $(".tabs-nav").click(function(){
        $(".tab-content").find(".tab-pane").removeClass("active");
        $($(this).attr("href")).addClass("active");
    })

    /* Function saat edit kategori di click */
    $("#table-ctgr tbody").on("click", ".ctgrEdit" ,function(){
    	var ctgr_id   = $(this).data("id");
    	var ctgr_name = $(this).data("name");
        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);
    	$("#modal-edit").find("#editID").val(ctgr_id);
    	$("#modal-edit").find("#editName").val(ctgr_name);
    	$("#formEdit").attr("action", "editCategoryProses");
    })

    /* Function saat edit satuan di click */
    $("#table-unit tbody").on("click", ".unitEdit" ,function(){
    	var unit_id   = $(this).data("id");
    	var unit_name = $(this).data("name");
        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);
        $("#modal-edit").find("#editID").val(unit_id);
        $("#modal-edit").find("#editName").val(unit_name);
        $("#formEdit").attr("action", "editUnitProses");
    })

    /* Sweetalert */
    if(typeof flashStatus !== "undefined" && flashMsg !== "undefined" ){
        if(flashStatus == "successInsert" || flashStatus == "successUpdate"){
            Swal.fire({
                position: "center",
                showConfirmButton: true,
                timer: 2500,
                icon: "success",
                title: flashMsg
            }).then((result) => {
                if(flashInput == "category"){
                    $(".tab-content").find(".tab-pane").removeClass("active");
                    $(".tabs-nav").removeClass("active");
                    $("#nav-category").addClass("active");
                    $("#category").addClass("active");
                    $("#alert-category").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                } else if (flashInput === "unit"){
                    $(".tab-content").find(".tab-pane").removeClass("active");
                    $(".tabs-nav").removeClass("active");
                    $("#nav-unit").addClass("active");
                    $("#unit").addClass("active");
                    $("#alert-unit").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ flashMsg +' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            })
        }
    }
})