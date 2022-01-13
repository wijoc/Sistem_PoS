$(document).ready(function(){ 
    /** Datatable Stock */
    var stockTable = $("#table-stock-product").DataTable({
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
            url   : stock_url,
            type  : 'GET',
            datatype : 'json',
            data : {
                'mutation' : false,
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
                { 'data' : 'ini_g_stock'},
                { 'data' : 'data_g_stock'},
                { 'data' : 'ini_ng_stock'},
                { 'data' : 'data_ng_stock'},
                { 'data' : 'ini_op_stock'},
                { 'data' : 'data_op_stock'},
            { 'data' : null,
                'render': function (resp){
                    return `<a class="btn btn-xs btn-warning text-white" data-toggle="tooltip" data-placement="top" title="Mutasi stok produk" onClick="stockMutation('`+ resp.data_id +`')"><i class="fas fa-people-carry"></i></a>`
                }
            }
        ]
    })

    /** Submit Stock Mutation */
    $("#form-add-stock-mutation").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : mutation_url,
            method  : 'POST',
            data    : $("#form-add-stock-mutation").serialize(),
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
                        stockTable.ajax.reload()

                        $("#form-add-stock-mutation").trigger('reset')
                        $("#input-prd-id").val(response.prd_id)
                        $(".form-control").removeClass('is-invalid')
                        $(".error-msg").css("display", "none")

                        /** Set new mutation table */
                        if(response.data.mutation != null){
                            var output = ''
                            response.data.mutation.forEach(index => {
                                output += `
                                    <tr>
                                        <td class="text-center"><small>`+ index.dsm_date +`</small></td>
                                        <td class="text-center"><small>`+ index.dsm_from +`</small></td>
                                        <td class="text-center"><small>`+ index.dsm_to +`</small></td>
                                        <td class="text-center"><small>`+ index.dsm_qty +`</small></td>
                                        <td class="text-center"><small>`+ index.dsm_ps +`</small></td>
                                    </tr>
                                `
                            })
                            $("#mutation-table tbody").html(output)
                        } else {
                            $("#mutation-table tbody").html(`
                                <tr class="text-center">
                                    <td colspan="5" class="text-white bg-secondary font-weight-bold"> Belum ada mutasi dilakukan </td>
                                </tr>
                            `)
                        }

                        /** Set new stock table */
                        $("#stock-table tbody").html(`
                            <tr>
                                <td>`+ response.data.stk.ini_g_stock +`</td>
                                <td>`+ response.data.stk.data_g_stock +`</td>
                                <td>`+ response.data.stk.ini_ng_stock +`</td>
                                <td>`+ response.data.stk.data_ng_stock +`</td>
                                <td>`+ response.data.stk.ini_op_stock +`</td>
                                <td>`+ response.data.stk.data_op_stock +`</td>
                            </tr>
                        `)
                    })
                },
                404: function (response) {
                    if(response.responseJSON){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.responseJSON.icon,
                            title: response.responseJSON.message.errorPrdID
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

                    /** Error : product ID */
                    if(resp_json.errorPrdID){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: response.icon,
                            title: response.message.errorPrdID
                        })
                    }

                    /** Error : mutation date */
                    if(resp_json.message.errorStockDate){
                        $("#input-stock-date").addClass('is-invalid')
                        $("#error-stock-date").css("display", "block")
                        $("#error-stock-date").html(resp_json.message.errorStockDate)
                    } else {
                        $("#input-stock-date").removeClass('is-invalid')
                        $("#error-stock-date").css("display", "none")
                    }

                    /** Error : stock from */
                    if(resp_json.message.errorStockA){
                        $("#input-stock-from").addClass('is-invalid')
                        $("#error-stock-from").css("display", "block")
                        $("#error-stock-from").html(resp_json.message.errorStockA)
                    } else {
                        $("#input-stock-from").removeClass('is-invalid')
                        $("#error-stock-from").css("display", "none")
                    }

                    /** Error : stock to */
                    if(resp_json.message.errorStockB){
                        $("#input-stock-to").addClass('is-invalid')
                        $("#error-stock-to").css("display", "block")
                        $("#error-stock-to").html(resp_json.message.errorStockB)
                    } else {
                        $("#input-stock-to").removeClass('is-invalid')
                        $("#error-stock-to").css("display", "none")
                    }
                    
                    /** Error : Mutation qty */
                    if(resp_json.message.errorStockQty){
                        $("#input-stock-qty").addClass('is-invalid')
                        $("#error-stock-qty").css("display", "block")
                        $("#error-stock-qty").html(resp_json.message.errorStockQty)
                    } else {
                        $("#input-stock-qty").removeClass('is-invalid')
                        $("#error-stock-qty").css("display", "none")
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
                }
            },
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            }            
        })
    })
})

function stockMutation (id){
    $.ajax({
        url     : stock_url + id,
        method  : 'GET',
        data    : {mutation : true},
        datatype    : 'json',
        beforeSend  : function(){
            // $("#form-prd").find("#input-prd-category").prop("selectedIndex", 0);
            // $("#form-prd").find("#input-prd-unit").prop("selectedIndex", 0);
        },
        statusCode  : {
            200: function (response) {
                $("#modal-stock-mutation").modal('toggle')

                $("#header-name").html(response.data.stk.data_name)
                $("#header-code").html(response.data.stk.data_code)

                $("#input-prd-id").val(id)
                $("#stock-table tbody").html(`
                    <tr>
                        <td>`+ response.data.stk.ini_g_stock +`</td>
                        <td>`+ response.data.stk.data_g_stock +`</td>
                        <td>`+ response.data.stk.ini_ng_stock +`</td>
                        <td>`+ response.data.stk.data_ng_stock +`</td>
                        <td>`+ response.data.stk.ini_op_stock +`</td>
                        <td>`+ response.data.stk.data_op_stock +`</td>
                    </tr>
                `)

                if(response.data.mutation != null){
                    var output = ''
                    response.data.mutation.forEach(index => {
                        output += `
                            <tr>
                                <td class="text-center"><small>`+ index.dsm_date +`</small></td>
                                <td class="text-center"><small>`+ index.dsm_from +`</small></td>
                                <td class="text-center"><small>`+ index.dsm_to +`</small></td>
                                <td class="text-center"><small>`+ index.dsm_qty +`</small></td>
                                <td class="text-center"><small>`+ index.dsm_ps +`</small></td>
                            </tr>
                        `
                    })
                    $("#mutation-table tbody").html(output)
                } else {
                    $("#mutation-table tbody").html(`
                        <tr class="text-center">
                            <td colspan="5" class="text-white bg-secondary font-weight-bold"> Belum ada mutasi dilakukan </td>
                        </tr>
                    `)
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