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
<script>
    var showingsData = <?php echo json_encode($showings)?>;
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSV9YEV0U9LaWttfpMTAESr_eqpOxiiGs"></script>
{!! Minify::javascript(array(
    '/assets/vendors/datatables/jquery.dataTables.min.js',
    '/assets/vendors/datatables/dataTables.colReorder.min.js',
    '/assets/vendors/datatables/dataTables.bootstrap.js',
    '/assets/js/user/showings.js',
    '/assets/js/markerclusterer.js',
    '/assets/js/infobox.js',
    '/assets/js/user/showing_map.js',
)) !!}
@endsection

@section('section-content')


<div class="row">
    <div class="col-lg-12">
        <div class="tabbable-panel">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_default_1" data-toggle="tab">
                            Map View
                        </a>
                    </li>
                    <li>
                        <a href="#tab_default_2" data-toggle="tab">
                            List View
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">
                        <br />
                        <div id="showings_map"></div>
                        <br />
                    </div>
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
@endsection