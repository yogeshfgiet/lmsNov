<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/css/jquery.ui.theme.css',
    '/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css',
    )) !!}
    @endsection
    <!-- Page level CSS files -->

    <!-- Page level JS files -->
    @section('footer_scripts')
    {!! Minify::javascript(array(
    '/assets/vendors/modal/js/classie.js',
    '/assets/vendors/modal/js/modalEffects.js',
    '/assets/js/user/showings.js'
    )) !!}
    @endsection
    <!-- Page level JS files -->

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">×</button>
                <h4 class="modal-title">Showing Detail</h4>
            </div>
            <div class="modal-body" id="dv_modalShowing">
                <h4 class="text-green">
                    <u>Basic Details</u>
                </h4>

                <div>

                    <strong>Posted Date:</strong>
                    {{  date('m-d-Y', strtotime($getDetails[0]->post_date)) }}
                </div>
                <div>

                    <strong>Start Time:</strong>
                    {{   date('m-d-Y h:i A', strtotime($getDetails[0]->start_time))}}

                </div>
                <div>
                    <strong>End Time:</strong>
                    {{   date('m-d-Y h:i A', strtotime($getDetails[0]->end_time))}}

                </div>
                <div>
                    <strong>Expiration Time:</strong>

                    {{   date('m-d-Y h:i A', strtotime($getDetails[0]->expiration_time))}}

                </div>

                 <?php   $userType =  Auth::user()->user_type?>
                @if($userType==1)
            <h4 class="text-green">
                <u>Customer Details</u>
            </h4>
            <div>
                    <strong>Name:</strong>
                    {{ $getDetails[0]->customer_name }}
              <div>
              </div>
                    <strong>Email Address:</strong>
                    {{ $getDetails[0]->customer_email }}
               <div>
              </div>
                    <strong>Phone Number:</strong>
                    {{ $getDetails[0]->customer_phone_number }}
                <div>
              </div>
                    <strong>Comments:</strong>
                    {{ $getDetails[0]->comments }}
                </li>
            </div>
          
            @endif

        <br/>
        <h4 class="text-green">
            <u>House Details</u>
        </h4>

        @foreach($getDetails as $key => $house)
        <div class="house-details">
            <h5 class="text-green">
                <u>House #{{ $key + 1 }}</u>
            </h5>

            <span>
                <li>
                    <strong>Address:</strong>
                    {{ $house->address }}
                </li>
                         <!--  <li>
                            <strong>City:</strong>
                            {{ $house->city }}
                        </li>
                          <li>
                            <strong>State:</strong>
                            {{ $states[$house->state] }}
                        </li>
                          <li>
                            <strong>Zip:</strong>
                            {{ $house->zip }}
                        </li> -->
                        <li>
                            <strong>List Price:</strong>
                            {{ $house->list_price }}
                        </li>
                        <li>
                            <strong>MLS Number:</strong>
                            {{ $house->MLS_number }}
                        </li>
                    </span>
                </div>
                @endforeach
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" type="button">Close</button>

                @if($userType == 1)
                <button style="display:none" class="btn btn-primary" type="button"
                onclick="">Accept</button>
                @else
                <button id="fat-btn" class="btn btn-primary" type="button" data-loading-text="Accepting..."
                onclick="acceptShowing('{{ $getDetails[0]->id }}')">Accept</button>
                @endif
           <!--  <button class="btn btn-primary" type="button"
           onclick="acceptShowing('{{ $getDetails[0]->id }}')">Accept</button> -->
       </div>
   </div>
</div>