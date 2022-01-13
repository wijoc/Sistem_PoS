$(document).ready(function(){ 
    $("#btn-add-prd").on("click", function(event){
        $('#form-prd').find("#set-method").val('_POST')
                
        $("#modal-product").find("#form-title").html("Tambah")
        $('#modal-product').modal("toggle")
        $("#modal-product #form-prd").trigger('reset')
        $('.dropify-clear').click();

        $("#form-prd").find("#input-prd-category").prop("selectedIndex", 0);
        $("#form-prd").find("#input-prd-unit").prop("selectedIndex", 0);
        $("#form-prd").find("#edit-prd-id").prop("required", false)
        $("#form-prd").find("#edit-prd-id").prop("disabled", true)

        $("#form-prd").find("#warning-code").show()
        $("#div-prd-desc").removeClass("col-lg-12")
        $("#div-prd-desc").addClass("col-lg-6")

        $("#form-prd").find("#div-old-img").css("display", 'none')
        $("#form-prd").find("#old-prd-img").attr("src", '')
        $("#form-prd").find("#old-prd-img").attr("alt", '')

        $("#stock-title").show()
        $("#stock-form").show()
        $(".stock-form-input").prop('disabled', false)
        $(".stock-form-input").prop('required', true)

        $(".form-control").removeClass('is-invalid')
        $(".error-msg").css("display", "none")
    })

    /** Datatables serverside */
    var productTable = $("#table-product").DataTable({
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
            url   : prds_url,
            type  : 'GET',
            datatype : 'json',
            data : {
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
            { 'data' : 'data_code'},
            { 'data' : 'data_name'},
            { 'data' : 'data_category'},
            { 'data' : 'data_purchase_price'},
            { 'data' : 'data_selling_price'},
            { 'data' : 'data_unit'},
            { 'data' : 'good_stock'},
            { 'data': null, 
                'render': function (resp) {
                return `<a class="btn btn-xs btn-info text-white" data-toggle="tooltip" data-placement="top" title="Detail produk" onclick="edtlProduct('`+ resp.data_id +`', 'detail')"><i class="fas fa-search"></i></a>
                <a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah produk" onclick="edtlProduct('`+ resp.data_id +`', 'edit')"><i class="fas fa-edit"></i></a>
                <a class="btn btn-xs btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Hapus produk" onclick="confirmDelete('soft-prd', '`+resp.data_id+`', '`+prds_url+`', '')"><i class="fas fa-trash"></i></a>`
              }
            },
        ]
    })

    /** Submit add product */
    $("#form-prd").on("submit", function(event){
        event.preventDefault()
        var file_data = $('#input-prd-img').prop('files')[0]
        var form_data = new FormData(this)
        form_data.append('file', file_data)
        $.ajax({
            url     : prds_url,
            method  : 'POST',
            data    : form_data,
            cache   : false,
            contentType : false,
            processData : false,
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            statusCode: {
                200: function (response) {
                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: response.icon,
                        title: response.message
                    }).then((r) => {
                        $(".error-msg").css("display", "none")
                        $(".is-invalid").removeClass("is-invalid")

                        $("#form-prd").trigger('reset')
                        $('#modal-product').modal("toggle")
                        productTable.ajax.reload()
                    })
                },
                201: function (response) {
                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: response.icon,
                        title: response.message
                    }).then((r) => {
                        $(".error-msg").css("display", "none")
                        $(".is-invalid").removeClass("is-invalid")

                        $("#form-prd").trigger('reset')
                        $('#modal-product').modal("toggle")
                        productTable.ajax.reload()
                    })
                },
                422: function (response) {
                    resp_json = response.responseJSON

                    /** Error input name */
                    if(resp_json.message.errorName){
                        $("#modal-product").find("#input-prd-name").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-name").css("display", "block")
                        $("#modal-product").find("#error-prd-name").html(resp_json.message.errorName)
                    } else {
                        $("#modal-product").find("#input-prd-name").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-name").css("display", "none")
                    }

                    /** Error input code */
                    if(resp_json.message.errorCode){
                        $("#modal-product").find("#input-prd-code").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-code").css("display", "block")
                        $("#modal-product").find("#error-prd-code").html(resp_json.message.errorCode)
                    } else {
                        $("#modal-product").find("#input-prd-code").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-code").css("display", "none")
                    }

                    /** Error input category */
                    if(resp_json.message.errorCategory){
                        $("#modal-product").find("#input-prd-category").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-category").css("display", "block")
                        $("#modal-product").find("#error-prd-category").html(resp_json.message.errorCategory)
                    } else {
                        $("#modal-product").find("#input-prd-category").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-category").css("display", "none")
                    }

                    /** Error input purchase price */
                    if(resp_json.message.errorPPrice){
                        $("#modal-product").find("#input-prd-p-price").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-p-price").css("display", "block")
                        $("#modal-product").find("#error-prd-p-price").html(resp_json.message.errorPPrice)
                    } else {
                        $("#modal-product").find("#input-prd-p-price").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-p-price").css("display", "none")
                    }

                    /** Error input sales price */
                    if(resp_json.message.errorSPrice){
                        $("#modal-product").find("#input-prd-s-price").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-s-price").css("display", "block")
                        $("#modal-product").find("#error-prd-s-price").html(resp_json.message.errorSPrice)
                    } else {
                        $("#modal-product").find("#input-prd-s-price").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-s-price").css("display", "none")
                    }

                    /** Error input Unit */
                    if(resp_json.message.errorUnit){
                        $("#modal-product").find("#input-prd-unit").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-unit").css("display", "block")
                        $("#modal-product").find("#error-prd-unit").html(resp_json.message.errorUnit)
                    } else {
                        $("#modal-product").find("#input-prd-unit").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-unit").css("display", "none")
                    }

                    /** Error input content */
                    if(resp_json.message.errorContains){
                        $("#modal-product").find("#input-prd-contains").addClass('is-invalid')
                        $("#modal-product").find("#error-prd-contains").css("display", "block")
                        $("#modal-product").find("#error-prd-contains").html(resp_json.message.errorContains)
                    } else {
                        $("#modal-product").find("#input-prd-contains").removeClass('is-invalid')
                        $("#modal-product").find("#error-prd-contains").css("display", "none")
                    }

                    /** Error input image */
                    if(resp_json.message.errorImg){
                        $("#modal-product").find("#error-prd-img").css("display", "block")
                        $("#modal-product").find("#error-prd-img").html(resp_json.message.errorImg)
                    } else {
                        $("#modal-product").find("#error-prd-img").css("display", "none")
                    }

                    /** Error input stock g */
                    if(resp_json.message.errorStockG){
                        $("#modal-product").find("#input-stock-g").addClass('is-invalid')
                        $("#modal-product").find("#error-stock-g").css("display", "block")
                        $("#modal-product").find("#error-stock-g").html(resp_json.message.errorStockG)
                    } else {
                        $("#modal-product").find("#input-stock-g").removeClass('is-invalid')
                        $("#modal-product").find("#error-stock-g").css("display", "none")
                    }

                    /** Error input stock ng */
                    if(resp_json.message.errorStockNG){
                        $("#modal-product").find("#input-stock-ng").addClass('is-invalid')
                        $("#modal-product").find("#error-stock-ng").css("display", "block")
                        $("#modal-product").find("#error-stock-ng").html(resp_json.message.errorStockNG)
                    } else {
                        $("#modal-product").find("#input-stock-ng").removeClass('is-invalid')
                        $("#modal-product").find("#error-stock-ng").css("display", "none")
                    }

                    /** Error input stock opname */
                    if(resp_json.message.errorStockOP){
                        $("#modal-product").find("#input-stock-op").addClass('is-invalid')
                        $("#modal-product").find("#error-stock-op").css("display", "block")
                        $("#modal-product").find("#error-stock-op").html(resp_json.message.errorStockOP)
                    } else {
                        $("#modal-product").find("#input-stock-op").removeClass('is-invalid')
                        $("#modal-product").find("#error-stock-op").css("display", "none")
                    }
                },
                500: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
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
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                }
            }
        })
    })
})

