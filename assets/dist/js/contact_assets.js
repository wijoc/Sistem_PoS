$(document).ready(function(){
  /** function : Supplier */
    /** Submit form-data */
    $("#form-supplier").on("submit", function(event){
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
                    /** Error input nama */
                        if(data.errorSuppNama){
                            $("#inputSuppNama").addClass('is-invalid')
                            $("#errorSuppNama").css("display", "block")
                            $("#errorSuppNama").html(data.errorSuppNama)
                        } else {
                            $("#inputSuppNama").removeClass('is-invalid')
                            $("#errorSuppNama").css("display", "none")
                        }

                    /** Error input kontak nama */
                        if(data.errorSuppKontak){
                            $("#inputSuppKontak").addClass('is-invalid')
                            $("#errorSuppKontak").css("display", "block")
                            $("#errorSuppKontak").html(data.errorSuppKontak)
                        } else {
                            $("#inputSuppKontak").removeClass('is-invalid')
                            $("#errorSuppKontak").css("display", "none")
                        }
                        
                    /** Error input Telp */
                        if(data.errorSuppTelp){
                            $("#inputSuppTelp").addClass('is-invalid')
                            $("#errorSuppTelp").css("display", "block")
                            $("#errorSuppTelp").html(data.errorSuppTelp)
                        } else {
                            $("#inputSuppTelp").removeClass('is-invalid')
                            $("#errorSuppTelp").css("display", "none")
                        }
                        
                    /** Error input Email */
                        if(data.errorSuppEmail){
                            $("#inputSuppEmail").addClass('is-invalid')
                            $("#errorSuppEmail").css("display", "block")
                            $("#errorSuppEmail").html(data.errorSuppEmail)
                        } else {
                            $("#inputSuppEmail").removeClass('is-invalid')
                            $("#errorSuppEmail").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(data.status == 'successInsert'){
                        $("#form-supplier").trigger("reset")
                        $("#modal-tambah-supplier").modal("toggle")
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        $("#alert-supplier").append('<div class="alert alert-success text-center" style="opacity: 0.8" role="alert">'+ data.statusMsg +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button></div>')
                        
                        /** Execute function getRowData page 0 */
                        getRowData(0)
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Submit edit form data */
    $("#form-edit-supplier").on("submit", function(event){
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
                    /** Error input id */
                        if(data.errorSuppID){
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: "error",
                                title: data.errorSuppID
                            })
                        }
                    /** Error input nama */
                        if(data.errorSuppNama){
                            $("#inputSuppNama").addClass('is-invalid')
                            $("#errorSuppNama").css("display", "block")
                            $("#errorSuppNama").html(data.errorSuppNama)
                        } else {
                            $("#inputSuppNama").removeClass('is-invalid')
                            $("#errorSuppNama").css("display", "none")
                        }

                    /** Error input kategori */
                        if(data.errorSuppKontak){
                            $("#inputSuppKontak").addClass('is-invalid')
                            $("#errorSuppKontak").css("display", "block")
                            $("#errorSuppKontak").html(data.errorSuppKontak)
                        } else {
                            $("#inputSuppKontak").removeClass('is-invalid')
                            $("#errorSuppKontak").css("display", "none")
                        }
                        
                    /** Error input Harga Beli */
                        if(data.errorSuppTelp){
                            $("#inputSuppTelp").addClass('is-invalid')
                            $("#errorSuppTelp").css("display", "block")
                            $("#errorSuppTelp").html(data.errorSuppTelp)
                        } else {
                            $("#inputSuppTelp").removeClass('is-invalid')
                            $("#errorSuppTelp").css("display", "none")
                        }
                        
                    /** Error input Harga Jual */
                        if(data.errorSuppEmail){
                            $("#inputSuppEmail").addClass('is-invalid')
                            $("#errorSuppEmail").css("display", "block")
                            $("#errorSuppEmail").html(data.errorSuppEmail)
                        } else {
                            $("#inputSuppEmail").removeClass('is-invalid')
                            $("#errorSuppEmail").css("display", "none")
                        }
                    
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 1500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        if(data.status == 'successUpdate'){
                            $("#modal-edit-supplier").modal("toggle")
                        }

                        /** Execute function getRowData page 0 */
                        getRowData(0)
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

  /** Function : Customer */
    /** Submit form-data */
    $("#form-add-customer").on("submit", function(event){
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
                    /** Error input nama */
                        if(data.errorCtmNama){
                            $("#inputCtmNama").addClass('is-invalid')
                            $("#errorCtmNama").css("display", "block")
                            $("#errorCtmNama").html(data.errorCtmNama)
                        } else {
                            $("#inputCtmNama").removeClass('is-invalid')
                            $("#errorCtmNama").css("display", "none")
                        }
                        
                    /** Error input Telp */
                        if(data.errorCtmTelp){
                            $("#inputCtmTelp").addClass('is-invalid')
                            $("#errorCtmTelp").css("display", "block")
                            $("#errorCtmTelp").html(data.errorCtmTelp)
                        } else {
                            $("#inputCtmTelp").removeClass('is-invalid')
                            $("#errorCtmTelp").css("display", "none")
                        }
                        
                    /** Error input Harga Jual */
                        if(data.errorCtmEmail){
                            $("#inputCtmEmail").addClass('is-invalid')
                            $("#errorCtmEmail").css("display", "block")
                            $("#errorCtmEmail").html(data.errorCtmEmail)
                        } else {
                            $("#inputCtmEmail").removeClass('is-invalid')
                            $("#errorCtmEmail").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(data.status == 'successInsert'){
                        $("#form-add-customer").trigger("reset")
                        $("#modal-tambah-pelanggan").modal("toggle")
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 2500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        /** Execute function getRowData page 0 */
                        getRowData(0)
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Submit edit form data */
    $("#form-edit-customer").on("submit", function(event){
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
                    /** Error input id */
                        if(data.errorCtmID){
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: "error",
                                title: data.errorCtmID
                            })
                        }
                        /** Error input nama */
                            if(data.errorCtmNama){
                                $("#form-edit-customer").find("#inputCtmNama").addClass('is-invalid')
                                $("#form-edit-customer").find("#errorCtmNama").css("display", "block")
                                $("#form-edit-customer").find("#errorCtmNama").html(data.errorCtmNama)
                            } else {
                                $("#form-edit-customer").find("#inputCtmNama").removeClass('is-invalid')
                                $("#form-edit-customer").find("#errorCtmNama").css("display", "none")
                            }
                            
                        /** Error input Telp */
                            if(data.errorCtmTelp){
                                $("#form-edit-customer").find("#inputCtmTelp").addClass('is-invalid')
                                $("#form-edit-customer").find("#errorCtmTelp").css("display", "block")
                                $("#form-edit-customer").find("#errorCtmTelp").html(data.errorCtmTelp)
                            } else {
                                $("#form-edit-customer").find("#inputCtmTelp").removeClass('is-invalid')
                                $("#form-edit-customer").find("#errorCtmTelp").css("display", "none")
                            }
                            
                        /** Error input Harga Jual */
                            if(data.errorCtmEmail){
                                $("#form-edit-customer").find("#inputCtmEmail").addClass('is-invalid')
                                $("#form-edit-customer").find("#errorCtmEmail").css("display", "block")
                                $("#form-edit-customer").find("#errorCtmEmail").html(data.errorCtmEmail)
                            } else {
                                $("#form-edit-customer").find("#inputCtmEmail").removeClass('is-invalid')
                                $("#form-edit-customer").find("#errorCtmEmail").css("display", "none")
                            }                    
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")

                    Swal.fire({
                        position: "center",
                        showConfirmButton: true,
                        timer: 1500,
                        icon: data.statusIcon,
                        title: data.statusMsg
                    }).then((result) => {
                        if(data.status == 'successInsert'){
                            $("#modal-edit-customer").modal("toggle")
                        }

                        /** Execute function getRowData page 0 */
                        getRowData(0)
                    })
                }
            },
            error   :  function(jqxhr, status, exception){
                alert("Exception", exception)
            }
        })
    })

    /** Execute function getRowData page 0 */
    getRowData(0)

    /** Pagination */
    $("#pagination").on("click", ".pagination li a", function(event){
        event.preventDefault();
        var page = $(this).data("ci-pagination-page")
        getRowData(page);
    });
})

/** Function : Get data supplier via ajax */
    function getRowData(page){
        $.ajax({
            url     : contact_url + page,
            type    : 'GET',
            data    : {filter_keyword : $("input[name='postSearch']").val(), filter_order : $("#contactOrder").val()},
            datatype    : 'json',
            success     : function(data){
                $("#pagination").html(data.pagination)
                createList(data)
            }
        })
    }

/** Function : Set list card */
    function createList(data){
        var output = ''
        for(index in data.contact_data){
            output += `
                <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
                    <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">
                            `+ data.contact_data[index].data_name +`
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="lead font-weight-bold">`+ data.contact_data[index].data_contact +`</h6>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-md fa-phone"></i></span>&nbsp:&nbsp `+ data.contact_data[index].data_telp +`
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-md fa-envelope-open-text"></i></span>&nbsp:&nbsp `+ data.contact_data[index].data_email +`
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-md fa-building"></i></span>&nbsp:&nbsp `+ data.contact_data[index].data_address +`
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="" class="btn btn-sm btn-info">
                                    <i class="fas fa-cash-register"></i>
                                </a>
                                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#`+ data.modal +`" onclick="editContact('`+data.type+`', '`+ data.contact_data[index].data_id +`', '`+ data.url_detail +`')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" onclick="confirmDelete('`+ data.delete_type +`', '`+ data.contact_data[index].data_id +`', '`+ data.delete_url +`')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } 
        
        if(data.type == 'supp' ){
            $("#list-supp").html(output)
        } else if (data.type == 'ctm'){
            $("#list-ctm").html(output)
        }
    }

/** Function : Set edit form */
    function editContact(contact_type, contact_id, detail_url){
        $.ajax({
            url     : detail_url,
            method  : "GET",
            data    : {id : contact_id},
            dataType : 'json',
            success : function(result){
                if(contact_type === 'supp'){
                    $('#form-edit-supplier').find('#editSuppID').val(contact_id)
                    $('#form-edit-supplier').find('#editSuppNama').val(result.edit_name)
                    $('#form-edit-supplier').find('#editSuppKontak').val(result.edit_contact)
                    $('#form-edit-supplier').find('#editSuppTelp').val(result.edit_telp)
                    $('#form-edit-supplier').find('#editSuppEmail').val(result.edit_email)
                    $('#form-edit-supplier').find('#editSuppAlamat').val(result.edit_address)
                } else if(contact_type === 'ctm'){
                    $('#form-edit-customer').find('#editCtmID').val(contact_id)
                    $('#form-edit-customer').find('#editCtmNama').val(result.data_name)
                    $('#form-edit-customer').find('#editCtmTelp').val(result.data_phone)
                    $('#form-edit-customer').find('#editCtmEmail').val(result.data_email)
                    $('#form-edit-customer').find('#editCtmAddress').val(result.data_address)
                }
            }
        })
    }