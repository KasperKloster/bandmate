<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{
  public function index()
  {
    $response = $this->TmResponse();
    // Events
    $events = $response['_embedded']['events'];
    // View
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
    $response = $this->TmResponse($city);

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
      'locale'  => '*',
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
    $response = $this->TmResponse();
    // Creating our array, with values we want to return
    foreach($response['_embedded']['events'] as $events)
    {      
      $return[] =
      [
          'id'    => $events['id'],
          'name'  => $events['name'],
          'venue' => $events['_embedded']['venues'][0]['name'],
          'city'  => $events['_embedded']['venues'][0]['city']['name'],
          'image' => $events['images'][0]['url']
      ];
    }
    return $return;
  }

  private function TmCitiesAndGenres()
  {
    $response = $this->TmResponse();

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

  private function TmResponse($city = NULL)
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

    return $response;
  }


}
