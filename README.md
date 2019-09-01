# json-ld-laravel

A Simple Way To Generate The JSON LD

## Configure
	Setting up you information on config/jsonLd.php

## Example

### SearchAction

```
$this->jsonLd = new JsonLd;

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
```

### socialProfile

```
$this->jsonLd = new JsonLd;

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
```

### JobPosting

Conform Google Search [Job Posting](https://developers.google.com/search/docs/data-types/job-posting#definitions)

```
$this->jsonLd = new JsonLd;	

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

$script = $this->jsonLd
			->context($context)
			->type($type)
			->data($data)
			->getScriptJsonLd();

```

### JobPosting output

Validated at Google Search [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/)

```
<script type='application/ld+json'>{
    "@context": "http://schema.org",
    "@type": "JobPosting",
    "datePosted": "2017-01-24T19:33:17+00:00",
    "description": "You will program",
    "title": "Software Engineer",
    "validThrough": "2017-03-18T00:00",
    "hiringOrganization": {
        "@type": "Organization",
        "url": "https://www.bookmarc.com.au",
        "name": "MagsRUs Wheel Company",
        "logo": "http://www.example.com/images/logo.png",
        "sameAs": [
            "https://www.facebook.com/BookmarcAU",
            "https://twitter.com/BookmarcAU",
            "https://www.instagram.com/bookmarconline/",
            "https://www.linkedin.com/company/2460806/",
            "G+: https://plus.google.com/b/105090899583499517207/+BookmarcAu?gmbpt=true&pageId=105090899583499517207",
            "https://au.pinterest.com/bookmarc/pins/",
            "http://bookmarconline.tumblr.com"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+1-877-746-0909",
            "contactType": "customer service",
            "contactOption": "TollFree",
            "areaServed": [
                "US",
                "CA"
            ]
        },
        "employee": {
            "@type": "Person",
            "givenName": "First Name",
            "additionalName": "Middle Name",
            "familyName": "Family Name",
            "email": "hr@example.com"
        }
    },
    "jobLocation": {
        "@type": "Place",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "555 Clancy St",
            "addressLocality": "Detroit",
            "addressRegion": "MI",
            "postalCode": "48201",
            "addressCountry": "US"
        }
    },
    "employmentType": [
        "FULL_TIME",
        "PART_TIME",
        "CONTRACTOR",
        "TEMPORARY",
        "INTERN",
        "VOLUNTEER",
        "PER_DIEM",
        "OTHER"
    ],
    "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "USD",
        "value": {
            "@type": "QuantitativeValue",
            "value": "40.00",
            "unitText": "HOUR"
        }
    }
}</script>
```