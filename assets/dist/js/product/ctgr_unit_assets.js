$(document).ready(function(){
	/** Setting content tab-pane */
    $(".tabs-nav").click(function(){
        $(".tab-content").find(".tab-pane").removeClass("active")
        $($(this).attr("href")).addClass("active")
    })

    /** Submit form-data */
    $("#form-ctgr").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-ctgr").serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            },
            success : function(data){
                if(data.error){
                    if(data.errorCtgr){
                        $("#form-ctgr").find("#inputCtgrName").addClass('is-invalid')
                        $("#form-ctgr").find("#errorCtgr").css("display", "block")
                        $("#form-ctgr").find("#errorCtgr").html(data.errorCtgr)
                    } else {
                        $("#form-ctgr").find("#inputCtgrName").removeClass('is-invalid')
                        $("#form-ctgr").find("#errorCtgr").css("display", "none")
                    }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(data.status == 'successInsert'){
                        $("#form-ctgr").trigger("reset")
                        $("#modal-category").modal("toggle")
                        $("#table-category").DataTable().ajax.reload()
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        $(".tab-content").find(".tab-pane").removeClass("active")
                        $(".tabs-nav").removeClass("active")
                        $("#nav-category").addClass("active")
                        $("#category").addClass("active")
                        $("#alert-category").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Submit form-data */
    $("#form-unit").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            },
            success : function(data){
                if(data.error){
                    if(data.errorUnit){
                        console.log(data.errorUnit)
                        $("#form-unit").find("#inputUnitName").addClass('is-invalid')
                        $("#form-unit").find("#errorUnit").css("display", "block")
                        $("#form-unit").find("#errorUnit").html(data.errorUnit)
                    } else {
                        $("#form-unit").find("#inputUnitName").removeClass('is-invalid')
                        $("#form-unit").find("#errorUnit").css("display", "none")
                    }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(data.status == 'successInsert'){
                        $("#form-unit").trigger("reset")
                        $("#modal-unit").modal("toggle")
                        $("#table-unit").DataTable().ajax.reload()
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        $(".tab-content").find(".tab-pane").removeClass("active")
                        $(".tabs-nav").removeClass("active")
                        $("#nav-unit").addClass("active")
                        $("#unit").addClass("active")
                        $("#alert-unit").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Submit form edit */
    $("#form-edit").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).prop("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            },
            success : function(data){
                if(data.success){
                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        $(".tab-content").find(".tab-pane").removeClass("active")
                        $(".tabs-nav").removeClass("active")
                        $('#modal-edit').modal("toggle")
    
                        if(data.type == 'ctgr'){
                            $("#nav-category").addClass("active")
                            $("#category").addClass("active")
                            $("#alert-category").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
                            $("#table-category").DataTable().ajax.reload()
                        } else if (data.type == 'unit') {
                            $("#nav-unit").addClass("active")
                            $("#unit").addClass("active")
                            $("#alert-unit").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
                            $("#table-unit").DataTable().ajax.reload()
                        }
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Datatables Kategori serverside */
    var ctgrTable = $("#table-category").DataTable({
        'responsive': true,
        'autoWidth' : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        //'order'      : [1, 'desc'], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : ctgr_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }]
    })

    /** Datatables Kategori serverside */
    var unitTable = $("#table-unit").DataTable({
        'responsive': true,
        'autoWidth' : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        //'order'      : [1, 'desc'], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : unit_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }]
    })
})

function editCtgrUnit(type, id, name){
    if(type == 'ctgr'){
        $("#edit-title").html("Kategori")
        $('#modal-edit').modal("toggle")

        $("#editID").prop("required", true)
        $("#editID").prop("disabled", false)
    	
        $("#modal-edit").find("#editID").val(id)
    	$("#modal-edit").find("#editName").val(name)
    	$("#form-edit").attr("action", "editCategoryProses")
    } else {
        $("#edit-title").html("Satuan")
        $('#modal-edit').modal("toggle")

        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);

        $("#modal-edit").find("#editID").val(id);
        $("#modal-edit").find("#editName").val(name);
        $("#form-edit").attr("action", "editUnitProses");
    }
}