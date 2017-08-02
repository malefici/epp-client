<?php

namespace Struzik\EPPClient\Response;

use XPath\DOMXPath;

/**
 * Basic implementation of the response object.
 */
abstract class AbstractResponse extends \DomDocument implements ResponseInterface
{
    /**
     * XPath query handler.
     *
     * @var \DOMXPath
     */
    public $xpath;

    /**
     * Namespaces used in document.
     *
     * @var array
     */
    private $namespaces = [];

    /**
     * {@inheritdoc}
     */
    public function __construct($xml)
    {
        $this->preserveWhiteSpace = false;
        $this->loadXML($xml);
        $this->initDOMXPath();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function isSuccess();

    /**
     * {@inheritdoc}
     */
    public function get($xpathQuery, \DOMNode $contextnode = null)
    {
        return $this->xpath->query($xpathQuery, $contextnode);
    }

    /**
     * {@inheritdoc}
     */
    public function getFirst($xpathQuery, \DOMNode $contextnode = null)
    {
        $list = $this->get($xpathQuery, $contextnode);

        return count($list) ? $list->item(0) : null;
    }

    /**
     * Returns namespaces used in document.
     *
     * @return array Array of namespace names with their associated URIs
     */
    public function getUsedNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Initialisation XPath.
     *
     * @return $this
     */
    private function initDOMXPath()
    {
        $this->xpath = new DOMXPath($this);

        $simpleXML = new \SimpleXMLElement($this->saveXML());
        $namespaces = $simpleXML->getNamespaces(true);

        foreach ($namespaces as $name => $uri) {
            $name = $name ?: self::ROOT_NAMESPACE_NAME;
            $this->namespaces[$name] = $uri;
            $this->xpath->registerNamespace($name, $uri);
        }

        return $this;
    }
}
