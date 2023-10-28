<!DOCTYPE html>
<html lang="en">

@include('back-end.pages2.head_shipper')

<body>

@include('back-end.pages2.header_shipper')

@include('back-end.pages2.sidebar_shipper')

{{--  @include('back-end.pages2.main')  --}}
<main id="main" class="main">

    @yield('breadcrumb')

    <section class="section dashboard">
        @yield('content')

    </section>

</main><!-- End #main -->


@include('back-end.pages2.footer')


</body>

</html>
