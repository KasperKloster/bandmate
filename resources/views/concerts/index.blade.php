@extends('layouts.main')

@section('title') Koncerter @isset($cityName) i {{$cityName}} @endisset i Dag @stop
@section('meta-description') @stop
@section('schema')
<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement":
 [
  {
   "@type": "ListItem",
   "position": 1,
   "item":
   {
    "@id": "{{ route('front') }}",
    "name": "Forside"
    }
  },
  {
   "@type": "ListItem",
  "position": 2,
  "item":
   {
     "@id": "{{ route('concerts.index') }}",
     "name": "Koncerter"
   }
  }
  @isset($cityName)
  ,
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "{{ url()->current() }}",
     "name": "{{ $cityName }}"
   }
  }
  @endisset
 ]
}
</script>
@stop

@section('content')

<!-- Content -->
<div class="row">
  <aside>
    <div class="col s12 m4 l3">
      <ul class="collection with-header">
        <li class="collection-header"><h4>By</h4></li>
          <a href="{{ route('concerts.index') }}" class="collection-item">Hele Landet <i class="material-icons float-right">keyboard_arrow_right</i></a>
          @foreach($citiesAndGenres['cities'] as $city)
          <a href="{{ route('concerts.index', $city) }}" class="collection-item">{{ $city }} <i class="material-icons float-right">keyboard_arrow_right</i></a>
          @endforeach
      </ul>
    </div>
  </aside>

  <div class="col s12 m8 l9 border-left content">
    <header>
      <div class="row">
        <div class="col s12">
          <!-- breadcrumb -->
          <nav class="transparent no-shadow">
            <div class="nav-wrapper">
              <a href="{{ route('front') }}" class="breadcrumb">Forside</a>
              @isset($cityName)
              <a href="{{ route('concerts.index')}}" class="breadcrumb">Koncerter</a>
              <a href="#" class="breadcrumb-current" aria-current="page">{{ $cityName }}</a>
              @else
              <a href="#" class="breadcrumb-current" aria-current="page">Koncerter</a>
              @endisset
            </div>
          </nav>
        </div>
      </div>
      <div class="row">
        <h1 class="d-inline">Koncerter i @isset($cityName) {{$cityName}} @else Hele Danmark @endisset</h1>
        @isset($cityName)
        <h2>Live musik i {{$cityName}} i dag</h2>
        <p>Live koncerter du kan tage til i dag i {{$cityName}}</p>
        @endisset
      </div>
    </header>

    <main>
      <div class="row">
        @for($i = 0; $i < count($events); $i++)
          @if($i % 3 == 0)
          </div>
          <div class="row">
          @endif
        <div class="col s12 m6 l4">
          <div class="card hoverable">
            <div class="card-image">
              <a href="{{ route('concert.single.get', $events[$i]['id']) }}">
                <img src="{{ $events[$i]['images'][0]['url'] }}" alt="{{ $events[$i]['name'] }}">
              </a>
              <a href="{{ route('concert.single.get', $events[$i]['id']) }}" class="btn-floating halfway-fab waves-effect waves-light orange darken-3"><i class="material-icons">add</i></a>
            </div>
            <div class="card-content">
              <a href="{{ route('concert.single.get', $events[$i]['id']) }}" class="card-title">{{ $events[$i]['name'] }}</a>
              <hr/>
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
            </div>
            <div class="card-action">
              @if($events[$i]['dates']['status']['code'] != 'cancelled')
              <a href="{{ $events[$i]['url'] }}" target="_blank" rel="noopener" class="btn light-blue darken-1 waves-effect waves-light">Køb Billet</a>
              @else
              <a class="btn waves-effect waves-light red darken-2">Aflyst</a>
              @endif
            </div>
          </div>
        </div>
        @endfor
      </div>
    </main>
  </div>
</div>
@stop
