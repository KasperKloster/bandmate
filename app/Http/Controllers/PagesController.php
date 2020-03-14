<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{
  public function index()
  {
    // TM Api
    $response = Http::get('https://app.ticketmaster.com/discovery/v2/events', [
      'apikey'             => env('TICKETMASTER_API'),
      'locale'             => '*',
      'startDateTime'      => date("Y-m-d") . 'T00:00:00Z',
      'endDateTime'        => date("Y-m-d") . 'T23:59:00Z',
      'countryCode'        => 'DK',
      'classificationName' => 'music',
    ])->json();
    // Events
    $events = $response['_embedded']['events'];

    return view('pages.index')->with('events', $events);
  }

  public function getAbout()
  {
    return view('pages.about');
  }

  public function getPrivacyPolicy()
  {
    return view('pages.privacy');
  }

  public function getConcerts($city = NULL)
  {
    $response = Http::get('https://app.ticketmaster.com/discovery/v2/events', [
      'apikey'             => env('TICKETMASTER_API'),
      'locale'             => '*',
      'startDateTime'      => date("Y-m-d") . 'T00:00:00Z',
      'endDateTime'        => date("Y-m-d") . 'T23:59:00Z',
      'countryCode'        => 'DK',
      'classificationName' => 'music',
      'city'               => $city != NULL ? $city : '',
    ])->json();

    // If no events, redirect to concerts.index
    if(empty($response['_embedded']['events']) && $response->ok() == FALSE)
    {
      return redirect()->route('concerts.index');
    }
    // Events
    $events = $response['_embedded']['events'];
    // Cities And Genres
    $citiesAndGenres = $this->TmCitiesAndGenres();
    // If City is Set (In URL)
    if ($city != NULL) {
      $cityName = urldecode($city);
    }

    // View
    return view('concerts.index')
    ->with('events', $events)
    ->with('citiesAndGenres', $citiesAndGenres)
    ->with('cityName', $city);
  }

  public function getSingleConcert($concert)
  {
    $response = Http::get('https://app.ticketmaster.com//discovery/v2/events/' . $concert . '', [
      'apikey'  => env('TICKETMASTER_API'),
      'locale'  => 'da-dk',
    ]);

    if($response->ok() == TRUE)
    {
      $events = $response->json();
      return view('concerts.single')->with('events', $events);
    }
    else
    {
      return redirect()->route('concerts.index');
    }
  }

  public function responseJson()
  {
    $response = Http::get('https://app.ticketmaster.com/discovery/v2/events', [
      'apikey'             => env('TICKETMASTER_API'),
      'locale'             => '*',
      'startDateTime'      => date("Y-m-d") . 'T00:00:00Z',
      'endDateTime'        => date("Y-m-d") . 'T23:59:00Z',
      'countryCode'        => 'DK',
      'classificationName' => 'music',
    ]);
    return $response;
  }

  private function TmCitiesAndGenres()
  {
    $response = Http::get('https://app.ticketmaster.com/discovery/v2/events', [
      'apikey'             => env('TICKETMASTER_API'),
      'locale'             => '*',
      'startDateTime'      => date("Y-m-d") . 'T00:00:00Z',
      'endDateTime'        => date("Y-m-d") . 'T23:59:00Z',
      'countryCode'        => 'DK',
      'classificationName' => 'music',
    ])->json();

    $allCities = [];
    $allGenres = [];
    foreach($response['_embedded']['events'] as $events)
    {
      // Cities
      foreach ($events['_embedded']['venues'] as $venues)
      {
        // Populate Cities Array
        $allCities[] = $venues['city']['name'];
      }
      // Genres
      foreach($events['classifications'] as $genre)
      {
        $allGenres[] = [
          'id' => $genre['genre']['id'],
          'name' =>  $genre['genre']['name']
        ];
      }
    }
    // Remove Duplicates
    $cities = array_unique($allCities);
    $genres = array_unique($allGenres, SORT_REGULAR);

    return ['cities' => $cities, 'genres' => $genres];
  }


}
