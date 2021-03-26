$(document).ready(function () {
	/** Tambah keranjang */
	$("#form-purchase-cart").on("submit", function(event) {
		event.preventDefault()
		$.ajax({
			url: $(this).attr("action"),
			method: "POST",
			data: $(this).serialize(),
			datatype: "json",
			beforeSend: function () {
				$(this).find(":submit").prop("disabled", true)
			},
			success: function (data) {
				if (data.error) {
					const Toast = Swal.mixin({
						toast	: true,
						position: "top-end",
						showConfirmButton: false,
						timer	: 2000,
					})

					toastr.error( data.errorID +''+ data.errorQty +''+ data.errorHrg )
				} else {
					toastr.success( data.successMsg )
					$("#form-purchase-cart").trigger("reset")
					getCartList()
				}
			},
			error: function (jqxhr, status, exception) {
				alert("Exception", exception)
			},
		})
	})

	/** Status pembayaran */
	$("#input-p-status").change(function () {
		if ($(this).val() == "K") {
			$(".status-k").css("display", "block")
			$(".input-k").prop("disabled", false)
			$(".input-k").prop("required", true)
		} else {
			$(".status-k").css("display", "none")
			$(".input-k").prop("disabled", true)
			$(".input-k").prop("required", false)
		}
	})

	/** Metode Pembayaran */
	$("#input-p-method").change(function () {
		if ($(this).val() == "TF") {
			$(".method-tf").css("display", "block")
			$("#input-p-account").prop("disabled", false)
			$("#input-p-account").prop("required", true)
		} else {
			$(".method-tf").css("display", "none")
			$("#input-p-account").prop("disabled", true)
			$("#input-p-account").prop("required", false)
		}
	})

	/** Submit Purchases */
	$("#form-add-purchases").on("submit", function(event){
        event.preventDefault()
        var file_data = $('#input-p-file').prop('files')[0]; 
        var form_data = new FormData(this);
        form_data.append('file', file_data);
        $.ajax({
            url     : $("#form-add-purchases").attr("action"),
            method  : 'post',
            data    : form_data,
            cache   : false,
            contentType : false,
            processData : false,
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success : function(result){
				if(result.error){
                    /** Error input date */
                        if(result.errorPDate){
                            $("#input-p-date").addClass('is-invalid')
                            $("#error-p-date").css("display", "block")
                            $("#error-p-date").html(result.errorPDate)
                        } else {
                            $("#input-p-date").removeClass('is-invalid')
                            $("#error-p-date").css("display", "none")
                        }

                    /** Error input No Nota */
                        if(result.errorPNote){
                            $("#input-p-note").addClass('is-invalid')
                            $("#error-p-note").css("display", "block")
                            $("#error-p-note").html(result.errorPNote)
                        } else {
                            $("#input-p-note").removeClass('is-invalid')
                            $("#error-p-note").css("display", "none")
                        }

                    /** Error input File Nota */
                        if(result.errorFileNote){
                            $("#input-p-file").addClass('is-invalid')
                            $("#error-p-file").css("display", "block")
                            $("#error-p-file").html(result.errorFileNote)
                        } else {
                            $("#input-p-file").removeClass('is-invalid')
                            $("#error-p-file").css("display", "none")
                        }

                    /** Error input Tenor */
                        if(result.errorPTenor){
                            $("#input-p-tenor").addClass('is-invalid')
                            $("#error-p-tenor").css("display", "block")
                            $("#error-p-tenor").html(result.errorPTenor)
                        } else {
                            $("#input-p-tenor").removeClass('is-invalid')
                            $("#error-p-tenor").css("display", "none")
                        }

                    /** Error input Periode Tenor */
                        if(result.errorPTenorPeriode){
                            $("#input-p-tenor-periode").addClass('is-invalid')
                            $("#error-p-tenor-periode").css("display", "block")
                            $("#error-p-tenor-periode").html(result.errorPTenorPeriode)
                        } else {
                            $("#input-p-tenor-periode").removeClass('is-invalid')
                            $("#error-p-tenor-periode").css("display", "none")
                        }

                    /** Error input Ansuran */
                        if(result.errorPInstallment){
                            $("#input-p-installment").addClass('is-invalid')
                            $("#error-p-installment").css("display", "block")
                            $("#error-p-installment").html(result.errorPInstallment)
                        } else {
                            $("#input-p-installment").removeClass('is-invalid')
                            $("#error-p-installment").css("display", "none")
                        }

                    /** Error input Tempo */
                        if(result.errorPDue){
                            $("#input-p-due").addClass('is-invalid')
                            $("#error-p-due").css("display", "block")
                            $("#error-p-due").html(result.errorPDue)
                        } else {
                            $("#input-p-due").removeClass('is-invalid')
                            $("#error-p-due").css("display", "none")
                        }

                    /** Error input Payment method */
                        if(result.errorPMethod){
                            $("#input-p-method").addClass('is-invalid')
                            $("#error-p-method").css("display", "block")
                            $("#error-p-method").html(result.errorPMethod)
                        } else {
                            $("#input-p-method").removeClass('is-invalid')
                            $("#error-p-method").css("display", "none")
                        }

                    /** Error input Rekening */
                        if(result.errorPAccount){
                            $("#input-p-account").addClass('is-invalid')
                            $("#error-p-account").css("display", "block")
                            $("#error-p-account").html(result.errorPAccount)
                        } else {
                            $("#input-p-account").removeClass('is-invalid')
                            $("#error-p-account").css("display", "none")
                        }

                    /** Error input Rekening */
                        if(result.errorPayment){
                            $("#input-p-payment").addClass('is-invalid')
                            $("#error-p-payment").css("display", "block")
                            $("#error-p-payment").html(result.errorPayment)
                        } else {
                            $("#input-p-payment").removeClass('is-invalid')
                            $("#error-p-payment").css("display", "none")
                        }
				} else {
                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-add-purchases :input').val('')
                        $('#form-add-purchases :file').val('')
                    }

                    Swal.fire({
                        position: "center",
                        showConfirmButton : true,
                        timer	: 2500,
                        icon	: result.statusIcon,
                        title	: result.statusMsg
                    }).then((result) => {
						getCartList()
					})
				}
			}
		})
	})

	getCartList()
})

