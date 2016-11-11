<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/css/jquery.ui.theme.css'
)) !!}
@endsection
        <!-- Page level CSS files -->

<!-- Page level JS files -->
@section('footer_scripts')
    {!! Minify::javascript(array(
        '/assets/vendors/modal/js/classie.js',
        '/assets/vendors/modal/js/modalEffects.js',
    )) !!}
@endsection
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
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">×</button>
            <h4 class="modal-title">Feedback</h4>
        </div>
        <div class="modal-body" id="dv_modalBlock">
           

        
            <fieldset>
            
               
              
                <div class="form-group">
                    {!! Form::label(
                        'comments',
                        'Comments ',
                        ['class' => 'col-md-4 control-label']
                    )!!}

                    <div class="col-md-6">
                        {!! Form::textarea(
                            'feedback_comment',
                            null,
                            array('class' => 'form-control', 'rows' => '4')
                        ) !!}
                    </div>
                </div>
            </fieldset>
            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button"
                onclick="feedbackShowing()
                        ">Submit</button>
        </div>
    </div>
</div>