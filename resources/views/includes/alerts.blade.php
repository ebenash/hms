@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h3 class="font-w300 push-15">Error</h3>
            <p>{{$error}}</p>
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h3 class="font-w300 push-15">Success</h3>
        <p>{{session('success')}}</p>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h3 class="font-w300 push-15">Error</h3>
        <p>{{session('error')}}</p>
    </div>
@endif
