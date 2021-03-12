function confirmDelete(item, getid, url, msg){
    /** Cegah default event */
	event.preventDefault()
	
	switch(item){
		case "ctgr":
			var warningMsg = "Penghapusan data bersifat permanen !  Menghapus data kategori akan mengubah detail data product dengan kategori ini !"
			var cancelMsg  = "Batal menghapus data kategori !"
			break
		case "unit":
			var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data satuan akan mengubah detail data product dengan satuan ini !"
			var cancelMsg  = "Batal menghapus data satuan !"
			break
		case "soft-prd":
			var warningMsg = "Menghapus data product tidak berpengaruh terhadap transaksi yang sudah dilakukan !"
			var cancelMsg  = "Batal menghapus data product !"
			break
        case "hard-prd":
            var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data product akan menghapus transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data product !"
            break
        case "soft-supp":
            var warningMsg = "Menghapus data supplier tidak berpengaruh terhadap transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data supplier !"
            break
        case "hard-supp":
            var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data supplier akan menghapus transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data supplier !"
            break
        case "soft-ctm":
            var warningMsg = "Menghapus data pelanggan tidak berpengaruh terhadap transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data pelanggan !"
            break
        case "hard-ctm":
            var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data pelanggan akan menghapus transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data pelanggan !"
            break
		default :
			var warningMsg = msg
			var cancelMsg  = "Batal menghapus data !"
	}

    /** Custom tombol sweetalert 2 */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton   : 'btn btn-success',
            cancelButton    : 'btn btn-danger'
        },
        buttonsStyling: false
    })

    /** Fire sweetAlert untuk konfirmasi */
    swalWithBootstrapButtons.fire({
        title: 'ANDA YAKIN MENGHAPUS DATA ?',
        text: warningMsg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Data !',
        cancelButtonText: 'Tidak, Batalkan !',
        reverseButtons: true
    }).then((result) => {
        /** jika klik tombol confirm, kirim data id via ajax */
        if (result.value){
            $.ajax({
                type: 'POST',
                url: url,
                data: {"postID":getid},
                proccesData: false,
                /** jika ajax sukses mengirim data */
                success: function(data){
                    /** jika hasil return function delete success */
                    if(data==='successDelete'){
                        Swal.fire({
                            position: 'center',
                            showConfirmButton: true,
                            timer: 1500,
                            icon: 'success',
                            title: 'Data berhasil dihapus !'
                        }).then((result)=>{
                            if(item == 'soft-supp'){
                                $("input[name='postSearch']").val('')
                                $("#suppOrder").val('asc')
                                $.getScript('../assets/dist/js/pages/contact_assets.js', function(data, textStatus, jqxhr ) {
                                    getRowData(0)
                                })
                            } else { $('.table-server').DataTable().ajax.reload() }
                        })
                    } else if (data==='failedDelete') {
                        Swal.fire({
                            position: 'center',
                            showConfirmButton: true,
                            timer: 1500,
                            icon: 'error',
                            title: 'Data gagal dihapus !'
                        }).then((result)=>{
                            $('.table-server').DataTable().ajax.reload()
                        })
                    } else {
                        Swal.fire({
                            position: 'center',
                            showConfirmButton: true,
                            timer: 150000,
                            icon: 'error',
                            //title: 'Terjadi Kesalahan pada sistem. Silahkan coba beberapa saat lagi !'
                            title: data
                        }).then((result)=>{
                            $('.table-server').DataTable().ajax.reload()
                        })
                    }
                },
                /* Jika ajax gagal mengirim data */
                error: function (data) {
                    Swal.fire({
                        posisiton: 'center',
                        showConfirmButton: true,
                        timer: 1500,
                        icon: 'error',
                        title: data
                    }).then((result)=>{
                        $('.table-server').DataTable().ajax.reload()
                    })
                }
            })
        /* Jika klik tombol batal */
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Dibatalkan',
                cancelMsg,
                'warning'
            )
        }
    })

}