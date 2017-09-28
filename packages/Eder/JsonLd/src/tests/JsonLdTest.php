<?php

// namespace Tests\Unit;
namespace Eder\JsonLd\Tests;

use Tests\TestCase;
use Eder\JsonLd\JsonLd;

class JsonLdTest extends TestCase
{
	public function testSiteLinksSearchBoxApi()
	{
  		$response = $this->get('/google/search/social/profile');

        $response->assertStatus(200);
	}

	public function testSocialProfileApi()
	{
  		$response = $this->get('/google/search/social/profile');

        $response->assertStatus(200);
	}

    /**
     * A social profile
     *
     * @return void
     */
    public function testSiteLinksSearchBox()
    {
        $jsonLd = new JsonLd;

 		$context = ['@context' => 'http://schema.org'];
        $type    = ['@type' => 'WebSite'];
        $data    = [
            'url' => 'https://www.bookmarc.com.au',
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => 'https://www.bookmarc.com.au/au/search/{search_term_string}',
                'query-input' => 'required name=search_term_string'
            ]
        ];

        $actual = $jsonLd
                    ->context($context)
                    ->type($type)
                    ->data($data)
                    ->getScriptJsonLd(false);

		$actual = json_decode($actual);

		// context
		$this->assertArrayHasKey('@context', $context);

		// type
		$this->assertArrayHasKey('@type', $type);

		// data
		$this->assertArrayHasKey('url', $data);
		$this->assertArrayHasKey('potentialAction', $data);
		$this->assertArrayHasKey('target', $data['potentialAction']);
    }

    /**
     * A social profile
     *
     * @return void
     */

    public function testSocialProfile()
    {
		$jsonLd = new JsonLd;

		$context = ['@context' => 'http://schema.org'];
		$type	 = ['@type' => 'Organization'];
		$data    = [
			'url' => 'https://www.bookmarc.com.au',
		  	'sameAs' => config('companyInfo.socialProfile')
		];

		$actual = $jsonLd
					->context($context)
					->type($type)
					->data($data)
					->getScriptJsonLd(false);

		$actual = json_decode($actual);

		// context
		$this->assertArrayHasKey('@context', $context);

		// type
		$this->assertArrayHasKey('@type', $type);

		// data
		$this->assertArrayHasKey('url', $data);
		$this->assertArrayHasKey('sameAs', $data);
	}
}
