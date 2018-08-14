# json-ld-laravel

A Simple Way To Generate The JSON LD

## Configure
	Setting up you information on config/jsonLd.php

## Example

### SearchAction

```
$this->jsonLd = new JsonLd;

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
```

### socialProfile

```
$this->jsonLd = new JsonLd;

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
```

