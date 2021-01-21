$(document).ready(function(){
    /* Run function countTotalSale() */
    countTotalSale()
    
    /* Function inputan biaya ongkir */
    $("#inputTransDelivery").change(function(){
        if($(this).val() == 'E' || $(this).val() == 'T'){
            $("#divOngkir").removeAttr("style").show()
            $("#inputTransOngkir").prop("required", true)
            $("#inputTransOngkir").prop("disabled", false)
        } else {
            $("#divOngkir").hide()
            $("#inputTransOngkir").prop("required", false)
            $("#inputTransOngkir").prop("disabled", true)
        }
        countTotalSale()
    })

    /* Function inputan status pembayaran */
    $("#inputTransStatus").change(function(){
        if($(this).val() == 'K') {
            $(".divKredit").removeAttr("style").show()
            $("#infoCash").hide()
            $(".inputKredit").prop("disabled", false)
            $(".inputKredit").prop("required", true)
            $("#labelPayment").html("Uang Muka / DP")
        } else if($(this).val() == 'T') {
            $(".divKredit").hide()
            $("#infoCash").show()
            $(".inputKredit").prop("disabled", true)
            $(".inputKredit").prop("required", false)
            $("#labelPayment").html("Pembayaran")
        }
        countTotalSale()
    })

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
        $("#staticChoice").show()
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
                $("#staticChoice").hide()
                $("#ctm-data").show()
                $("#ctm-data").html(data)
            }
        })
    }
}

/* Function select customer */
function ctmSelected(ctm_id){
	$("#ctm-search").val('') // Kosongkan search bar
	$("#inputTransCtm").val(ctm_id) // Set id terpilih
    $("#divNewCtm").hide() // hide div pelanggan baru

    if(ctm_id === 'nctm'){
        $("#inputCtmName").val('New Customer / Pelanggan Baru')
        $("#divNewCtm").removeAttr("style").show()
        $(".inputNewCtm").prop("disabled",false)
    } else if(ctm_id === '0000'){
        $("#inputCtmName").val('General customer / Pelanggan Umum')
        $(".inputNewCtm").prop("disabled",true)
    } else {
        /* Get detail data customer berdasar id */
        $.ajax({
            url : ctmDataUrl,
            method : "POST",
            data   : {id : ctm_id},
            dataType : 'json',
            success : function(data){
                /* set display nama customer */
                $("#inputCtmName").val(data.data_name)
                $(".inputNewCtm").prop("disabled",true)           
            },
            //async : false
        })
    }
    countTotalSale()
	ctmSearch()
}

/* Function hitung total bayar */
function countTotalSale(){
    /* set var nilai total penjualan */
    var totalPrd = parseFloat($("#totalBayar").val())

    /* set var nilai total ongkir */
    if($("#inputTransDelivery").val() == 'N'){
        var ongkir   = 0
    } else {
        if($("#inputTransOngkir").val() == ''){
            var ongkir   = 0
        } else {
            var ongkir = parseFloat($("#inputTransOngkir").val())
        }
    }

    /* Hitung Total penjualan */
    var totalSale = totalPrd + ongkir

    $("#inputTransTotalBayar").val(totalSale)
    countPayment()
    $("#notaTotal").html(formatRupiah(totalSale))
}

/* Function hitung kembalian / DP */
function countPayment(){
    var totalSale = parseFloat($("#inputTransTotalBayar").val())
    var payment   = parseFloat($("#inputTransPembayaran").val())
    var paymentStatus = $("#inputTransStatus").val()
    
    if(paymentStatus == 'T'){
        /* Count kembalian / kekurangan */
        var countChange = totalSale-payment;
        /* Tampilkan ke div nota */
          /* Tampil total pembayaran */
            (isNaN(payment) ? $("#notaPayment").html(formatRupiah(0)) : $("#notaPayment").html(formatRupiah(payment)) )
          /* Tampil kembalian */
            if(countChange < 0 ){
                $("#labelChange").html("Kembalian")
                $("#notaChange").html( formatRupiah( Math.abs(countChange) ) )
            } else if (countChange > 0){
                $("#labelChange").html("Kurangan")
                $("#notaChange").html(formatRupiah(countChange))
            } else {
                $("#labelChange").html("Kembalian")
                $("#notaChange").html(formatRupiah(0))
            }
    } else if (paymentStatus == 'K'){
        /* get niali angsuran */
        var angsuran = (isNaN($("#inputTransAngsuran").val()) || $("#inputTransAngsuran").val() == '' ? 0 : parseFloat($("#inputTransAngsuran").val()))
        
        /* set nilai periode */
        if ($("#inputTransTenorPeriode").val() == 'D'){
            var periode = 'Harian'
        } else if ($("#inputTransTenorPeriode").val() == 'W'){
            var periode = 'Mingguan'
        } else if ($("#inputTransTenorPeriode").val() == 'M'){
            var periode = 'Bulanan'
        } else if ($("#inputTransTenorPeriode").val() == 'Y'){
            var periode = 'Tahunan'
        }

        /* Tampil Nota */
        (isNaN(payment) || payment == '' ? $("#notaDP").html(formatRupiah(0)) : $("#notaDP").html(formatRupiah(payment)) )
        $("#notaTenor").html(($("#inputTransTenor").val() == '' ? 0 : $("#inputTransTenor").val()) + ' x ' + periode)
        $("#notaInstallment").html(formatRupiah(angsuran))
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