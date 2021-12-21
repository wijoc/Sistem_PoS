$(document).ready(function(){
	/** Setting content tab-pane */
    $(".tabs-nav").click(function(){
        $(".tab-content").find(".tab-pane").removeClass("active")
        $($(this).attr("href")).addClass("active")
    })

    /** Add button click event to clear form */
    $("#add-cat-button").click(function(){
        $("#modal-category").find("#form-title").html("Tambah")
        $('#modal-category').modal("toggle")
        $("#form-cat").attr("method", "POST")
        $("#form-cat").attr("action", cat_url)

        $("#form-cat").find("#edit-cat-id").prop("required", false)
        $("#form-cat").find("#edit-cat-id").prop("disabled", true)

        $("#form-cat").trigger('reset')
        $("#input-cat-name").removeClass('is-invalid')
        $("#error-cat-name").css("display", "none")
    })
    $("#add-unit-button").click(function(){
        $("#modal-unit").find("#form-title").html("Tambah")
        $('#modal-unit').modal("toggle")
        $("#form-unit").attr("method", "POST")

        $("#form-unit").find("#edit-unit-id").prop("required", false)
        $("#form-unit").find("#edit-unit-id").prop("disabled", true)

        $("#form-unit").trigger('reset')
        $("#input-unit-name").removeClass('is-invalid')
        $("#error-unit-name").css("display", "none")
    })

    /** Datatables Kategori serverside */
    var catTable = $("#table-category").DataTable({
        responsive  : true,
        autoWidth   : false,
        processing  : true, // Fitur control indicator "processing"
        serverSide  : true, // Fitur control datatables server-side processing mode
        order       : [], // Set nilai default order ke null
        lengthMenu  : [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]], // Option tampil data, kiri : banyak data - kanan : pilihan
        // dom         : 'ltr'+'<"row justify-content-md-center"<"col-sm col-md"i><"col-sm col-md">p>',
        searching   : true,
        pageLength  : 10, // Max row tiap page

        /** Get data dari api menggunakan ajax */
        ajax  : {
            url   : cat_url,
            type  : 'GET',
            datatype : 'json',
            data : {
                'necessity' : 'dt'
                // 'start' : 0, // pakai untuk offset data
                // 'length' : 3, // pakai untuk limit data
            }
        },
        /** Set coloumn properties */
        columnDefs   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }],
        columns   : [
            { 'data': 'data_no'},
            { 'data': 'data_name' },
            { 'data': 'data_product' },
            { 'data': null, 
                'render': function (resp) {
                return `<a class="btn btn-xs btn-info text-white" data-toggle="tooltip" data-placement="top" title="Detail kategori"><i class="fas fa-search"></i></a>
                <a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah kategori" onclick="editData('ctgr', '`+resp.data_id+`', '`+cat_url+`', '')"><i class="fas fa-edit"></i></a>
                <a class="btn btn-xs btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Hapus kategori" onclick="confirmDelete('ctgr', '`+resp.data_id+`', '`+cat_url+`', '')"><i class="fas fa-trash"></i></a>`
              }
            },
        ]
    })

    /** Datatables Unit serverside */
    var unitTable = $("#table-unit").DataTable({
        responsive  : true,
        autoWidth   : false,
        processing  : true, // Fitur control indicator "processing"
        serverSide  : true, // Fitur control datatables server-side processing mode
        order       : [], // Set nilai default order ke null
        lengthMenu  : [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]], // Option tampil data, kiri : banyak data - kanan : pilihan
        // dom         : 'ltr'+'<"row justify-content-md-center"<"col-sm col-md"i><"col-sm col-md">p>',
        searching   : true,
        pageLength  : 10, // Max row tiap page

        /** Get data dari api menggunakan ajax */
        ajax  : {
            url   : unit_url,
            type  : 'GET',
            datatype : 'json',
            data : {
                'necessity' : 'dt'
                // 'start' : 0, // pakai untuk offset data
                // 'length' : 3, // pakai untuk limit data
            }
        },
        /** Set coloumn properties */
        columnDefs   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }],
        columns   : [
            { 'data': 'data_no'},
            { 'data': 'data_name' },
            { 'data': 'data_product' },
            { 'data': null, 
                'render': function (resp) {
                return `<a class="btn btn-xs btn-info text-white" data-toggle="tooltip" data-placement="top" title="Detail satuan"><i class="fas fa-search"></i></a>
                <a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah satuan" onclick="editData('unit', '`+resp.data_id+`', '`+unit_url+`', '')"><i class="fas fa-edit"></i></a>
                <a class="btn btn-xs btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Hapus satuan" onclick="confirmDelete('unit', '`+resp.data_id+`', '`+unit_url+`', '')"><i class="fas fa-trash"></i></a>`
              }
            },
        ]
    })

    /** Submit form-data */
    $("#form-cat").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : cat_url,
            method  : $(this).attr("method"),
            data    : $("#form-cat").serialize(),
            datatype    : 'json',
            statusCode: {
                201: function (response) {                    
                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: response.icon,
                        title: response.message
                    }).then((r) => {
                        $("#form-cat").trigger('reset')
                        $("#input-cat-name").removeClass('is-invalid')
                        $("#error-cat-name").css("display", "none")
                        $('#modal-category').modal("toggle")
                        catTable.ajax.reload()
                    })
                },
                400: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message
                        })
                    } else {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: response.statusText
                        })
                    }
                },
                404: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message
                        })
                    } else {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: response.statusText
                        })
                    }
                },
                422: function (response) {
                    resp_json = response.responseJSON
                    
                    if(resp_json.message){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: resp_json.icon,
                            title: resp_json.message.errorName
                        })
                        $("#input-cat-name").addClass('is-invalid')
                        $("#error-cat-name").css("display", "block")
                        $("#error-cat-name").html(resp_json.message.errorName)
                    }
                },
                500: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message
                        })
                    } else {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: response.statusText
                        })
                    }
                    $("#input-cat-name").addClass('is-invalid')
                    $("#error-cat-name").css("display", "none")
                }
            },
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            }            
        })
    })

    /** Submit form-data */
    $("#form-unit").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : unit_url,
            method  : $(this).attr("method"),
            data    : $("#form-unit").serialize(),
            datatype    : 'json',
            statusCode: {
                201: function (response) {                    
                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: response.icon,
                        title: response.message
                    }).then((r) => {
                        $("#form-unit").trigger('reset')
                        $("#input-unit-name").removeClass('is-invalid')
                        $("#error-unit-name").css("display", "none")
                        $('#modal-unit').modal("toggle")
                        unitTable.ajax.reload()
                    })
                },
                400: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message
                        })
                    } else {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: response.statusText
                        })
                    }
                },
                404: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message
                        })
                    } else {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: response.statusText
                        })
                    }
                },
                422: function (response) {
                    resp_json = response.responseJSON
                    
                    if(resp_json.message){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: resp_json.icon,
                            title: resp_json.message.errorName
                        })
                        $("#input-unit-name").addClass('is-invalid')
                        $("#error-unit-name").css("display", "block")
                        $("#error-unit-name").html(resp_json.message.errorName)
                    }
                },
                500: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message
                        })
                    } else {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: response.statusText
                        })
                    }
                    $("#input-unit-name").addClass('is-invalid')
                    $("#error-unit-name").css("display", "none")
                }
            },
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            }            
        })
    })
})

