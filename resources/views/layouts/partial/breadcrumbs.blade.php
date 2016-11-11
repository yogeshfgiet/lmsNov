<!-- Stored in resources/views/layouts/partial/breadcrumbs.blade.php -->
<?php $request_segments = Request::segments();?>
@if(!empty($request_segments))
        <!-- Icon Section Start -->
    <div class="icon-section">
        <div class="container">
            <ul class="list-inline text-white">
                <li>Home >>
                    @if(2 === count($request_segments))
                        {{ ucfirst($request_segments['1']) }}
                    @elseif(1 === count($request_segments))
                        {{ ucfirst($request_segments['0']) }}
                    @endif
                </li>
            </ul>
        </div>
    </div>
@endif