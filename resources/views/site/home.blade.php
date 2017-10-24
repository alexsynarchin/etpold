@extends('site.layout.base')
@section('content')
    @include('site.main-page.main-page-utp')
    @include('site.main-page.rates')
@stop
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".main-page-utp").backgroundCycle({
                imageUrls: [
                    "{{URL::asset('assets/site/images/slider/image1.jpg')}}",
                    "{{URL::asset('assets/site/images/slider/image2.jpg')}}",
                    "{{URL::asset('assets/site/images/slider/image3.jpg')}}"
                ],
                fadeSpeed: 2000,
                duration: 5000,
                backgroundSize: SCALING_MODE_COVER
            });
        });
    </script>
@stop