@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <script>
            $(window).on('load', function() {
                swaltoast("Error", "{{ $error }}", "error");
            });
        </script>
          @php
            Session::forget('error');
          @endphp
    @endforeach
@endif

@if(Session::has('success'))
    <script>
        $(window).on('load', function() {
            swaltoast("Success", "{{ Session::get('success') }}", "success");
        });
    </script>
    @php
      Session::forget('success');
    @endphp
@endif


@if(Session::has('info'))
    <script>
        $(window).on('load', function() {
            swaltoast("Info", "{{ Session::get('info') }}", "info");
        });
    </script>
    @php
      Session::forget('info');
    @endphp
@endif


@if(Session::has('warning'))
    <script>
        $(window).on('load', function() {
            swaltoast("Warning", "{{ Session::get('warning') }}", "warning");
        });
    </script>
    @php
      Session::forget('warning');
    @endphp
@endif


@if(Session::has('error'))
    <script>
        $(window).on('load', function() {
            swaltoast("Error", "{{ Session::get('error') }}", "error");
        });
    </script>
    @php
      Session::forget('error');
    @endphp
@endif

@if(Session::has('status'))
  <script>
    $(window).on('load', function() {
      swaltoast("Info", "{{ Session::get('status') }}", "inverse");
    });
    </script>
    @php
      Session::forget('status');
    @endphp
@endif
