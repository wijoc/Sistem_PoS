$(document).ready(function(){

	/* Setting content tab-pane */
    $('.tabs-pilihan').click(function(){
        $('.tab-content').find('.tab-pane').removeClass('active');
        $($(this).attr('href')).addClass('active');
    })

    /* Function saat edit kategori di click */
    $('.ktgrEdit').click(function(){
    	var id   = $(this).data("id");
    	var nama = $(this).data("nama");
        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);
    	$("#modal-edit").find("#editID").val(id);
    	$("#modal-edit").find("#editNama").val(nama);
    	$("#formEdit").attr("action", "editKategoriProses");
    })

    /* Function saat edit satuan di click */
    $('.satuanEdit').click(function(){
    	var id   = $(this).data("id");
    	var nama = $(this).data("nama");
        $("#editID").prop("required", true);
        $("#editID").prop("disabled", false);
    	$("#modal-edit").find("#editID").val(id);
    	$("#modal-edit").find("#editNama").val(nama);
    	$("#formEdit").attr("action", "editSatuanProses");
    })
})