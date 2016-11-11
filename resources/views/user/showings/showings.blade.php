@extends('layouts.dashboard')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
 
)) !!}
@endsection

<!-- Page level JS files -->
@section('footer_scripts')

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSV9YEV0U9LaWttfpMTAESr_eqpOxiiGs"></script>
{!! Minify::javascript(array(
  
)) !!}
@endsection

@section('section-content')


<div class="row">
    <div class="col-lg-12">
        <div class="tabbable-panel">
            <div class="tabbable-line">
            
                <div class="tab-content">
                    
                    <div class="tab-pane" id="tab_default_2">
                        <br />
                        <div id="dv_registration" class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Showings Information
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="showings_list" class="table table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                View Your Showings
            </a>

            <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('edit-profile') }}">
                <span class="glyphicon glyphicon-edit"></span>
                Edit Your Profile
            </a>

            <a class="btn btn-lg btn-block greenbgs"
               href="{{ URL::to('edit-billing-info') }}">
                <span class="glyphicon glyphicon-usd"></span>
                Update Payment Methods
            </a>
        </div>
    </div>

@endsection