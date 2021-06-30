$(document).ready(function () {
    /** Datatables serverside */
    usersTable = $("#table-users").DataTable({
        'responsive' : true,
        'autoWidth'  : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order'      : [], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : users_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [-1],
            'orderable' : false
        }]
    })

    /** Submit form add user */
    $("#form-add-user").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function (){
                $(this).find(":submit").prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                    if(result.errorUName){
                        $("#input-user-name").addClass('is-invalid')
                        $("#error-user-name").css("display", "block")
                        $("#error-user-name").html(result.errorUName)
                    } else {
                        $("#input-user-name").removeClass('is-invalid')
                        $("#error-user-name").css("display", "none")
                    }

                  /** Error Username */
                    if(result.errorUUsername){
                        $("#input-user-username").addClass('is-invalid')
                        $("#error-user-username").css("display", "block")
                        $("#error-user-username").html(result.errorUUsername)
                    } else {
                        $("#input-user-username").removeClass('is-invalid')
                        $("#error-user-username").css("display", "none")
                    }

                  /** Error Password */
                    if(result.errorUPassword){
                        $("#input-user-password").addClass('is-invalid')
                        $("#error-user-password").css("display", "block")
                        $("#error-user-password").html(result.errorUPassword)
                    } else {
                        $("#input-user-password").removeClass('is-invalid')
                        $("#error-user-password").css("display", "none")
                    }

                  /** Error Re-password */
                    if(result.errorURePassword){
                        $("#input-user-repassword").addClass('is-invalid')
                        $("#error-user-repassword").css("display", "block")
                        $("#error-user-repassword").html(result.errorURePassword)
                    } else {
                        $("#input-user-repassword").removeClass('is-invalid')
                        $("#error-user-repassword").css("display", "none")
                    }

                  /** Error Level */
                    if(result.errorULevel){
                        $("#input-user-level").addClass('is-invalid')
                        $("#error-user-level").css("display", "block")
                        $("#error-user-level").html(result.errorULevel)
                    } else {
                        $("#input-user-level").removeClass('is-invalid')
                        $("#error-user-level").css("display", "none")
                    }
                    
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $("#form-add-user").trigger("reset")
                        $("#modal-add-user").modal("toggle")
                        $("#table-users").DataTable().ajax.reload()
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: result.statusIcon,
                        title: result.statusMsg
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Submit form edit user */
    $("#form-edit-user").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function (){
                $(this).find(":submit").prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                  /** Error UID */
                    if(result.errorUID){
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 2500,
                            icon: 'error',
                            title: result.errorUID
                        })
                    }

                  /** Error User Name */
                    if(result.errorUName){
                        $("#form-edit-user").find("#input-user-name").addClass('is-invalid')
                        $("#form-edit-user").find("#error-user-name").css("display", "block")
                        $("#form-edit-user").find("#error-user-name").html(result.errorUName)
                    } else {
                        $("#form-edit-user").find("#input-user-name").removeClass('is-invalid')
                        $("#form-edit-user").find("#error-user-name").css("display", "none")
                    }

                  /** Error Username */
                    if(result.errorUUsername){
                        $("#form-edit-user").find("#input-user-username").addClass('is-invalid')
                        $("#form-edit-user").find("#error-user-username").css("display", "block")
                        $("#form-edit-user").find("#error-user-username").html(result.errorUUsername)
                    } else {
                        $("#form-edit-user").find("#input-user-username").removeClass('is-invalid')
                        $("#form-edit-user").find("#error-user-username").css("display", "none")
                    }

                  /** Error Level */
                    if(result.errorULevel){
                        $("#form-edit-user").find("#input-user-level").addClass('is-invalid')
                        $("#form-edit-user").find("#error-user-level").css("display", "block")
                        $("#form-edit-user").find("#error-user-level").html(result.errorULevel)
                    } else {
                        $("#form-edit-user").find("#input-user-level").removeClass('is-invalid')
                        $("#form-edit-user").find("#error-user-level").css("display", "none")
                    }
                    
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successUpdate'){
                        $("#form-edit-user").trigger("reset")
                        $("#modal-edit-user").modal("toggle")
                        $("#table-users").DataTable().ajax.reload()
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: result.statusIcon,
                        title: result.statusMsg
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Submit form edit user */
    $("#form-change-password").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $(this).serialize(),
            datatype    : 'json',
            beforeSend  : function (){
                $(this).find(":submit").prop("disabled", true)
            },
            success     : function(result){
                if(result.error){
                    /** Error UID */
                        if(result.errorUID){
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: 'error',
                                title: result.errorUID
                            })
                        }

                    /** Error Password */
                        if(result.errorUPassword){
                            $("#form-change-password").find("#change-user-password").addClass('is-invalid')
                            $("#form-change-password").find("#error-user-password").css("display", "block")
                            $("#form-change-password").find("#error-user-password").html(result.errorUPassword)
                        } else {
                            $("#form-change-password").find("#change-user-password").removeClass('is-invalid')
                            $("#form-change-password").find("#error-user-password").css("display", "none")
                        }

                    /** Error Re-Password */
                        if(result.errorURePassword){
                            $("#form-change-password").find("#change-user-repassword").addClass('is-invalid')
                            $("#form-change-password").find("#error-user-repassword").css("display", "block")
                            $("#form-change-password").find("#error-user-repassword").html(result.errorURePassword)
                        } else {
                            $("#form-change-password").find("#change-user-repassword").removeClass('is-invalid')
                            $("#form-change-password").find("#error-user-repassword").css("display", "none")
                        }     
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successUpdate'){
                        $("#form-change-password").trigger("reset")
                        $("#modal-change-password").modal("toggle")
                        $("#table-users").DataTable().ajax.reload()
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: result.statusIcon,
                        title: result.statusMsg
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })
})

/** Function edit User */
function editUser(u_id, u_url, type){
    $.ajax({
        url     : u_url,
        method  : 'GET',
        data    : { uid : u_id },
        datatype    : 'json',
        success     : function(result){
            if(type == 'edit'){
                $("#modal-edit-user").modal("toggle")
                $("#edit-user-id").val(result.set_id)
                $("#edit-user-name").val(result.set_name)
                $("#edit-user-username").val(result.set_username)
                if(result.set_level == 'All'){
                    $("#div-edit-level").hide()
                    $("#edit-user-level").attr('required', false)
                    $("#edit-user-level").attr('disabled', true)
                } else {
                    $("#div-edit-level").show()
                    $("#edit-user-level").attr('required', true)
                    $("#edit-user-level").attr('disabled', false)
                    $("#edit-user-level").find('option[value="'+result.set_level+'"]').attr("selected", "selected")
                }
            } else if (type == 'change-password'){
                $("#modal-change-password").modal("toggle")
                $("#modal-change-password").find("#change-user-id").val(result.set_id)
            }
        }
    })
}