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
     * @param  $context string 'http://schema.org'
     * @return json
     */
	public function context($context='http://schema.org')
	{
		$this->jsonLd['@context'] = $context;

		return $this;
	}

	public function type($type='')
	{
		$this->jsonLd['@type'] = $type;

		return $this;
	}

	public function data($data='')
	{
		$this->jsonLd += $data;

		return $this;
	}

    public function getScriptJsonLd($script=true)
    {
    	$jsonLd = $this->toJson();

    	if ($script) {
    		$jsonLd = "<script type='application/ld+json'>{$jsonLd}</script>";
    	}

        $this->reset();

    	return $jsonLd;
    }

    public function getEmbededJsonLd()
    {
    	$jsonLd = $this->toArray();

        $this->reset();

    	return $jsonLd;
    }

    protected function toArray()
    {
		$this->checkExistense();

    	$jsonLd = $this->jsonLd;
		unset($jsonLd["@context"]);

		return $jsonLd;
	}
	
    protected function checkExistense()
    {
		if (!$this->jsonLd) {
    		throw new \RuntimeException("Error No JsonLd", 1);
		};
	}
	
    protected function toJson(bool $embedded = false)
    {
		$this->checkExistense();
		
    	$jsonLd = $this->jsonLd;
		if ($embedded) {
			unset($jsonLd["@context"]);
		}

		return json_encode(new JsonLdSerialize($jsonLd), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Reset states after an execution
     *
     * @return Returns the current instance.
     */
    protected function reset()
    {
        $this->jsonLd = [];

        return $this;
    }
}