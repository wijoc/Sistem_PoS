$(document).ready(function(){

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
	var searchTerm = $("#ctm-search").val()
	$.ajax({
		url : ctmSearchUrl,
		method : "POST",
		data   : {term : searchTerm},
		success : function(data){
			$("#ctm-data").html(data)
        }
    })
}

/* Function select customer */
function ctmSelected(ctm_id){
	$("#ctm-search").val('') // Kosongkan search bar
	$("#inputTransCtm").val(ctm_id) // Set id terpilih

    if(ctm_id == '0'){
        $("#inputCtmName").val('General customer / Pelanggan Umum')
    } else {
        var getDiscount = null
        /* Get detail data customer berdasar id */
        $.ajax({
            url : ctmDataUrl,
            method : "POST",
            data   : {id : ctm_id},
            dataType : 'json',
            success : function(data){
                /* set display nama customer */
                $("#inputCtmName").val(data.data_name)

                /* jika discount type = percent, Jalankan function discount */
                if(data.data_discount_type == 'prc'){
                    getDiscount = countDiscountPercent(data.data_discount_type, data.data_discount)
                } else {
                    getDiscount = data.data_discount 
                }

                /* Set nilai discount */
                console.log(getDiscount)
                $("#divDiscount").html(getDiscount)
                
            },
            async : false
        })
    }
    countTotalSale()
	ctmSearch()
}

/* Function hitung nilai setelah discount */
function countDiscountPercent(discount_type, discount){
    var totalPrd = $("#totalBayar").val()
    if($("#inputTransOngkir").val() == '' || $("#inputTransOngkir").val() == NULL || typeof($("#inputTransOngkir").val()) == NaN ){
        var totalOngkir = 0;
    } else {
        var totalOngkir = parseFloat($("#inputTransOngkir").val())
    }
    
    return (discount / 100 ) * (totalPrd + totalOngkir)
}

/* Function hitung total bayar */
function countTotalSale(){
    /* set var nilai total penjualan */
    var totalPrd = parseFloat($("#totalBayar").val())

    /* Set variable nilai discount pelanggan */
    var discount = parseFloat($("#inputDiscount").val()) 

    /* set var nilai total ongkir */
    if($("#inputTransDelivery").val() == 'N'){
        var ongkir   = 0;
    } else {
        if($("#inputTransOngkir").val() == ''){
            var ongkir   = 0;
        } else {
            var ongkir = parseFloat($("#inputTransOngkir").val())
        }
    }

    /* Hitung Total penjualan */
    var totalSale = totalPrd - discount + ongkir

    //$("#inputTransTotalBayar").val()
}

/* Function Rupiah */
function addRupiah(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}