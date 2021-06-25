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
                            $("#input-supp-name").addClass('is-invalid')
                            $("#error-supp-name").css("display", "block")
                            $("#error-supp-name").html(data.errorSuppNama)
                        } else {
                            $("#input-supp-name").removeClass('is-invalid')
                            $("#error-supp-name").css("display", "none")
                        }

                    /** Error input kontak nama */
                        if(data.errorSuppKontak){
                            $("#input-supp-contact").addClass('is-invalid')
                            $("#error-supp-contact").css("display", "block")
                            $("#error-supp-contact").html(data.errorSuppKontak)
                        } else {
                            $("#input-supp-contact").removeClass('is-invalid')
                            $("#error-supp-contact").css("display", "none")
                        }
                        
                    /** Error input Telp */
                        if(data.errorSuppTelp){
                            $("#input-supp-phone").addClass('is-invalid')
                            $("#error-supp-phone").css("display", "block")
                            $("#error-supp-phone").html(data.errorSuppTelp)
                        } else {
                            $("#input-supp-phone").removeClass('is-invalid')
                            $("#error-supp-phone").css("display", "none")
                        }
                        
                    /** Error input Email */
                        if(data.errorSuppEmail){
                            $("#input-supp-email").addClass('is-invalid')
                            $("#error-supp-email").css("display", "block")
                            $("#error-supp-email").html(data.errorSuppEmail)
                        } else {
                            $("#input-supp-email").removeClass('is-invalid')
                            $("#error-supp-email").css("display", "none")
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
                        if(data.errorCtmName){
                            $("#input-ctm-name").addClass('is-invalid')
                            $("#error-ctm-name").css("display", "block")
                            $("#error-ctm-name").html(data.errorCtmName)
                        } else {
                            $("#input-ctm-name").removeClass('is-invalid')
                            $("#error-ctm-name").css("display", "none")
                        }
                        
                    /** Error input Telp */
                        if(data.errorCtmTelp){
                            $("#input-ctm-phone").addClass('is-invalid')
                            $("#error-ctm-phone").css("display", "block")
                            $("#error-ctm-phone").html(data.errorCtmTelp)
                        } else {
                            $("#input-ctm-phone").removeClass('is-invalid')
                            $("#error-ctm-phone").css("display", "none")
                        }
                        
                    /** Error input Harga Jual */
                        if(data.errorCtmEmail){
                            $("#input-ctm-email").addClass('is-invalid')
                            $("#error-ctm-email").css("display", "block")
                            $("#error-ctm-email").html(data.errorCtmEmail)
                        } else {
                            $("#input-ctm-email").removeClass('is-invalid')
                            $("#error-ctm-email").css("display", "none")
                        }
                } else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(data.status == 'successInsert'){
                        $("#form-add-customer").trigger("reset")
                        $("#modal-add-customer").modal("toggle")
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
                            if(data.errorCtmName){
                                $("#form-edit-customer").find("#edit-ctm-name").addClass('is-invalid')
                                $("#form-edit-customer").find("#error-ctm-name").css("display", "block")
                                $("#form-edit-customer").find("#error-ctm-name").html(data.errorCtmName)
                            } else {
                                $("#form-edit-customer").find("#edit-ctm-name").removeClass('is-invalid')
                                $("#form-edit-customer").find("#error-ctm-name").css("display", "none")
                            }
                            
                        /** Error input Telp */
                            if(data.errorCtmTelp){
                                $("#form-edit-customer").find("#edit-ctm-phone").addClass('is-invalid')
                                $("#form-edit-customer").find("#error-ctm-phone").css("display", "block")
                                $("#form-edit-customer").find("#error-ctm-phone").html(data.errorCtmTelp)
                            } else {
                                $("#form-edit-customer").find("#edit-ctm-phone").removeClass('is-invalid')
                                $("#form-edit-customer").find("#error-ctm-phone").css("display", "none")
                            }
                            
                        /** Error input Harga Jual */
                            if(data.errorCtmEmail){
                                $("#form-edit-customer").find("#edit-ctm-email").addClass('is-invalid')
                                $("#form-edit-customer").find("#error-ctm-email").css("display", "block")
                                $("#form-edit-customer").find("#error-ctm-email").html(data.errorCtmEmail)
                            } else {
                                $("#form-edit-customer").find("#edit-ctm-email").removeClass('is-invalid')
                                $("#form-edit-customer").find("#error-ctm-email").css("display", "none")
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
            data    : {filter_keyword : $("input[name='postSearch']").val(), filter_order : $("#contact-order").val()},
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
        if(data.count_data > 0){
            for(index in data.contact_data){
                if(data.user_allowed == 'TRUE'){
                    output += `
                        <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">
                                    `+ data.contact_data[index].data_contact +`
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="lead font-weight-bold">`+ data.contact_data[index].data_name +`</h6>
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
                                        <a href="" class="btn btn-sm btn-info" data-placement="top" title="Daftar Transaksi">
                                            <i class="fas fa-cash-register"></i>
                                        </a>
                                        <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#`+ data.modal +`" data-placement="top" title="Edit kontak" onclick="editContact('`+data.type+`', '`+ data.contact_data[index].data_id +`', '`+ data.url_detail +`')">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" data-placement="top" title="Hapus kontak" onclick="confirmDelete('`+ data.delete_type +`', '`+ data.contact_data[index].data_id +`', '`+ data.delete_url +`')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    output += `
                        <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">
                                    `+ data.contact_data[index].data_contact +`
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="lead font-weight-bold">`+ data.contact_data[index].data_name +`</h6>
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
                            </div>
                        </div>
                    `;
                }
            } 
        } else {
            output += '<div class="col-12 alert alert-danger text-center font-weight-bold" style="opacity: 0.7" role="alert">Data belum tersedia !</div>'
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
                    $('#form-edit-customer').find('#edit-ctm-ID').val(contact_id)
                    $('#form-edit-customer').find('#edit-ctm-name').val(result.data_name)
                    $('#form-edit-customer').find('#edit-ctm-phone').val(result.data_phone)
                    $('#form-edit-customer').find('#edit-ctm-email').val(result.data_email)
                    $('#form-edit-customer').find('#edit-ctm-address').val(result.data_address)
                }
            }
        })
    }