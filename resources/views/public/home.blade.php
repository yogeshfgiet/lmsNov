@extends('layouts.public')

@section('content')
<div class="content">
    <div class="home-slider text-center block-center">
        <img src="{{ asset('assets/img/home_main_bg.jpg') }}"
             class="main-slider-img img-responsive">

        <div class="home-slider-desc col-md-7 col-sm-7 col-xs-12 block-center">
            <h2 class="col-xs-12 col-sm-12 col-md-12">
                NEVER MISS A SHOWING
            </h2>

            <div class="col-xs-12 col-sm-12 col-md-12 block-center">
                <a class="btn btn-success btn-lg
                btn-responsive" href="{{ URL::to('auth/register') }}">sign
                    up</a>
            </div>

            <div class="clear col-xs-12 col-sm-12 col-md-12">
                Lorem ipsen desen of teh reasn dos toosen the reaned
                fires del teash tre klepsen ob detren. Trespen tre
                loren ipsum der treson shorfer tred lighten der
                tremble fro orten. Dos greten tre fluten highten.
            </div>
        </div>
    </div>

    <section class="purchas-main">
        <div class="container bg-border">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 right-border">
                    <span>
                        <h3 class="text-center text-green">
                            Connecting Realtors with Realtors
                        </h3>
                        <h4 class="text-center">
                            "It's like the UBER of Realtors"
                        </h4>
                    </span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="text-center">
                        Lorem ipsen desen of teh reasn dos toosen the reaned
                        fires del teash tre klepsen ob detren. Trespen tre
                        loren ipsum der treson shorfer tred lighten der
                        tremble fro orten. Dos greten tre fluten highten.
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="purchas-main instruction-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-10">
                    <h3>
                        How it Works
                    </h3>

                    <div class="media">
                        <div class="media-left media-top">
                            <img alt="image"
                                 src="{{ asset('assets/img/post-a-showing.jpg') }}"
                                 class="media-object">
                        </div>

                        <div class="media-body">
                            <h3 class="text-green">Post a Showing</h3>
                            <p class="media-heading">
                                Lorem ipsen desen of teh reasn dos toosen the
                                reaned fres del teash tre klepsen ob detren.
                                Trespen tre loren ipsum der treson shorfer
                                tred lighten der
                            </p>
                        </div>
                    </div>

                    <div class="media">
                        <div class="media-left media-top">
                            <img alt="image"
                                 src="{{ asset('assets/img/take-a-showing.jpg') }}"
                                 class="media-object">
                        </div>

                        <div class="media-body">
                            <h3 class="text-green">Take a Showing</h3>
                            <p class="media-heading">
                                Lorem ipsen desen of teh reasn dos toosen the
                                reaned fres del teash tre klepsen ob detren.
                                Trespen tre loren ipsum der treson shorfer
                                tred lighten der
                            </p>
                        </div>
                    </div>

                    <div class="media">
                        <div class="media-left media-top">
                            <img alt="image"
                                 src="{{ asset('assets/img/get-paid.jpg') }}"
                                 class="media-object">
                        </div>

                        <div class="media-body">
                            <h3 class="text-green">Get Paid</h3>
                            <p class="media-heading">
                                Lorem ipsen desen of teh reasn dos toosen the
                                reaned fres del teash tre klepsen ob detren.
                                Trespen tre loren ipsum der treson shorfer
                                tred lighten der
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span>
                        <img src="{{ asset('assets/img/lappy.jpg') }}"
                             class="instruction-img img-responsive">
                    </span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
