@extends('layouts.dashboard')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/vendors/datatables/css/dataTables.colReorder.min.css',
    '/assets/vendors/datatables/css/dataTables.scroller.min.css',
    '/assets/vendors/datatables/css/dataTables.bootstrap.css',
    '/assets/css/pages/tables.css',
    )) !!}
    @endsection

    <!-- Page level JS files -->
    @section('footer_scripts')
    {!! Minify::javascript(array(
    '/assets/vendors/datatables/jquery.dataTables.min.js',
    '/assets/vendors/datatables/dataTables.colReorder.min.js',
    '/assets/vendors/datatables/dataTables.bootstrap.js',
    '/assets/js/user/showings.js'
    )) !!}
    @endsection

    @section('section-content')
    <!-- Approve Model  -->
    <style>
/*

    .new-reject_2 
    td:last-child {
        display: none;

    }
    .new-reject_2 
    th:last-child {
        display: none;

    }*/
    </style>
    <div id="acceptedUserList" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Details of showing agent</h4>
        </div>
        <div class="modal-body">



        </div>
        <div id="closebutton" style="display:none"class="modal-footer">
            <button class="btn btn-default"  type="button" data-dismiss="modal">Close</button>
        </div>
        <div id="mybutton" class="modal-footer">
         <button id="rejectShowing" class="btn btn-danger" data-loading-text="Rejecting..." type="button"
         onclick="rejectShowing()">Reject</button>
         <button id="newApprove" class="btn btn-success" data-loading-text="Saving..." type="button"
         onclick="approveShowing()">Approve</button>
     </div>

 </div>

</div>
</div>


<!-- model for -->

<!-- Approve model -->

<!-- <div class="row">
    <div class="col-lg-12">
        @if (isset($errors) && (count($errors) > 0))
            <div class="alert alert-danger alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="tabbable-panel">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_default_1" data-toggle="tab">
                            Posted Showings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_2" data-toggle="tab">
                            Accepted Showings
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Posted Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="posted_showings_list" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_default_2">
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Accepted Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="accepted_showings_list" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                </div>
            




            </div>
        </div>
    </div>
</div> -->
<!-- Change By Yogesh 16/08/16 -->
<?php   $userType =  Auth::user()->user_type?>

@if($userType == 1)

<div class="row">
    <div class="col-lg-12">
        @if (isset($errors) && (count($errors) > 0))
        <div class="alert alert-danger alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="tabbable-panel">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_default_1" data-toggle="tab">
                            My Postings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_2" data-toggle="tab">
                            My Showings
                        </a>
                    </li>
                    <!-- New tad by yogesh -->
                    <li>
                        <a href="#tab_default_3" data-toggle="tab">
                            Declined Showings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_4" data-toggle="tab">
                            Completed Showings
                        </a>
                    </li>
                    <!-- End new tab -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    My Postings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="posted_showings_list" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_default_2">
                        <br />
                        <div  class="panel panel-info new-reject_2">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    My Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="approved_showings_list_posted" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                    <!-- New data tab by yogesh -->
                    <div class="tab-pane" id="tab_default_3">
                        <br />
                        <div  class="panel panel-info new-reject_2">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Declined Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="rejected_showings_list_posted" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_default_4">
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Completed Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="completed_showings_list_posted" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>

                    <!-- End new tab -->
                </div>
            </div>
        </div>
    </div>
</div>
@endif 
@if($userType == 2)

<div class="row">
    <div class="col-lg-12">
        @if (isset($errors) && (count($errors) > 0))
        <div class="alert alert-danger alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="tabbable-panel">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                   <!--  <li class="active">
                        <a href="#tab_default_1" data-toggle="tab">
                            Posted Showings
                        </a>
                    </li> -->
                    <li class="active">
                        <a href="#tab_default_2" data-toggle="tab">
                            My Showings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_3" data-toggle="tab">
                            Declined Showings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_4" data-toggle="tab">
                            Completed Showings
                        </a>
                    </li>
                </ul>
                <div class="tab-content">

                   <div class="tab-pane active" id="tab_default_2">
                    <br />
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                My Showings
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table id="accepted_showings_list" class="table
                            table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_default_3">
                    <br />
                    <div class="panel panel-info new-reject_2">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                Declined Showings
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table id="rejected_showings_list_posted" class="table
                            table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_default_4">
                    <br />
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                Completed Showings
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table id="completed_showings_list_posted" class="table
                            table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@endif

@if($userType == 3)
<div class="row">
    <div class="col-lg-12">
        @if (isset($errors) && (count($errors) > 0))
        <div class="alert alert-danger alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="tabbable-panel">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_default_1" data-toggle="tab">
                            My Postings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_2" data-toggle="tab">
                            My Showings
                        </a>
                    </li>
                   <li>
                        <a href="#tab_default_3" data-toggle="tab">
                            Declined Showings
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_4" data-toggle="tab">
                            Completed Showings
                         </a>   
                    </li>
                    <li>
                        <a href="#tab_default_5" data-toggle="tab">
                            Completed Postings
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    My Postings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="posted_showings_list" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_default_2">
                        <br />
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    My Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="accepted_showings_list" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                       <div class="tab-pane" id="tab_default_3">
                        <br />
                        <div  class="panel panel-info new-reject_2">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Declined Showings
                                </h3>
                            </div>

                            <div class="panel-body">
                                <table id="rejected_showings_list_posted" class="table
                                table-striped table-bordered"></table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_default_4">
                    <br />
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                Completed Showings
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table id="completed_showings_list_posted" class="table
                            table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_default_5">
                    <br />
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                Completed Postings
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table id="completed_showings_list_both" class="table
                            table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endif

@endsection