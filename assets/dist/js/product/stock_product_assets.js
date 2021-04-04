$(document).ready(function(){ 
    /** Datatables serverside */
    stkTable = $("#table-stock-product").DataTable({
        'responsive': true,
        'autoWidth' : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order'      : [], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : stk_product_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }]
    })
})