function editData(type, id){
    if(type == 'ctgr'){
        $.ajax({
            url     : cat_url,
            method  : 'GET',
            data    : {ctgrID : id},
            datatype    : 'json',
            statusCode: {
                200: function (response) {
                    resp_data = response.data[0]
                    
                    $("#modal-category").find("#form-title").html("Ubah Data")
                    $('#modal-category').modal("toggle")
                    $("#form-cat").attr("method", "PUT")
                    $("#form-cat").attr("action", cat_url)
            
                    $("#form-cat").find("#edit-cat-id").prop("required", true)
                    $("#form-cat").find("#edit-cat-id").prop("disabled", false)

                    $("#form-cat").find("#edit-cat-id").val(resp_data.data_id)
                    $("#form-cat").find("#input-cat-name").val(resp_data.data_name)
                    $("#input-cat-name").removeClass('is-invalid')
                    $("#error-cat-name").css("display", "none")
                },
                404: function (response) {
                    resp_json = response.responseJSON
                    console.log(resp_json)
                    
                    if(resp_json.message){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: resp_json.message
                        })
                    }
                },
            }
        })
    } else {
        $.ajax({
            url     : unit_url,
            method  : 'GET',
            data    : {unitID : id},
            datatype    : 'json',
            statusCode: {
                200: function (response) {
                    resp_data = response.data[0]
                    
                    $("#modal-unit").find("#form-title").html("Ubah Data")
                    $('#modal-unit').modal("toggle")
                    $("#form-unit").attr("method", "PUT")
                    $("#form-unit").attr("action", unit_url)
            
                    $("#form-unit").find("#edit-unit-id").prop("required", true)
                    $("#form-unit").find("#edit-unit-id").prop("disabled", false)

                    $("#form-unit").find("#edit-unit-id").val(resp_data.data_id)
                    $("#form-unit").find("#input-unit-name").val(resp_data.data_name)
                    $("#input-unit-name").removeClass('is-invalid')
                    $("#error-unit-name").css("display", "none")
                },
                404: function (response) {
                    resp_json = response.responseJSON
                    
                    if(resp_json.message){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: resp_json.message
                        })
                    }
                },
            }
        })
    }
}