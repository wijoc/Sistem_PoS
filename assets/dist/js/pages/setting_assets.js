$(document).ready(function(){
    /** Datatables Rekening */
    accTable = $("#table-account").DataTable({
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order'      : [], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : setting_list_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }]
    })

    /** Submit rekening */
    $("#form-add-account").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).find(":submit").prop("disabled", true)
            },
            success : function(result){
                if(result.error){
                    /** Error kode bank */
                        if(result.errorBank){
                            $("#input-acc-bank").addClass('is-invalid')
                            $("#error-acc-bank").css("display", "block")
                            $("#error-acc-bank").html(result.errorBank)
                        } else {
                            $("#input-acc-bank").removeClass('is-invalid')
                            $("#error-acc-bank").css("display", "none")
                        }

                    /** Error Atas name */
                        if(result.errorName){
                            $("#input-acc-name").addClass('is-invalid')
                            $("#error-acc-name").css("display", "block")
                            $("#error-acc-name").html(result.errorName)
                        } else {
                            $("#input-acc-name").removeClass('is-invalid')
                            $("#error-acc-name").css("display", "none")
                        }
                    /** Error kode bank */
                        if(result.errorNumber){
                            $("#input-acc-number").addClass('is-invalid')
                            $("#error-acc-number").css("display", "block")
                            $("#error-acc-number").html(result.errorNumber)
                        } else {
                            $("#input-acc-number").removeClass('is-invalid')
                            $("#error-acc-number").css("display", "none")
                        }
                } else {
                    console.log(result)
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $("#form-add-account").trigger("reset")
                        $("#modal-add-account").modal("toggle")
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: result.statusIcon,
                        title: result.statusMsg
                    }).then((result) => {
                        accTable.ajax.reload()
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })
})