<!-- Stored in resources/views/user/moreinfo.blade.php -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/css/jquery.ui.theme.css',
    '/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css',
)) !!}
@endsection

@section('footer_scripts')
{!! Minify::javascript(array(


'/assets/vendors/modal/js/classie.js',
    '/assets/vendors/modal/js/modalEffects.js',
    '/assets/js/user/showings.js',
)) !!}
@endsection
@extends('layouts.dashboard')

@section('section-content')
<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    animation-duration: 0.4s;
    animation-name: animatetop;
    background-color: #fefefe;
    border: 1px solid #888;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    height: 190px;
    margin: auto;
    padding: 0;
    position: relative;
    width: 38%;
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}


/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #217118;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
</style>
    <div class="col-md-12" id="dv_dashboardContent">
        <div class="panel-body text-uppercase">
            <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('showings') }}">
                <span class="glyphicon glyphicon-globe"></span>
                View Available Showings
            </a>
          
            @if($userType == 2)
 
            <a class="btn btn-lg btn-block greenbgs" id="myBtn" onclick="showMessa()"
               href="#">
                <span class="glyphicon glyphicon-file"></span>
                Post A Showing
            </a>

            @else
        
            <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('showings/add') }}">
                <span class="glyphicon glyphicon-file"></span>
                Post A Showing
            </a>

            @endif

            <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('showings/view-your') }}">
                <span class="glyphicon glyphicon-map-marker"></span>
                View Your Postings / Showings
            </a>

            <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('edit-profile') }}">
                <span class="glyphicon glyphicon-edit"></span>
                Edit Your Profile
            </a>

           <!--  <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('edit-billing-info') }}">
                <span class="glyphicon glyphicon-usd"></span>
                Update Payment Methods
            </a> -->
        </div>
    </div>


<div id="msg"> 


<!-- Trigger/Open The Modal -->


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span id="myclose" class="close">×</span>
      <h2>ERROR</h2>
    </div>
    <div class="modal-body">
        <br>
       

      <p>You do not have permission to post a showing and please update your profile by entering a credit card.</p>
      <p> Only then you will be able to access “post a showing” page.</p>
    </div>
   <!--  <div class="modal-footer">
      <h3>Modal Footer</h3>
    </div> -->
  </div>

</div>

    </div>


@endsection


