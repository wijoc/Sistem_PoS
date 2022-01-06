$(document).ready(function(){ 
    /** Datatable Mutation */
    var mutationTable = $("#table-stock-mutation").DataTable({
        responsive  : true,
        autoWidth   : false,
        processing  : true, // Fitur control indicator "processing"
        serverSide  : true, // Fitur control datatables server-side processing mode
        order       : [], // Set nilai default order ke null
        lengthMenu  : [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]], // Option tampil data, kiri : banyak data - kanan : pilihan
        // dom         : 'ltr'+'<"row justify-content-md-center"<"col-sm col-md"i><"col-sm col-md">p>',
        searching   : true,
        pageLength  : 10, // Max row tiap page

        /** Get data dari api menggunakan ajax */
        ajax  : {
            url   : mutation_url,
            type  : 'GET',
            datatype : 'json',
            data : {
                'necessity' : 'dt'
                // 'start' : 0, // pakai untuk offset data
                // 'length' : 3, // pakai untuk limit data
            }
        },
        /** Set coloumn properties */
        columnDefs   : [{
            'targets'   : [0, -1],
            'orderable' : false
        }],
        columns   : [
                { 'data' : 'data_date'},
                { 'data' : 'data_product'},
                { 'data' : 'data_from'},
                { 'data' : 'data_to'},
                { 'data' : 'data_qty'},
                { 'data' : 'data_ps'}
        ]
    })
})