/** Function : Set cart list */
function getCartList(){
	$.ajax({
		url     : cart_url,
		type    : 'GET',
		//data    : {filter_keyword : $("input[name='postSearch']").val(), filter_order : $("#contactOrder").val()},
		datatype    : 'json',
		success     : function(result){
			var output = ''
			for(index in result.cart_list){
				output += `
					<tr>
						<td>`+ result.cart_list[index].cart_name +`</td>
						<td class="text-center">`+ result.cart_list[index].cart_amount +`</td>
						<td class="text-right">`+ result.cart_list[index].cart_price +`</td>
						<td class="text-right">`+ result.cart_list[index].cart_total +`</td>
						<td>
							<a class="btn btn-xs btn-danger text-white" onclick="deleteCart('`+ result.delete_url +`', '`+ result.cart_list[index].cart_id +`', '`+ result.cart_list[index].cart_price +`')" >
								<i class="fas fa-trash"></i>
							</a>
						</td>
					</tr>
					`
			}

			$("#cart-shop").find("#total-payment").html(formatCurrency(result.total_payment, ''))
			$("#cart-total").html(formatCurrency(result.total_payment, 'Rp'))
			$("#cart-shop").find("tbody").html(output)
			$("#form-add-transaction").find("input[name='postTotalCart']").val(result.total_payment)
		}
	})
}

/** Function : Delete from cart */
function deleteCart(delete_url, product_id, product_price){
	$.ajax({
		url		: delete_url,
		type	: 'POST',
		data	: { postId : product_id, postPrice : product_price },
		datatype : 'json',
		success	: function(result){
			toastr.warning( result.successMsg )
			getCartList()
		}
	})
}

/** Function : formatCurrency */
function formatCurrency(number, prefix){
	var number_string = number.toString().replace(/[^\d]/g, '.'),
	split	 = number_string.split('.'),
	sisa	 = split[0].length % 3,
	rupiah	 = split[0].substr(0, sisa),
	thousand = split[0].substr(sisa).match(/\d{3}/gi);

	if(thousand){
		separator = sisa ? '.' : '';
		rupiah += separator + thousand.join('.');
	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return (rupiah ? prefix + rupiah : '');
}
