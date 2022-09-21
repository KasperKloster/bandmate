<!-- Footer -->
<footer class="grey darken-3 page-footer">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">BandMate</h5>
      </div>
      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Links</h5>
        <ul>
          <li><a class="grey-text text-lighten-3" href="{{ route('about') }}">Om BandMate</a></li>
          <li><a class="grey-text text-lighten-3" href="{{ route('privacy') }}">Privatlivspolitik</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="grey darken-4 footer-copyright">
    <div class="container">
    © {{ now()->year }}
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
<script src="{{ mix('js/main.js') }}"></script>
@yield('scripts')
</body>
</html>
