$(document).ready(function(){
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
                console.log(data)
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
                        if(data.status == 'successInsert'){
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

    /** Execute function getRowData page 0 */
    getRowData(0)

    $("#pagination").on("click", ".pagination li a", function(event){
        event.preventDefault();
        var page = $(this).data("ci-pagination-page")
        getRowData(page);
    });
})

/** Function : Get data supplier via ajax */
    function getRowData(page){
        $.ajax({
            url     : supp_url + page,
            type    : 'GET',
            data    : {supp_keyword : $("input[name='postSearch']").val(), supp_order : $("#suppOrder").val()},
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
        for(index in data.supp_data){
            output += `
                <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
                    <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">
                            `+ data.supp_data[index].data_name +`
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="lead font-weight-bold">`+ data.supp_data[index].data_contact +`</h6>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-md fa-phone"></i></span>&nbsp:&nbsp `+ data.supp_data[index].data_telp +`
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-md fa-envelope-open-text"></i></span>&nbsp:&nbsp `+ data.supp_data[index].data_email +`
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-md fa-building"></i></span>&nbsp:&nbsp `+ data.supp_data[index].data_address +`
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
                                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit-supplier" onclick="editContact('supp', '`+ data.supp_data[index].data_id +`', '`+ data.url_detail +`')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" onclick="confirmDelete('`+ data.delete_type +`', '`+ data.supp_data[index].data_id +`', '`+ data.delete_url +`')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } 
        
        $("#list-supp").html(output)
    }

/** Function : Set edit form */
    function editContact(contact_type, contact_id, detail_url){
        $.ajax({
            url     : detail_url,
            method  : "GET",
            data    : {id : contact_id},
            dataType : 'json',
            success : function(data){
                if(contact_type === 'supp'){
                    $('#form-edit-supplier').find('#editSuppID').val(contact_id)
                    $('#form-edit-supplier').find('#editSuppNama').val(data.edit_name)
                    $('#form-edit-supplier').find('#editSuppKontak').val(data.edit_contact)
                    $('#form-edit-supplier').find('#editSuppTelp').val(data.edit_telp)
                    $('#form-edit-supplier').find('#editSuppEmail').val(data.edit_email)
                    $('#form-edit-supplier').find('#editSuppAlamat').val(data.edit_address)
                } else if(contact_type === 'ctm'){
                    $('#formEditCustomer').find('#editCtmID').val(data.data_id)
                    $('#formEditCustomer').find('#editCtmNama').val(data.data_name)
                    $('#formEditCustomer').find('#editCtmTelp').val(data.data_phone)
                    $('#formEditCustomer').find('#editCtmEmail').val(data.data_email)
                    $('#formEditCustomer').find('#editCtmAddress').val(data.data_address)
                }
            }
        })
    }