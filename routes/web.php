<?php

Route::get('/', 'PagesController@index')->name('front');
Route::get('/json/response', 'PagesController@responseJson')->name('json.response');

Route::get('om-bandmate', 'PagesController@getAbout')->name('about');
Route::get('privatlivspolitik', 'PagesController@getPrivacyPolicy')->name('privacy');
Route::get('koncerter/{city?}', 'PagesController@getConcerts')->name('concerts.index');
Route::get('koncert/{concert}', 'PagesController@getSingleConcert')->name('concert.single.get');

Route::group([
	'prefix'	=> 'sitemap'
], function() {
	Route::get('/', 'GoogleSitemapController@index');
  Route::get('/pages', 'GoogleSitemapController@pages');
});
