@extends('layouts.main')

@section('style')
<script src="https://kit.fontawesome.com/7ce8ceee96.js" crossorigin="anonymous"></script>
@stop

@section('title') {{ $events['name'] }}, {{ $events['_embedded']['venues'][0]['name'] }} @stop
@section('meta-description') Billetter til {{ $events['name'] }}, {{ $events['_embedded']['venues'][0]['name'] }}.  {{ $events['dates']['start']['localDate'] }}. @stop
@section('schema')
<style nonce="{{ csp_nonce() }}">
.header-bg{
  background-image: url({{ $events['images'][0]['url']}});
}
</style>

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
  },
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "{{ route('concerts.index', $events['_embedded']['venues'][0]['city']['name']) }}",
     "name": "{{ $events['_embedded']['venues'][0]['city']['name'] }}"
   }
  },
  {
   "@type": "ListItem",
  "position": 4,
  "item":
   {
     "@id": "{{ url()->current() }}",
     "name": "{{ $events['name'] }}"
   }
  }
 ]
}
</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Event",
  "location": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "{{ $events['_embedded']['venues'][0]['city']['name'] }}",
      "addressRegion": "DK",
      "postalCode": "{{ $events['_embedded']['venues'][0]['postalCode'] }}",
      "streetAddress": "{{ $events['_embedded']['venues'][0]['address']['line1'] }}"
    },
    "name": "{{ $events['_embedded']['venues'][0]['name'] }}"
  },
  "name": "{{ $events['name'] }}",
  "performer": "{{ $events['_embedded']['attractions'][0]['name'] }}",
  "description": "{{ $events['_embedded']['attractions'][0]['name'] }} spiller i {{ $events['_embedded']['venues'][0]['city']['name'] }}, {{ $events['_embedded']['venues'][0]['name'] }}.",
  "image": "{{ $events['images'][0]['url']}}",
  "offers": {
    "@type": "Offer",
    "availability": @if($events['dates']['status']['code'] != 'cancelled') "http://schema.org/InStock", @else "http://schema.org/Discontinued", @endif
    @if(!empty($events['priceRanges']))
    "price": "{{ $events['priceRanges'][0]['min'] }}",
    "priceCurrency": "{{ $events['priceRanges'][0]['currency'] }}",
    @endif
    "url": "{{ $events['url'] }}"
  }
  @isset($events['dates']['start']['localTime'])
  , "startDate": "{{ $events['dates']['start']['localDate'] }}T{{ $events['dates']['start']['localTime'] }}"
  @endisset
}
</script>

@stop

@section('content')
<section>
  <header>
    <nav class="nav-extended grey darken-4">
      <div class="nav-wrapper">
        <div class="container">
          <div class="col s12">
            <a href="{{ route('front') }}" class="breadcrumb">Forside</a>
            <a href="{{ route('concerts.index') }}" class="breadcrumb">Koncerter</a>
            <a href="{{ route('concerts.index', $events['_embedded']['venues'][0]['city']['name']) }}" class="breadcrumb">{{ $events['_embedded']['venues'][0]['city']['name'] }}</a>
            <a class="breadcrumb-current" aria-current="page">{{ $events['name'] }}</a>
            <div class="float-right">
              @if($events['dates']['status']['code'] != 'cancelled')
              <a class="btn waves-effect waves-light light-blue darken-1" href="{{ $events['url'] }}" target="_blank" rel="noopener">Køb Billet</a>
              @else
              <a class="btn waves-effect waves-light red darken-2">Aflyst</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div id="headerImg" class="grey darken-3 z-depth-1 header-bg">
      <div class="container">
        <h1>{{ $events['name'] }}, <br/><small>{{ $events['_embedded']['venues'][0]['name'] }}</small></h1>
        <div class="row">
          <div id="sub-header" class="grey lighten-5 z-depth-1">
            <div class="col s4">
              <b><i class="material-icons">calendar_today</i>Dato / Tidspunkt</b>
              <p>
              {{ $events['dates']['start']['localDate'] }} @isset($events['dates']['start']['localTime']), {{ $events['dates']['start']['localTime'] }}@endisset
              </p>
            </div>
            <div class="col s4 border-lr">
              <b><i class="material-icons">location_on</i>Spillested</b>
              <address>
              {{ $events['_embedded']['venues'][0]['name'] }}
              <br/>
              <em>{{ $events['_embedded']['venues'][0]['address']['line1'] }}, {{ $events['_embedded']['venues'][0]['postalCode'] }} {{ $events['_embedded']['venues'][0]['city']['name'] }}</em>
              </address>
            </div>
            @if(!empty($events['priceRanges']))
            <div class="col s4">
              <b><i class="material-icons">attach_money</i>{{ $events['priceRanges'][0]['type'] }}</b>
              <p>
              {{ $events['priceRanges'][0]['min'] }} - {{ $events['priceRanges'][0]['max'] }}{{ $events['priceRanges'][0]['currency'] }}
              </p>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </header>
</section>

  <main>
    <section id="single-content">
      <div class="container">
        <div class="row">
          <div class="col s7 l7 card">
            <div class="card-content">
              <article>
                <h2 class="card-title">Billetter til {{ $events['name'] }}</h2>
                <p>
                  {{ $events['_embedded']['attractions'][0]['name'] }} spiller i {{ $events['_embedded']['venues'][0]['city']['name'] }}, {{ $events['_embedded']['venues'][0]['name'] }}.
                </p>
                <article>
            </div>
          </div>

          <aside>
            <div class="col s4 offset-s1 l4 offset-l1 card">
              <div class="card-content">
                <ul class="collection with-header">
                  <li class="collection-header"><h6>Eksterne Links</h6></li>
                    @if(isset($events['_embedded']['attractions'][0]['externalLinks']['youtube'][0]['url']))
                    <li class="collection-item">
                      <a href="{{ $events['_embedded']['attractions'][0]['externalLinks']['youtube'][0]['url'] }}" target="_blank" rel="noopener">
                        <i class="fab fa-youtube"></i> {{ $events['_embedded']['attractions'][0]['externalLinks']['youtube'][0]['url'] }}
                      </a>
                    </li>
                    @endif
                    @if(isset($events['_embedded']['attractions'][0]['externalLinks']['twitter'][0]['url']))
                    <li class="collection-item">
                      <a href="{{ $events['_embedded']['attractions'][0]['externalLinks']['twitter'][0]['url'] }}" target="_blank" rel="noopener">
                        <i class="fab fa-twitter"></i> {{ $events['_embedded']['attractions'][0]['externalLinks']['twitter'][0]['url'] }}
                      </a>
                    </li>
                    @endif
                    @if(isset($events['_embedded']['attractions'][0]['externalLinks']['wiki'][0]['url']))
                    <li class="collection-item">
                      <a href="{{ $events['_embedded']['attractions'][0]['externalLinks']['wiki'][0]['url'] }}" target="_blank" rel="noopener">
                        <i class="fab fa-wikipedia-w"></i> {{ $events['_embedded']['attractions'][0]['externalLinks']['wiki'][0]['url'] }}
                      </a>
                    </li>
                    @endif
                    @if(isset($events['_embedded']['attractions'][0]['externalLinks']['homepage'][0]['url']))
                    <li class="collection-item">
                      <a href="{{ $events['_embedded']['attractions'][0]['externalLinks']['homepage'][0]['url'] }}" target="_blank" rel="noopener">
                        <i class="fas fa-link"></i>
                        {{ $events['_embedded']['attractions'][0]['externalLinks']['homepage'][0]['url'] }}
                      </a>
                    </li>
                    @endif
                  </ul>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>
  </main>
@stop
