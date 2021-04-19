$(document).ready(function () {
    /** Datatables serverside */
    transTable = $("#table-transaction").DataTable({
        'responsive' : true,
        'autoWidth'  : false,
        'processing' : true, // Fitur control indicator "processing"
        'serverside' : true, // Fitur control datatables server-side processing mode
        'order'      : [], // Set nilai default order ke null

        /** Load data dari function ajax list di controller */
        'ajax'  : {
            'url'   : transaction_url,
            'type'  : 'POST'
        },

        /** Set coloumn properties */
        'columnDefs'   : [{
            'targets'   : [-1],
            'orderable' : false
        }]
    })
})