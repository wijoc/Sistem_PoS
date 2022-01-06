$(document).ready(function(){ 
    /** Datatables serverside */
    $("#table-product").DataTable({
        responsive  : true,
        autoWidth   : false,
        processing  : true, // Fitur control indicator "processing"
        serverside  : true, // Fitur control datatables server-side processing mode
        order       : [], // Set nilai default order ke null
        lengthMenu  : [[ 2, 25, 50, -1], [ 10, 25, 50, "All"]], // Option tampil data, kiri : banyak data - kanan : pilihan
        // dom         : 'ltr'+'<"row justify-content-md-center"<"col-sm col-md"i><"col-sm col-md">p>',

        /** Get data dari api menggunakan ajax */
        ajax  : {
            url   : product_url,
            type  : 'GET',
            datatype : 'json',
            // data : {
            //     'start' : 0, // pakai untuk offset data
            //     'length' : 10, // pakai untuk limit data
            // }
        },

        /** Set coloumn properties */
        columnDefs   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }],
        columns   : [
            { 'data': 'data_code' },
            { 'data': 'data_name' },
            { 'data': 'data_category' },
            { 'data': 'data_purchase_price' },
            { 'data': 'data_selling_price' },
            { 'data': 'data_unit' },
            { 'data': 'good_stock' },
            { 'data': null, 
              'render': function () {
                return `<a class="btn btn-xs btn-info text-white" data-toggle="tooltip" data-placement="top" title="Detail produk" data-toggle="tooltip" data-placement="top" title="Detail Produk"><i class="fas fa-search"></i></a>
                <a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah produk" data-toggle="tooltip" data-placement="top" title="Edit Produk"><i class="fas fa-edit"></i></a>
                <a class="btn btn-xs btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Hapus produk" data-toggle="tooltip" data-placement="top" title="Hapus Produk"><i class="fas fa-trash"></i></a>`
              }
                 
            },
        ]
        /**
        'buttons'   : [
            {
                text: 'My button',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ]
        */
    })
})