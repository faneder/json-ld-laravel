<?php

namespace Eder\JsonLd;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class JsonLdController extends Controller
{
	public function siteLinksSearchBox()
	{
		$jsonLd = new JsonLd;

		$context = ['@context' => 'http://schema.org'];
		$type	 = ['@type' => 'WebSite'];
		$data    = [
			'url' => 'https://www.bookmarc.com.au',
		  	'potentialAction' => [
			    '@type' 	  => 'SearchAction',
			    'target'	  => 'https://www.bookmarc.com.au/au/search/{search_term_string}',
			    'query-input' => 'required name=search_term_string'
			]
		];

		$script = $jsonLd
					->context($context)
					->type($type)
					->data($data)
					->getScriptJsonLd();

		return $script;
	}
}
