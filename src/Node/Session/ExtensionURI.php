<?php

namespace Struzik\EPPClient\Node\Session;

use Struzik\EPPClient\Node\AbstractNode;
use Struzik\EPPClient\Request\RequestInterface;
use Struzik\EPPClient\Exception\InvalidArgumentException;

/**
 * Object representation of the <extURI> node.
 */
class ExtensionURI extends AbstractNode
{
    /**
     * @param RequestInterface $request    The request object to which the node belongs
     * @param array            $parameters Array of parameters who will be passed in self::handleParameters
     */
    public function __construct(RequestInterface $request, $parameters = [])
    {
        parent::__construct($request, 'extURI', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleParameters($parameters = [])
    {
        if (!isset($parameters['uri']) || empty($parameters['uri'])) {
            throw new InvalidArgumentException('Missing parameter with a key \'uri\'.');
        }

        $this->getNode()->nodeValue = $parameters['uri'];
    }
}
