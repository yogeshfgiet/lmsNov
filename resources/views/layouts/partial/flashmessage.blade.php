<!-- Stored in resources/views/layouts/partial/flashmessage.blade.php -->

@if(Session::has('flash_success_message'))
    <div class="alert alert-success alert-dismissable">
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
        {{ Session::get('flash_success_message') }}
    </div>
@endif

@if(Session::has('flash_error_message'))
    <div class="alert alert-danger alert-dismissable">
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
        {{ Session::get('flash_error_message') }}
    </div>
@endif