$(document).ready(function(){ 
    /** Datatables serverside */
    prdTable = $("#table-product").DataTable({
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order'      : [], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : product_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'coloumnDefs'   : [{
            'targets'   : [0],
            'orderable' : false
        }],
        'buttons'    : [
            'copy', 'excel', 'pdf'
        ],
    })
})