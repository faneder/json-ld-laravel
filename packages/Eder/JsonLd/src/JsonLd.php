<?php

namespace Eder\JsonLd;

use Eder\JsonLd\JsonLdSerialize;

/*
 * return jsonld format
 */
class JsonLd
{

	private $jsonLd = [];

    /**
     * Returns the context.
     * @param  $context array ['@context' => 'http://schema.org']
     * @return json
     */
	public function context($context=[])
	{
		$this->jsonLd += $context;

		return $this;
	}

	public function type($type='')
	{
		$this->jsonLd += $type;

		return $this;
	}

	public function data($data='')
	{
		$this->jsonLd = $data;

		return $this;
	}

    public function getScriptJsonLd($script=true)
    {
    	$jsonLd = $this->toJson();

    	if ($script) {
    		$jsonLd = "<script type='application/ld+json'>{$jsonLd}</script>";
    	}

    	return $jsonLd;
    }

    protected function toJson()
    {
    	if (!$this->jsonLd) {
    		throw new \RuntimeException("Error No JsonLd", 1);
    	}

		return json_encode(new JsonLdSerialize($this->jsonLd), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}