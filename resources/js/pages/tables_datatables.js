/*
 *  Document   : tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Plugin Init Example Page
 */

// DataTables, for more examples you can check out https://www.datatables.net/
class pageTablesDatatables {
    /*
     * Init DataTables functionality
     *
     */
    static initDataTables() {
        jQuery.extend(jQuery.fn.dataTable.ext.classes, {
            sWrapper: "dataTables_wrapper dt-bootstrap4",
            sFilterInput: "form-control form-control-sm",
            sLengthSelect: "form-control form-control-sm"
        }), jQuery.extend(!0, jQuery.fn.dataTable.defaults, {
            language: {
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search..",
                info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
                paginate: {
                    first: '<i class="fa fa-angle-double-left"></i>',
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>',
                    last: '<i class="fa fa-angle-double-right"></i>'
                }
            }
        }), jQuery(".js-dataTable-full").dataTable({
            pageLength: 50,
            lengthMenu: [
                [10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            searching: false,
            buttons: [{ extend: "colvis", className: "btn btn-sm btn-alt-primary" }],
            autoWidth: !1,
            dom: "<'row'<'col-sm-12'<'text-left py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        }), jQuery(".js-dataTable-full-pagination").dataTable({
            pagingType: "full_numbers",
            pageLength: 50,
            lengthMenu: [
                [10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            autoWidth: !1
        }), jQuery(".js-dataTable-simple").dataTable({
            pageLength: 50,
            lengthMenu: !1,
            searching: !1,
            autoWidth: !1,
            dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>"
        }), jQuery(".js-dataTable-buttons").dataTable({
            pageLength: 50,
            lengthMenu: [
                [10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            scrollX: true,
            autoWidth: !1,
            buttons: [{ extend: "colvis", className: "btn btn-sm btn-alt-primary" }, { extend: "copy", className: "btn btn-sm btn-alt-primary" }, { extend: "csv", className: "btn btn-sm btn-alt-primary" }, { extend: "print", className: "btn btn-sm btn-alt-primary" }],
            dom: "<'row'<'col-sm-12'<'text-left py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        }), jQuery(".js-dataTable-report").dataTable({
            pageLength: 200,
            responsive: true,
            scrollX: true,
            lengthMenu: [
                [50, 100, 200, 500],
                [50, 100, 200, 500]
            ],
            columnDefs: [
                // { targets: [0, 1], visible: false },
            ],
            searching: false,
            autoWidth: !1,
            buttons: [{ extend: "colvis", className: "btn btn-sm btn-alt-primary" }, { extend: "copy", className: "btn btn-sm btn-alt-primary" }, { extend: "csv", className: "btn btn-sm btn-alt-primary" }, { extend: "pdf", className: "btn btn-sm btn-alt-primary" }, { extend: "print", className: "btn btn-sm btn-alt-primary" }],
            dom: "<'row'<'col-sm-12'<'text-left py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        })
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.initDataTables();
    }
}

// Initialize when page loads
jQuery(() => { pageTablesDatatables.init(); });