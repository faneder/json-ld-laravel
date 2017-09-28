<?php

Route::group(
    [
        'namespace' => 'Eder\JsonLd',
        'prefix' => 'google/search/',
        'group' => 'google.search',
        'as' => 'google.search.'
    ],
    function ()
    {
		Route::get('sitesearch', 'JsonLdController@siteLinksSearchBox');
		Route::get('social/profile', 'JsonLdController@socialProfile');
    }
);

