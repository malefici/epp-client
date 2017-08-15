<?php

namespace Struzik\EPPClient\Response\Contact;

use Struzik\EPPClient\Response\AbstractCommonResponse;

/**
 * Object representation of the response of contact updating command.
 */
class Update extends AbstractCommonResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccess()
    {
        return $this->getResultCode() === self::RC_SUCCESS;
    }
}
