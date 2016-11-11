<!-- Stored in resources/views/user/moreinfo.blade.php -->
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Last Minute Showings</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/styles.css') }}">
        <!--end of page level css-->

        <!-- global js -->
        <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/holder-master/holder.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
        <!-- end of global js -->
    </head>

    <body class="skin-josh" data-backdrop="static" aria-hidden="true">
        <div class="loader" id="dv_loaderImage"></div>

        <?php
            $imgSrc = '';
            $fileName = Auth::user()->profile_photo;

            if (empty($fileName)) {
                $fileName = $tmpImg;
            }

            $tmpImgPath = url('uploads/user/tmp/' . $fileName . '?v=' . rand());
        ?>

        @if(isset($tmpImg) && !empty($tmpImg))
            <?php
            $imgSrc = $tmpImgPath;
            ?>
        @elseif(Auth::user()->profile_photo)
            <?php
            $imgSrc = url('uploads/user/' . Auth::user()->profile_photo . '?v=' . rand());
            ?>

            <script>
                changeProfileImage('<?php echo $imgSrc; ?>');
            </script>
        @endif

        {!! Form::open(
            array(
                'novalidate' => 'novalidate',
                'files' => true,
                'id' => 'frm_changeProfilePic',
                'url' => 'change-image'
            ))
        !!}
            <img {!! ($imgSrc) ? "src='$imgSrc'" : "data-src='holder.js/250x250/#ccc:#000'" !!} width="250" class="img-circle img-responsive" height="250" alt="pic" />

            <div class="col-lg-3 text-center">
                <a>Change Profile Picture</a>

                {!! Form::file('profile_photo', ['onchange' => 'uploadImageFile()']) !!}
            </div>

            @if(isset($tmpImg) && !empty($tmpImg))
                <div class="col-lg-3 text-center">
                    <a href="{{ url("save-image?img=" . $tmpImg) }}">Save Profile Picture</a>
                </div>
            @endif

        {!! Form::close() !!}
    </body>
</html>

