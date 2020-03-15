<!-- Navbar -->
<nav class="grey darken-3">
  <div class="nav-wrapper">
    <div class="container">
    <a href="{{ route('front') }}" class="brand-logo center">BandMate</a>
    <ul class="left hide-on-med-and-down">
      <li><a href="{{ route('concerts.index') }}">Koncerter</a></li>
    </ul>
    </div>

    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
    <!-- Mobile Sidenav -->
    <ul class="side-nav" id="mobile-demo">
      <li><a href="{{ route('concerts.index') }}">Koncerter</a></li>
    </ul>
  </div>
</nav>
