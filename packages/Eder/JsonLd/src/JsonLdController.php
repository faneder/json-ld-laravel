<?php

namespace Eder\JsonLd;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class JsonLdController extends Controller
{
	// protected $jsonLd;
	protected $companyUrl;

	public function __construct()
	{
		$this->jsonLd = new JsonLd;
		$this->companyUrl = config('companyInfo.url');
	}

	public function siteLinksSearchBox()
	{
		$context = ['@context' => 'http://schema.org'];
		$type	 = ['@type' => 'WebSite'];
		$data    = [
			'url' => $this->companyUrl,
		  	'potentialAction' => [
			    '@type' 	  => 'SearchAction',
			    'target'	  => 'https://www.bookmarc.com.au/au/search/{search_term_string}',
			    'query-input' => 'required name=search_term_string'
			]
		];

		$script = $this->jsonLd
					->context($context)
					->type($type)
					->data($data)
					->getScriptJsonLd();

		return $script;
	}

	public function socialProfile()
	{
		$context = ['@context' => 'http://schema.org'];
		$type	 = ['@type' => 'Organization'];
		$data    = [
			'url' => $this->companyUrl,
		  	'sameAs' => config('companyInfo.socialProfile')
		];

		$script = $this->jsonLd
					->context($context)
					->type($type)
					->data($data)
					->getScriptJsonLd();

		return $script;
	}
}
