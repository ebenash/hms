<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2 text-center text-sm-left">
            <div class="flex-sm-fill">
                @yield('page-header')
            </div>
            <div class="mt-3 mt-sm-0 ml-sm-3">
                <a href="{{route('settings')}}" id="feedbackbutton" class="btn btn-sm btn-alt-primary has-ripple rounded-pill" data-toggle="modal" data-target="#feedbackModal">
                    <i class="fa fa-comment"></i> Send Feedback
                </a>
                <a href="{{route('settings')}}" class="btn btn-sm btn-alt-primary">
                    <i class="fa fa-cog"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- END Hero -->
