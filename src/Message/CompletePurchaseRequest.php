<?php

namespace Omnipay\Rabobank\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Rabobank Complete Purchase Request
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        $this->validate('secretKey');

        if ($this->getTestMode()) {
            $this->setSecretKey('002020000000001_KEY1');
        }

        $data = $this->httpRequest->request->all();

        if ($this->generateSignature($data) !== $this->httpRequest->request->get('Seal')) {
            throw new InvalidRequestException('Incorrect signature');
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
