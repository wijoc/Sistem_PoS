

    /** Datatables Kategori serverside */
    var catTable = $("#table-category").DataTable({
        responsive  : true,
        autoWidth   : false,
        processing  : true, // Fitur control indicator "processing"
        serverSide  : true, // Fitur control datatables server-side processing mode
        order       : [], // Set nilai default order ke null
        lengthMenu  : [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]], // Option tampil data, kiri : banyak data - kanan : pilihan
        // dom         : 'ltr'+'<"row justify-content-md-center"<"col-sm col-md"i><"col-sm col-md">p>',
        searching   : false,
        pageLength  : 10, // Max button in pagination

        /** Get data dari api menggunakan ajax */
        ajax  : function ( data, callback, settings ) {
            // console.log(data)
            $.ajax({
                url: cat_url,
                // dataType: 'text',
                type: 'GET',
                datatype : 'json',
                // contentType: 'application/x-www-form-urlencoded',
                data: {
                    start: 0,
                    length: 2
                },
                success: function( response, textStatus, jQxhr ){
                    console.log(response)
                    callback({
                        // draw: data.draw,
                        data: response.data,
                        recordsTotal:  response.recordsTotal,
                        recordsFiltered:  response.recordsFiltered
                    });
                },
                error: function( jqXhr, textStatus, errorThrown ){
                }
            });
        },
        /** Set coloumn properties */
        columnDefs   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }],
        recordsTotal: 12,
        recordsFiltered: 5,
        columns   : [
            { 'data': 'data_no'},
            { 'data': 'data_name' },
            { 'data': 'data_product' },
            { 'data': null, 
                'render': function () {
                return `<a class="btn btn-xs btn-info text-white" data-toggle="tooltip" data-placement="top" title="Detail produk" data-toggle="tooltip" data-placement="top" title="Detail Produk"><i class="fas fa-search"></i></a>
                <a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah produk" data-toggle="tooltip" data-placement="top" title="Edit Produk"><i class="fas fa-edit"></i></a>
                <a class="btn btn-xs btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Hapus produk" data-toggle="tooltip" data-placement="top" title="Hapus Produk"><i class="fas fa-trash"></i></a>`
              }
            },
        ]
    })
