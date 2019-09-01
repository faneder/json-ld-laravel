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
		$context = 'http://schema.org';
		$type	 = 'WebSite';
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
		$context = 'http://schema.org';
		$type	 = 'Organization';
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

	private function contactPointJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'ContactPoint';
		$data    = [
			"telephone" => config('companyInfo.contactPoint.telephone'),
    		"contactType" => config('companyInfo.contactPoint.contactType'),
    		"contactOption" => config('companyInfo.contactPoint.contactOption'),
    		"areaServed" => config('companyInfo.contactPoint.areaServed'),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	private function contactPointEmbedded()
	{
		$JsonLd = $this->contactPointJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}

	public function contactPoint()
	{
		$JsonLd = $this->contactPointJsonLd();
		$script = $JsonLd->getScriptJsonLd();
		return $script;
	}

	private function organizationJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'Organization';
		$data    = [
			'url' => $this->companyUrl,
    		"name" => config('companyInfo.name'),
			'logo' => config('companyInfo.logo'),
			'sameAs' => config('companyInfo.socialProfile'),
			"contactPoint" => $this->contactPointEmbedded(),
			"employee" => $this->personEmbedded(),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	private function organizationEmbedded()
	{
		$JsonLd = $this->organizationJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}

	public function organization()
	{
		$JsonLd = $this->organizationJsonLd();
		$script = $JsonLd->getScriptJsonLd();
		return $script;
	}

	public function jobPostingJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'JobPosting';
		$data    = [
			// Google mandatory
			"datePosted" => config('jobPosting.datePosted'),
			"description" => config('jobPosting.description'),
			"hiringOrganization" => $this->organizationEmbedded(),
    		"jobLocation" => $this->placeEmbedded(),
			"title" => config('jobPosting.title'),
			"validThrough" => config('jobPosting.validThrough'),
			// Google recommended
			"baseSalary" => $this->monetaryAmountEmbedded(),
			"employmentType" => ["FULL_TIME","PART_TIME","CONTRACTOR","TEMPORARY","INTERN","VOLUNTEER","PER_DIEM","OTHER"],
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	public function jobPosting()
	{
		$JsonLd = $this->jobPostingJsonLd();
		$script = $JsonLd->getScriptJsonLd();
		return $script;
	}

	private function postalAddressJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'PostalAddress';
		$data    = [
			"streetAddress" => config('postalAddress.streetAddress'),
			"addressLocality" => config('postalAddress.addressLocality'),
			"addressRegion" => config('postalAddress.addressRegion'),
			"postalCode" => config('postalAddress.postalCode'),
			"addressCountry" => config('postalAddress.addressCountry'),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);		

		return $JsonLd;
	}

	private function postalAddressEmbedded()
	{
		$JsonLd = $this->postalAddressJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}

	private function placeJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'Place';
		$data    = [
			"address" => $this->postalAddressEmbedded(),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	private function placeEmbedded()
	{
		$JsonLd = $this->placeJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}

	private function personJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'Person';
		$data    = [
			"givenName" => config('companyInfo.employee.givenName'),
			"additionalName" => config('companyInfo.employee.additionalName'),
			"familyName" => config('companyInfo.employee.familyName'),
			"email" => config('companyInfo.employee.email'),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	private function personEmbedded()
	{
		$JsonLd = $this->personJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}

	private function quantitativeValueJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'QuantitativeValue';
		$data    = [
			"value" => config('quantitativeValue.value'),
			"unitText" => config('quantitativeValue.unitText'),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	private function quantitativeValueEmbedded()
	{
		$JsonLd = $this->quantitativeValueJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}

	private function monetaryAmountJsonLd()
	{
		$context = 'http://schema.org';
		$type	 = 'MonetaryAmount';
		$data    = [
			"currency" => config('monetaryAmount.currency'),
			"value" => $this->quantitativeValueEmbedded(),
		];

		$JsonLd = $this->jsonLd
					->context($context)
					->type($type)
					->data($data);

		return $JsonLd;
	}

	private function monetaryAmountEmbedded()
	{
		$JsonLd = $this->monetaryAmountJsonLd();
		return $JsonLd->getEmbededJsonLd();
	}
}
