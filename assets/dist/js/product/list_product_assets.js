$(document).ready(function(){ 
    /** Datatables serverside */
    prdTable = $("#table-product").DataTable({
        'responsive': true,
        'autoWidth' : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order' : [], // Set nilai default order ke null
        //'dom'   : 'ltr'+'<"row justify-content-md-center"<"col-sm col-md"i><"col-sm col-md">p>',

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : product_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }],
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