function edtlProduct(id, type){
    $.ajax({
        url     : prds_url + id,
        method  : 'GET',
        data    : {necessity : type, mutation : (type == 'detail' ? true : false)},
        datatype    : 'json',
        beforeSend  : function(){
            $('.dropify-clear').click();
            $("#form-prd").find("#input-prd-category").prop("selectedIndex", 0);
            $("#form-prd").find("#input-prd-unit").prop("selectedIndex", 0);
        },
        statusCode  : {
            200: function (response) {
                if(type == 'edit'){
                    $("#modal-product").find("#form-title").html("Ubah Data")
                    $('#modal-product').modal("toggle")
                    $("#stock-title").hide()
                    $("#stock-form").hide()
                    $(".stock-form-input").prop('disabled', true)
                    $(".stock-form-input").prop('required', false)
            
                    $('#form-prd').find("#set-method").val('_PUT')
                    $("#form-prd").find("#edit-prd-id").prop("required", true)
                    $("#form-prd").find("#edit-prd-id").prop("disabled", false)
    
                    $("#edit-prd-id").val(response.data.data_id)
                    $("#input-prd-name").val(response.data.data_name)
    
                    $("#input-prd-code").val(response.data.data_code)
                    $("#warning-code").hide()
                    
                    $('#input-prd-category option[value="' + response.data.data_category + '"]').attr('selected', 'selected')
                    $('#input-prd-unit option[value="' + response.data.data_unit + '"]').attr('selected', 'selected')
                    $("#input-prd-p-price").val(response.data.data_p_price)
                    $("#input-prd-s-price").val(response.data.data_s_price)
                    $("#input-prd-contains").val(response.data.data_contains)
    
                    $("#div-prd-desc").removeClass("col-lg-6")
                    $("#div-prd-desc").addClass("col-lg-12")
                    $("#input-prd-desc").val(response.data.data_desc)
    
                    if(response.data.data_image != ""){
                        $("#div-old-img").css("display", "block")
                        $("#old-prd-img").attr("src", response.data.data_image)
                        $("#old-prd-img").attr("alt", response.data.data_name)
                    }
    
                    $(".form-control").removeClass('is-invalid')
                    $(".error-msg").css("display", "none")
                } else if (type == 'detail'){
                    $('#modal-detail-product').modal("toggle")

                    $("#det-prd-name").html(response.data.data_name)
                    $("#det-prd-category").html(response.data.data_category)
                    $("#det-prd-upc").html(response.data.data_contains + ' pcs / ' + response.data.data_unit)
                    $("#det-prd-p-price").html(response.data.data_p_price)
                    $("#det-prd-s-price").html(response.data.data_s_price)
                    $("#det-prd-desc").html(response.data.data_desc)
    
                    if(response.data.data_image != ""){
                        $("#det-prd-img").attr("src", response.data.data_image)
                        $("#det-prd-img").attr("alt", response.data.data_name)
                    }

                    $("#det-stock-table tbody").html(`
                        <tr>
                            <td>`+ response.data.ini_g_stock +`</td>
                            <td>`+ response.data.data_g_stock +`</td>
                            <td>`+ response.data.ini_ng_stock +`</td>
                            <td>`+ response.data.data_ng_stock +`</td>
                            <td>`+ response.data.ini_op_stock +`</td>
                            <td>`+ response.data.data_op_stock +`</td>
                        </tr>
                    `)

                    var mutation_html = ''
                    for(index in response.data.mutation){
                        mutation_html += `
                        <tr>
                            <td><small>`+ response.data.mutation[index].dsm_date +`</small></td>
                            <td><small>`+ response.data.mutation[index].dsm_from +`</small></td>
                            <td><small>`+ response.data.mutation[index].dsm_to +`</small></td>
                            <td><small>`+ response.data.mutation[index].dsm_qty +`</small></td>
                            <td><small>`+ response.data.mutation[index].dsm_ps +`</small></td>
                        </tr>
                    ` 
                    }
                    $("#det-mutation-table tbody").html(mutation_html)
                }
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