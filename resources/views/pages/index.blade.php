@extends('layouts.main')

@section('title') Koncerter i Dag @stop
@section('meta-description')Koncerter i Dag @stop

@section('content')
<!-- Header -->
<header>
  <section class="grey darken-3 z-depth-1" id="front-top-section">
    <div class="container">
      <div class="row white-text">
        <div class="col s12">
          <div class="caption center-align">
            <h1>Bandmate</h1>
            <h2 class="light">Koncerter i dag</h2>
            <p>Live musik i hele landet</p>
          </div>
        </div>
      </div>
      <!-- Search -->
      <div class="row">
        <div class="col s8 offset-s2">
            <div class="input-field col s10">
              <input id="frontSearch" type="text" class="white grey-text front-input" placeholder="Søg efter koncert">
            </div>
            <div class="input-field col s2">
              <button class="btn btn-large light-blue darken-1 waves-effect waves-light" type="submit" name="action">Go!</button>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col s8 offset-s2">
          <div id="matchList"></div>
        </div>
      </div>
    </div>
  </section>
</header>

<!-- Content -->
<main>
  <section>
    <div class="container">
      <div class="row">
        <h3>Koncerter i dag</h3>
      </div>
      <div class="row">
        <div class="float-right">
          <a href="{{ route('concerts.index') }}" class="d-inline-flex waves-effect waves-teal btn-flat">Se Alle {{ count($events) }} Koncerter<i class="material-icons">arrow_forward</i></a>
        </div>
      </div>
      <hr/>
      <div class="row">
        @for($i = 0; $i < count($events); $i++)
      @if($i % 3 == 0)
      </div>
      <div class="row">
      @endif

        <div class="col s12 m6 l4">
          <div class="card sticky-action hoverable">
            <div class="card-image waves-effect waves-block waves-light">
              <img class="activator" src="{{ $events[$i]['images'][0]['url'] }}" alt="{{ $events[$i]['name'] }}">
            </div>
            <div class="card-content">
              <span class="card-title grey-text text-darken-4">
                <a href="{{ route('concert.single.get', $events[$i]['id']) }}">{{ $events[$i]['name'] }}</a>
              </span>
              <span class="card-title activator grey-text text-darken-4"><i class="material-icons right">keyboard_arrow_up</i></span>
            </div>
            <div class="card-action d-inline-flex">
              <a href="{{ route('concert.single.get', $events[$i]['id']) }}" class="orange-text darken-3">Læs Mere</a>
              <a href="{{ $events[$i]['url'] }}" target="_blank" rel="noopener" class="btn btn-small light-blue darken-1 waves-effect waves-light">Køb Billet</a>
            </div>
            <div class="card-reveal">
              <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i>{{ $events[$i]['name'] }}</span>
              <p>
                @isset($events[$i]['dates']['start']['localTime'])
                <div class="d-inline-flex">
                  <i class="material-icons">access_time</i>{{ $events[$i]['dates']['start']['localTime'] }}
                </div>
                <br/>
                @endisset
                <div class="d-inline-flex">
                  <i class="material-icons">location_on</i>{{ $events[$i]['_embedded']['venues'][0]['name'] }},
                  @foreach($events[$i]['_embedded']['venues'][0]['city'] as $city)
                    {{ $city }}
                  @endforeach
                </div>
              </p>
            </div>
          </div>
        </div>
        @if($i == 5)
          @break
        @endif
        @endfor
      </div>
    </div>
  </section>
</main>
@endsection

@section('scripts')
<script nonce="{{ csp_nonce() }}">
const frontSearch = document.getElementById('frontSearch');
const matchList = document.getElementById('matchList');
// Search response and filter
const searchResults = async searchText => {
  const response = await fetch('/json/response');
  const results = await response.json();

  // Only Name
  let matches = results._embedded.events.filter(result => {
    // Regular expression, only match beginning from search text (case insensitive)
    const regex = new RegExp(`^${searchText}`, 'gi');
    return result.name.match(regex);
  });

  // Don't return all, if users delete text
  if(searchText.length == 0)
  {
    matches = [];
    matchList.innerHTML = '';
  }
  // console.log(matches);
  outputHtml(matches);
};

const outputHtml = matches => {
  if(matches.length > 0){
    // baseUrl = ;
    // console.log();

    const html = matches

      .map(
        match => `
        <div class="card">
          <div class="card-content">
           <span class="card-title"><a href="${'/koncert/' + match.id}">${match.name}. </a></span>
          </div>
        </div>
        `).join('');

    matchList.innerHTML = html;
  }

}

frontSearch.addEventListener('input', () => searchResults(frontSearch.value));

</script>
@stop
