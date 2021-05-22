$(document).ready(function(){
    /* Function inputan biaya ongkir */
    $("#input-s-delivery").change(function(){
        if($(this).val() == 'E' || $(this).val() == 'T'){
            $("#div-postal-fee").removeAttr("style").show()
            $("#input-s-fee").prop("required", true)
            $("#input-s-fee").prop("disabled", false)

            if($("#input-s-status").val() != 'K') { 
                $("#div-postal-fee").removeClass("col-md-6").addClass("col-md-4") 
            } else {
                $("#div-postal-fee").removeClass("col-md-4").addClass("col-md-6") 
            }
        } else {
            $("#div-postal-fee").hide()
            $("#input-s-fee").prop("required", false)
            $("#input-s-fee").prop("disabled", true)
        }
        countTotalSale()
    })

    /* Function inputan status pembayaran */
    $("#input-s-status").change(function(){
        if($(this).val() == 'K') {
            $(".div-credit").removeAttr("style").show()
            $("#info-cash").hide()
            $(".class-credit").prop("disabled", false)
            $(".class-credit").prop("required", true)
            $("#label-payment").html("Uang Muka / DP")

            $("#div-delivery").toggleClass("col-md-4 col-md-6")
            $("#div-postal-fee").toggleClass("col-md-4 col-md-6") 
        } else if($(this).val() == 'T') {
            $(".div-credit").hide()
            $("#info-cash").show()
            $(".class-credit").prop("disabled", true)
            $(".class-credit").prop("required", false)
            $("#label-payment").html("Pembayaran")

            $("#div-delivery").toggleClass("col-md-6 col-md-4")
            $("#div-postal-fee").toggleClass("col-md-6 col-md-4")
        }
        countTotalSale()
    })

	/** Submit Purchases */
	$("#form-add-sales").on("submit", function(event){
        event.preventDefault()
        $.ajax({
            url     : $(this).attr("action"),
            method  : 'POST',
            data    : $("#form-add-sales").serialize(),
            datatype    : 'json',
            beforeSend  : function(){
                $(this).prop("disabled", true)
            },
            success : function(result){
				if(result.error){
                    /** Error Total Sales */
                        if(result.errorSTotalSale){
                            toastr.error( `<span class="align-middle"><font class="font-weight-bold">` + result.errorSTotalSale + `</font></span>` )
                        }

                    /** Error Costumer */
                        if(result.errorSCtm){
                            $("#input-s-ctm-name").addClass('is-invalid')
                            $("#error-s-ctm").css("display", "block")
                            $("#error-s-ctm").html(result.errorSCtm)
                        } else {
                            $("#input-s-ctm-name").removeClass('is-invalid')
                            $("#error-s-ctm").css("display", "none")
                        }

                    /** Error input Date */
                        if(result.errorSDate){
                            $("#input-s-date").addClass('is-invalid')
                            $("#error-s-date").css("display", "block")
                            $("#error-s-date").html(result.errorSDate)
                        } else {
                            $("#input-s-date").removeClass('is-invalid')
                            $("#error-s-date").css("display", "none")
                        }

                    /** Error input Status */
                        if(result.errorStatus){
                            $("#input-s-status").addClass('is-invalid')
                            $("#error-s-status").css("display", "block")
                            $("#error-s-status").html(result.errorStatus)
                        } else {
                            $("#input-s-status").removeClass('is-invalid')
                            $("#error-s-status").css("display", "none")
                        }

                    /** Error input Tempo */
                        if(result.errorSDue){
                            $("#input-s-due").addClass('is-invalid')
                            $("#error-s-due").css("display", "block")
                            $("#error-s-due").html(result.errorSDue)
                        } else {
                            $("#input-s-due").removeClass('is-invalid')
                            $("#error-s-due").css("display", "none")
                        }

                    /** Error input Tenor */
                        if(result.errorSTenor){
                            $("#input-s-tenor").addClass('is-invalid')
                            $("#error-s-tenor").css("display", "block")
                            $("#error-s-tenor").html(result.errorSTenor)
                        } else {
                            $("#input-s-tenor").removeClass('is-invalid')
                            $("#error-s-tenor").css("display", "none")
                        }

                    /** Error input Periode */
                        if(result.errorSTenorPeriode){
                            $("#input-s-tenor-periode").addClass('is-invalid')
                            $("#error-s-tenor-periode").css("display", "block")
                            $("#error-s-tenor-periode").html(result.errorSTenorPeriode)
                        } else {
                            $("#input-s-tenor-periode").removeClass('is-invalid')
                            $("#error-s-tenor-periode").css("display", "none")
                        }

                    /** Error input Delivery */
                        if(result.errorSInstallment){
                            $("#input-s-installment").addClass('is-invalid')
                            $("#error-s-installment").css("display", "block")
                            $("#error-s-installment").html(result.errorSInstallment)
                        } else {
                            $("#input-s-installment").removeClass('is-invalid')
                            $("#error-s-installment").css("display", "none")
                        }

                    /** Error input Delivery */
                        if(result.errorSDelivery){
                            $("#input-s-delivery").addClass('is-invalid')
                            $("#error-s-delivery").css("display", "block")
                            $("#error-s-delivery").html(result.errorSDelivery)
                        } else {
                            $("#input-s-delivery").removeClass('is-invalid')
                            $("#error-s-delivery").css("display", "none")
                        }

                    /** Error input Postal fee / Ongkir */
                        if(result.errorSPostalFee){
                            $("#input-s-fee").addClass('is-invalid')
                            $("#error-s-fee").css("display", "block")
                            $("#error-s-fee").html(result.errorSPostalFee)
                        } else {
                            $("#input-s-fee").removeClass('is-invalid')
                            $("#error-s-fee").css("display", "none")
                        }

                    /** Error input Pembayaran */
                        if(result.errorSPayment){
                            $("#input-s-payment").addClass('is-invalid')
                            $("#error-s-payment").css("display", "block")
                            $("#error-s-payment").html(result.errorSPayment)
                        } else {
                            $("#input-s-payment").removeClass('is-invalid')
                            $("#error-s-payment").css("display", "none")
                        }

                    /** Error input Payment Method / Metode */
                        if(result.errorSPayment){
                            $("#input-s-payment").addClass('is-invalid')
                            $("#error-s-payment").css("display", "block")
                            $("#error-s-payment").html(result.errorSPayment)
                        } else {
                            $("#input-s-payment").removeClass('is-invalid')
                            $("#error-s-payment").css("display", "none")
                        }

                    /** Error input Payment Method / Metode */
                        if(result.errorSMethod){
                            $("#input-method").addClass('is-invalid')
                            $("#error-s-method").css("display", "block")
                            $("#error-s-method").html(result.errorSMethod)
                        } else {
                            $("#input-method").removeClass('is-invalid')
                            $("#error-s-method").css("display", "none")
                        }

                    /** Error input Payment Method / Metode */
                        if(result.errorSAccount){
                            $("#input-account").addClass('is-invalid')
                            $("#error-s-account").css("display", "block")
                            $("#error-s-account").html(result.errorSAccount)
                        } else {
                            $("#input-account").removeClass('is-invalid')
                            $("#error-s-account").css("display", "none")
                        }
                        
                } else {
					getCartList()

                    $(".error-msg").css("display", "none")
                    $(".is-invalid").removeClass("is-invalid")
                    
                    if(result.status == 'successInsert'){
                        $('#form-add-sales')[0].reset()
						/** disable delivery */
						$("#div-postal-fee").css("display", "none")
						$("#input-s-fee").prop("disabled", true)
						$("#input-s-fee").prop("required", false)
						/** disable method */
						$(".method-tf").css("display", "none")
						$("#input-account").prop("disabled", true)
						$("#input-account").prop("required", false)
						/** disable status */
						$(".div-credit").css("display", "none")
						$(".class-credit").prop("disabled", true)
						$(".class-credit").prop("required", false)
						/** Set label payment */
                        $("#label-payment").html("Pembayaran")
                        $("#info-cash").show()

                        $("#div-delivery").toggleClass("col-md-6 col-md-4")
                        $("#div-postal-fee").toggleClass("col-md-6 col-md-4")
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

    /* Run function countTotalSale() */
    countTotalSale()
    
    /* Function saat edit satuan di click 
    $("#ctm-search").on("keyup", function(){
    	var searchTerm = $(this).val()
        $.ajax({
            url : ctmSearchUrl,
            method : "POST",
            data   : {term : searchTerm},
            success : function(data){
            	$("#ctm-data").html(data)
            }
        })
    })*/
})

/* Function cari customer */
function ctmSearch(){
	var searchKeyword = $("#ctm-search").val()
    if(searchKeyword == ''){
        $("#static-choice").show()
        $("#ctm-data").hide()
    } else {
        $.ajax({
            url : ctmSearchUrl,
            method : "POST",
            data   : {
                keyword : searchKeyword,
                type    : 'sales'
            },
            success : function(data){
                $("#static-choice").hide()
                $("#ctm-data").show()
                $("#ctm-data").html(data)
            }
        })
    }
}

/* Function select customer */
function ctmSelected(ctm_id){
	$("#ctm-search").val('') // Kosongkan search bar
	$("#input-s-ctm-id").val(ctm_id) // Set id terpilih
    $("#div-new-ctm").hide() // hide div pelanggan baru

    if(ctm_id === 'nctm'){
        $("#input-s-ctm-name").val('New Customer / Pelanggan Baru')
        $("#div-new-ctm").removeAttr("style").show()
        $(".class-new-ctm").prop("disabled",false)
    } else if(ctm_id === '0000'){
        $("#input-s-ctm-name").val('General customer / Pelanggan Umum')
        $(".class-new-ctm").prop("disabled",true)
    } else {
        /* Get detail data customer berdasar id */
        $.ajax({
            url : ctmDataUrl,
            method : "GET",
            data   : {id : ctm_id},
            dataType : 'json',
            success : function(data){
                /* set display nama customer */
                $("#input-s-ctm-name").val(data.data_name)
                $(".class-new-ctm").prop("disabled",true)           
            },
            //async : false
        })
    }
    countTotalSale()
	ctmSearch()
}

/* Function hitung total bayar */
function countTotalSale(pass_total_cart){
    total_cart = ( typeof(pass_total_cart) != 'undefined' ? pass_total_cart : parseFloat($("#total-cart").val()) )
    /* set var nilai total ongkir */
    if($("#input-s-delivery").val() == 'N'){
        var postal_fee   = 0
    } else {
        if($("#input-s-fee").val() == ''){
            var postal_fee = 0
        } else {
            var postal_fee = parseFloat($("#input-s-fee").val())
        }
    }

    /* Hitung Total penjualan */
    var total_sales = parseFloat(total_cart) + postal_fee

    $("#input-s-total-sales").val(total_sales)
    countPayment()
    $("#note-total").html(formatRupiah(total_sales))
}

/* Function hitung kembalian / DP */
function countPayment(){
    var total_sales = parseFloat($("#input-s-total-sales").val())
    var payment     = parseFloat($("#input-s-payment").val())
    var payment_status = $("#input-s-status").val()
    
    if(payment_status == 'T'){
        /* Count kembalian / kekurangan */
        var count_change = total_sales - payment;
        /* Tampilkan ke div nota */
          /* Tampil total pembayaran
            (isNaN(payment) ? $("#notaPayment").html(formatRupiah(0)) : $("#notaPayment").html(formatRupiah(payment)) ) */
          /* Tampil kembalian */
            if(count_change < 0 ){
                $("#label-change").html("Kembalian")
                $("#note-change").html( formatRupiah( Math.abs(count_change) ) )
            } else if (count_change > 0){
                $("#label-change").html("Kurangan")
                $("#note-change").html(formatRupiah(count_change))
            } else {
                $("#label-change").html("Kembalian")
                $("#note-change").html(formatRupiah(0))
            }
    } else if (payment_status == 'K'){
        /* get niali angsuran */
        var angsuran = (isNaN($("#input-s-installment").val()) || $("#input-s-installment").val() == '' ? 0 : parseFloat($("#input-s-installment").val()))
        
        /* set nilai periode */
        if ($("#input-s-tenor-periode").val() == 'D'){
            var periode = 'Harian'
        } else if ($("#input-s-tenor-periode").val() == 'W'){
            var periode = 'Mingguan'
        } else if ($("#input-s-tenor-periode").val() == 'M'){
            var periode = 'Bulanan'
        } else if ($("#input-s-tenor-periode").val() == 'Y'){
            var periode = 'Tahunan'
        }

        /* Tampil Nota */
        (isNaN(payment) || payment == '' ? $("#note-dp").html(formatRupiah(0)) : $("#note-dp").html(formatRupiah(payment)) )
        $("#note-tenor").html(($("#input-s-tenor").val() == '' ? 0 : $("#input-s-tenor").val()) + ' x ' + periode)
        $("#note-installment").html(formatRupiah(angsuran))
    }
}

/* Function Rupiah */
function formatRupiah(num){
  return (
    num
      .toFixed(2) // always two decimal digits
      .replace('.', ',') // replace decimal point character with ,
      .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  ) // use . as a separator
}