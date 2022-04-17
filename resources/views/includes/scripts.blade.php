<!-- OneUI Core JS -->
<script src="{{ mix('js/oneui.min.js') }}"></script>

{{-- <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --}}

<!-- Laravel Scaffolding JS -->
{{-- <script src="{{ mix('/js/laravel.app.js') }}"></script> --}}

@yield('js_after')

<script type="text/javascript">
    function display_c(){
        var refresh=1000; // Refresh rate in milli seconds
        mytime=setTimeout('display_ct()',refresh)
    }
    function display_ct() {
        var x = new Date()
        var x1=x.toUTCString();// changing the display to UTC string
        document.getElementById('dateandtime').innerHTML = x1;
        tt=display_c();
    }
    function submitForm(element) {
        document.getElementById("readnotification"+element).submit();
    }
    function swaltoast(title,message,type) {
        var n = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            buttonsStyling: !1,
            customClass: {
                confirmButton: "btn btn-"+type+" m-1",
                cancelButton: "btn btn-"+type+" m-1",
                input: "form-control" }
            });
        return n.fire(title, message, type);
    }
    function swalnotify(title,message,type) {
        var n = Swal.mixin({
            buttonsStyling: !1,
            customClass: {
                confirmButton: "btn btn-lg btn-primary m-1",
                cancelButton: "btn btn-lg btn-alt-primary m-1",
                input: "form-control" }
            });
        return n.fire(title, message, type);
    }
    function swalconfirm(title,message,type) {
        var n = Swal.mixin({
            buttonsStyling: !1,
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: "btn btn-lg btn-primary m-1",
                cancelButton: "btn btn-lg btn-alt-primary m-1",
                input: "form-control" }
            });
        return n.fire(title, message, type);
    }
    function changeTheme(type,value) {
        searchRequest = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('update-theme')}}",
            type: 'POST',
            data: {type: type, value: value},
            success: function(response){
                swaltoast("Success", "Theme Setting Updated", "success");
            }
        });
    }
    function confimdelete(link,success = null) {
        swalconfirm("Are you sure?","Once deleted, you will not be able to recover this record!","warning")
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link,
                    type: 'POST',
                    data: '_method=DELETE',
                    success: function (response) {
                        if (response) {
                           swalnotify("Done!", "Your record has been deleted!","success").then((okay) => {
                               if (success) {
                                return location.href = success;
                               } else {
                                    return location.reload();
                               }

                           });
                        } else {
                           swalnotify("Error!", "There was an error performing the delete! Please try again later","error");
                        }
                    }.bind(this)
                })
            } else {
                swalnotify("Cancelled!", "Delete was cancelled!", "error");
            }
        });
        }

</script>

{{-- @if(isset($all_calendar_reservations))
    {!! $all_calendar_reservations->script() !!}
@endif
<script>
console.log("document is ready");
$(document).ready(function() {

  if(window.location.href.indexOf('#modal-view-add-reservation') != -1) {
    $('#modal-view-add-reservation').modal('show');
  }

});
</script> --}}

{{-- <script src="{{ asset('assets/js/pages/base_forms_pickers_more.js') }}"></script> --}}
{{-- <script>
    jQuery(function () {
        // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
        App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
</script> --}}
