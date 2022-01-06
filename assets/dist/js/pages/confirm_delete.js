function confirmDelete(item, get_id, del_url, msg){
    /** Cegah default event */
	event.preventDefault()
	
	switch(item){
		case "ctgr":
			var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data kategori akan mengubah detail data product dengan kategori ini !"
			var cancelMsg  = "Batal menghapus data kategori !"
            var del_type   = "hard"
			break
		case "unit":
			var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data satuan akan mengubah detail data product dengan satuan ini !"
			var cancelMsg  = "Batal menghapus data satuan !"
            var del_type   = "hard"
			break
		case "soft-prd":
			var warningMsg = "Menghapus data product tidak berpengaruh terhadap transaksi yang sudah dilakukan !"
			var cancelMsg  = "Batal menghapus data product !"
            var del_type   = "soft"
			break
        case "hard-prd":
            var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data product akan menghapus transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data product !"
            var del_type   = "hard"
            break
        case "soft-supp":
            var warningMsg = "Menghapus data supplier tidak berpengaruh terhadap transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data supplier !"
            var del_type   = "soft"
            break
        case "hard-supp":
            var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data supplier akan menghapus transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data supplier !"
            var del_type   = "hard"
            break
        case "soft-ctm":
            var warningMsg = "Menghapus data pelanggan tidak berpengaruh terhadap transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data pelanggan !"
            var del_type   = "soft"
            break
        case "hard-ctm":
            var warningMsg = "Penghapusan data bersifat permanen ! Menghapus data pelanggan akan menghapus transaksi yang sudah dilakukan !"
            var cancelMsg  = "Batal menghapus data pelanggan !"
            var del_type   = "hard"
            break
        case "soft-account":
            var warningMsg = "Penghapusan data rekening tidak berpengaruh terhadap transaksi !"
            var cancelMsg  = "Batal menghapus data rekening !"
            var del_type   = "soft"
            break
		default :
			var warningMsg = msg
			var cancelMsg  = "Batal menghapus data !"
            var del_type   = "soft"
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
                type    : 'DELETE',
                url     : del_url,
                data    : { "dataID" : get_id, "type" : del_type },
                datatype    : 'json',
                statusCode: {
                    200: function (response) {
                        Swal.fire({
                            position: "center",
                            showConfirmButton: true,
                            timer: 3500,
                            icon: response.icon,
                            title: response.message
                        }).then((r) => {
                            $(response.table).DataTable().ajax.reload()
                        })
                    },
                    500: function (response) {
                        if(response.responseJSON){
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: response.responseJSON.icon,
                                title: response.responseJSON.message
                            })
                        } else {
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: 'error',
                                title: response.statusText
                            })
                        }
                    },
                    400: function (response) {
                        if(response.responseJSON){
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: response.responseJSON.icon,
                                title: response.responseJSON.message
                            })
                        } else {
                            Swal.fire({
                                position: "center",
                                showConfirmButton: true,
                                timer: 2500,
                                icon: 'error',
                                title: response.statusText
                            })
                        }
                    }
                },
                // error: function(jqxhr, status, error) {
                //     alert('error:', error);
                //     console.log('jqxhr : ' + jqxhr)
                //     console.log('status : ' + status)
                //     console.log('error : ' + error)
                // }
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