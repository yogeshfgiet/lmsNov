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
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">×</button>
            <h4 class="modal-title">Feedback</h4>
        </div>
        <div class="modal-body" id="dv_modalShowing">
            {!! Form::open(
                array(
                    'novalidate' => 'novalidate',
                    'method' => 'POST',
                    'url' => 'showings/feedback',
                    'class' => 'form-horizontal',
                    'width' => '100%',
                    'autocomplete' => 'off',
                    'id' => 'frm_feedbackForm',
                ))
            !!}

            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{$getParams['id']}}"/>
            <fieldset>
                <div class="form-group">
                    {!! Form::label(
                        'client_show_up',
                        'Did the client show up?',
                        ['class' => 'col-md-4 control-label']
                    )!!}

                    <div class="col-md-6">
                        {!! Form::select(
                            'client_show_up',
                            [
                                1 => ' Yes ',
                                0 => ' No '
                            ], 1,
                            ['class' => 'form-control']
                        )!!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label(
                        'submit_offer',
                        'Does the client want to submit an offer ?',
                        ['class' => 'col-md-4 control-label']
                    )!!}

                    <div class="col-md-6">
                        {!! Form::select(
                            'client_submit_offer',
                            [
                                1 => ' Yes ',
                                0 => ' No ',
                                2 => ' May be '
                            ], 1,
                            ['class' => 'form-control']
                        )!!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label(
                        'further_questions',
                        'Does the client have further questions ?',
                        ['class' => 'col-md-4 control-label']
                    )!!}

                    <div class="col-md-6">
                        {!! Form::select(
                            'client_question',
                            [
                                1 => ' Yes ',
                                0 => ' No '
                            ], 1,
                            ['class' => 'form-control']
                        )!!}
                    </div>
                </div>
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
                onclick="feedbackShowing('{{$getParams['id']}}')
                        ">Submit</button>
        </div>
    </div>
</div>