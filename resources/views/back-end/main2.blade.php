<!DOCTYPE html>
<html lang="en">

@include('back-end.pages2.head')

<body>

    @include('back-end.pages2.header')

    @include('back-end.pages2.sidebar')

    {{--  @include('back-end.pages2.main')  --}}
    <main id="main" class="main">

        <div class="pagetitle">
          <h1>Dashboard</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            @yield('content')

        </section>

      </main><!-- End #main -->


    @include('back-end.pages2.footer')


</body>

</html>
