(() => {
    function e(e, t) {
        for (var a = 0; a < t.length; a++) {
            var n = t[a];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
        }
    }
    var t = function() {
        function t() {! function(e, t) { if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function") }(this, t) }
        var a, n, l;
        return a = t, l = [{
            key: "initDataTables",
            value: function() {
                jQuery.extend(jQuery.fn.dataTable.ext.classes, { sWrapper: "dataTables_wrapper dt-bootstrap4", sFilterInput: "form-control form-control-sm", sLengthSelect: "form-control form-control-sm" }), jQuery.extend(!0, jQuery.fn.dataTable.defaults, { language: { lengthMenu: "_MENU_", search: "_INPUT_", searchPlaceholder: "Search..", info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>", paginate: { first: '<i class="fa fa-angle-double-left"></i>', previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>', last: '<i class="fa fa-angle-double-right"></i>' } } }), jQuery(".js-dataTable-full").dataTable({
                    pageLength: 50,
                    lengthMenu: [
                        [10, 50, 100, 200],
                        [10, 50, 100, 200]
                    ],
                    autoWidth: !1
                }), jQuery(".js-dataTable-buttons").dataTable({
                    pageLength: 50,
                    lengthMenu: [
                        [10, 50, 100, 200],
                        [10, 50, 100, 200]
                    ],
                    autoWidth: !1,
                    buttons: [{ extend: "copy", className: "btn btn-sm btn-primary" }, { extend: "csv", className: "btn btn-sm btn-primary" }, { extend: "print", className: "btn btn-sm btn-primary" }],
                    dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                })
            }
        }, { key: "init", value: function() { this.initDataTables() } }], (n = null) && e(a.prototype, n), l && e(a, l), t
    }();
    jQuery((function() { t.init() }))
})();