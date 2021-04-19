$(document).ready(function() {
	/** Tambah keranjang */
	$("#form-cart").on("submit", function(event) {
		event.preventDefault()
		$.ajax({
			url: $(this).attr("action"),
			method: "POST",
			data: $(this).serialize(),
			datatype: "json",
			beforeSend: function () {
				$(this).find(":submit").prop("disabled", true)
			},
			success: function (result) {
				if (result.error) {
					const Toast = Swal.mixin({
						toast	: true,
						position: "top-end",
						showConfirmButton: false,
						timer	: 2000,
					})

					toastr.error( (typeof(result.errorID) != 'unidentified' ? result.errorID : '') +''+ (typeof(result.errorQty) != 'unidentified' ? result.errorQty : '') +''+ (typeof(result.errorHrg) != 'unidentified' ? result.errorHrg : '') +''+ (typeof(result.errorDisc) != 'unidentified' ? result.errorDisc : '') )
				} else {
					toastr.success( result.successMsg )
					$("#form-cart").trigger("reset")
					getCartList()
				}
			},
			error: function (jqxhr, status, exception) {
				alert("Exception", exception)
			},
		})
	})

	/** Status pembayaran */
	$("#input-status").change(function () {
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
	$("#input-method").change(function () {
		if ($(this).val() == "TF") {
			$(".method-tf").css("display", "block")
			$("#input-account").prop("disabled", false)
			$("#input-account").prop("required", true)
		} else {
			$(".method-tf").css("display", "none")
			$("#input-account").prop("disabled", true)
			$("#input-account").prop("required", false)
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
            method  : 'POST',
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

                    /** Error input Status */
                        if(result.errorPStatus){
                            $("#input-status").addClass('is-invalid')
                            $("#error-p-status").css("display", "block")
                            $("#error-p-status").html(result.errorPStatus)
                        } else {
                            $("#input-status").removeClass('is-invalid')
                            $("#error-p-status").css("display", "none")
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
                            $("#input-method").addClass('is-invalid')
                            $("#error-p-method").css("display", "block")
                            $("#error-p-method").html(result.errorPMethod)
                        } else {
                            $("#input-method").removeClass('is-invalid')
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

                    /** Error input Additional charge */
                        if(result.errorPAdditional){
                            $("#cart-addition-charge").addClass('is-invalid')
                            $("#error-p-additional").css("display", "block")
                            $("#error-p-additional").html(result.errorPAdditional)
                        } else {
                            $("#cart-addition-charge").removeClass('is-invalid')
                            $("#error-p-additional").css("display", "none")
                        }
				} else {
					getCartList()

                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-add-purchases :input').val('')
                        $('#form-add-purchases :file').val('')
						$("#input-p-file").val('')
						/** set label bs-custom-input */
						$("#input-p-file").next('.custom-file-label').html('Pilih file Nota')
						/** disable method */
						$(".method-tf").css("display", "none")
						$("#input-p-account").prop("disabled", true)
						$("#input-p-account").prop("required", false)
						/** disable status */
						$(".status-k").css("display", "none")
						$(".input-k").prop("disabled", true)
						$(".input-k").prop("required", false)
						/** Clear additional */
						$("#cart-addition-charge").val('')
                    }

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

	/** Additonal-charge purchase */
	$("#cart-addition-charge").on('keyup', function(){
		$("#input-additional-charge").val($(this).val())
		getCartList()
	})

	/* Autocomplete on Nama atau Barcode Product */
	$("#input-cart-prd").autocomplete({
		source: prd_url,

		select: function(event, ui){
			$('[name="postIdPrd"]').val(ui.item.prd_id);
			$("#input-cart-prd").val(ui.item.label);
			$("#input-cart-price").val(ui.item.prd_harga_beli);
		}
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
			if(result.trans_type == 'Purchases'){
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
						</tr>`
				}
				
				$("#cart-shop").find("#total-payment").html(formatCurrency(result.total_payment, ''))
				
				total = ( $("#cart-addition-charge").val() == "" ? 0 : parseFloat($("#cart-addition-charge").val()) ) + parseFloat(result.total_payment)
				$("#cart-total").html(formatCurrency( total , 'Rp'))
				
				$("#cart-shop").find("tbody").html(output)
				$("#form-add-transaction").find("input[name='postTotalCart']").val(result.total_payment)
			} else if(result.trans_type == 'Sales'){
				for(index in result.cart_list){
					output += `
						<tr>
							<td><small>`+ result.cart_list[index].cart_name +`</small></td>
							<td class="text-center">`+ result.cart_list[index].cart_amount +`</td>
							<td class="text-right">`+ result.cart_list[index].cart_price +`</td>
							<td class="text-right">`+ result.cart_list[index].cart_discount +`</td>
							<td class="text-right">`+ result.cart_list[index].cart_total +`</td>
							<td>
								<a class="btn btn-xs btn-danger text-white" onclick="deleteCart('`+ result.delete_url +`', '`+ result.cart_list[index].cart_id +`', '`+ result.cart_list[index].cart_price +`')" >
									<i class="fas fa-trash"></i>
								</a>
							</td>
						</tr>`
				}

				$("#cart-shop").find("#total-payment").html(formatCurrency(result.total_payment, ''))
				$("#cart-shop").find("tbody").html(output)
				$("#form-add-sales").find("#total-cart").val(result.total_payment)
			
				/** Display total sales */
				if(typeof(countTotalSale) != "undefined"){ countTotalSale(result.total_payment) }
			}
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
			toastr.warning( `<font class="font-weight-bold">` + result.successMsg + `</font>` )
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

/** Function : Total payment per product */
function totalPrice(page){
	var cart_qty = $("#input-cart-qty").val();
	var cart_price  = $("#input-cart-price").val();
	if(page == 'sales'){
		var prdPotongan = $("#inputPotonganPrd").val();
		var potongan = (prdPotongan != '')? prdPotongan : 0 ;
		var total = parseInt(cart_qty) * parseFloat(cart_price) - parseFloat(potongan);
	} else {
		var total = parseInt(cart_qty) * parseFloat(cart_price);
	}

	if(isNaN(total)){
		$("#inputTotalPrd").val(0);
	} else {
		$("#inputTotalPrd").val(total);
	}
}