$(document).ready(function () {
    /** Datatables serverside */
    transTable = $("#table-account").DataTable({
        'responsive' : true,
        'autoWidth'  : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order'      : [], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : account_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [-1],
            'orderable' : false
        }]
    })

    /** Submit add account */
    $("#form-add-account").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-add-account").serialize(),
            datatype   : 'json',
            beforeSend : function(){
                $(this).prop("disabled", true)
            },
            success : function(result){
                if(result.error){
                    /** Error input Name */
                        if(result.errorName){
                            $("#input-acc-name").addClass('is-invalid')
                            $("#error-acc-name").css("display", "block")
                            $("#error-acc-name").html(result.errorName)
                        } else {
                            $("#input-acc-name").removeClass('is-invalid')
                            $("#error-acc-name").css("display", "none")
                        }

                    /** Error input number */
                        if(result.errorNumber){
                            $("#input-acc-number").addClass('is-invalid')
                            $("#error-acc-number").css("display", "block")
                            $("#error-acc-number").html(result.errorNumber)
                        } else {
                            $("#input-acc-number").removeClass('is-invalid')
                            $("#error-acc-number").css("display", "none")
                        }

                    /** Error input number */
                        if(result.errorBank){
                            $("#input-acc-bank").addClass('is-invalid')
                            $("#error-acc-bank").css("display", "block")
                            $("#error-acc-bank").html(result.errorBank)
                        } else {
                            $("#input-acc-bank").removeClass('is-invalid')
                            $("#error-acc-bank").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-add-account')[0].reset()
                        $("#modal-add-account").modal("toggle")
                    }

                    $('#table-account').DataTable().ajax.reload();

                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    })
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })

    /** Submit edit account */
    $("#form-edit-account").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-edit-account").serialize(),
            datatype   : 'json',
            beforeSend : function(){
                $(this).prop("disabled", true)
            },
            success : function(result){
                if(result.error){
                    /** Error input Name */
                        if(result.errorName){
                            $("#edit-acc-name").addClass('is-invalid')
                            $("#error-acc-name").css("display", "block")
                            $("#error-acc-name").html(result.errorName)
                        } else {
                            $("#edit-acc-name").removeClass('is-invalid')
                            $("#error-acc-name").css("display", "none")
                        }

                    /** Error input number */
                        if(result.errorNumber){
                            $("#edit-acc-number").addClass('is-invalid')
                            $("#error-acc-number").css("display", "block")
                            $("#error-acc-number").html(result.errorNumber)
                        } else {
                            $("#edit-acc-number").removeClass('is-invalid')
                            $("#error-acc-number").css("display", "none")
                        }

                    /** Error input number */
                        if(result.errorBank){
                            $("#edit-acc-bank").addClass('is-invalid')
                            $("#error-acc-bank").css("display", "block")
                            $("#error-acc-bank").html(result.errorBank)
                        } else {
                            $("#edit-acc-bank").removeClass('is-invalid')
                            $("#error-acc-bank").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successUpdate'){
                        $('#form-edit-account')[0].reset()
                        $("#modal-edit-account").modal("toggle")
                    }

                    $('#table-account').DataTable().ajax.reload();

                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    })
                }
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        })
    })
})

/** Function detail Account */
function detailAccount(acc_id, data_url){
    $.ajax({
        url     : data_url,
        data    : { accID : acc_id },
        method  : 'GET',
        datatype : 'json',
        success : function(result){
            if(result.type == 'edit'){
                $("#modal-edit-account").modal("toggle")

                $("#form-edit-account").find("#edit-acc-id").val(result.detail_id)
                $("#form-edit-account").find("#edit-acc-name").val(result.detail_name)
                $("#form-edit-account").find("#edit-acc-number").val(result.detail_number)
                $('#edit-acc-bank option[value="'+result.detail_bank+'"]').attr('selected', 'selected')
            }
        },
        error: function(jqxhr, status, exception) {
            alert('Exception:', exception);
        }
    })
}