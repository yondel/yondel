<?php

class AmazonApiModel
{
    private $_access_key_id     = 'AKIAIII42AH4WILWRGPA';
    private $_secret_access_key = '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';

    private function _generateRequestUrl()
    {
        $baseurl           = 'http://ecs.amazonaws.jp/onca/xml';
        $params            = array();
        $canonical_string  = '';

        $params['Service']        = 'AWSECommerceService';
        $params['AWSAccessKeyId'] = $this->_access_key_id;
        $params['Version']        = '2009-07-01';
        $params['Operation']      = 'ItemSearch';
        $params['ResponseGroup']  = 'Large';
        $params['SearchIndex']    = 'Books';
        $params['Keywords']       = 'もやし';
        $params['AssociateTag']   = 'hironorioka28-22';
        $params['Timestamp']      = gmdate('Y-m-d\TH:i:s\Z');

        ksort($params);

        foreach ($params as $k => $v) {
            $canonical_string .= '&' .
                $this->_urlencode_rfc3986($k) .
                '=' .
                $this->_urlencode_rfc3986($v);
        }

        $canonical_string = substr($canonical_string, 1);

        $parsed_url = parse_url($baseurl);

        $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";

        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $this->_secret_access_key, true));

        $url = $baseurl .
            '?' . $canonical_string .
            '&Signature=' .
            $this->_urlencode_rfc3986($signature);

        return $url;
    }

    private function _urlencode_rfc3986($str)
    {
            return str_replace('%7E', '~', rawurlencode($str));
    }

    public function getXml()
    {
        $url = $this->_generateRequestUrl();
        return @simplexml_load_file($url);
    }

    public function getData()
    {
        $xml = $this->getXml();
        return json_decode(json_encode($xml), true);
    }

    public function getRequestUrl()
    {
        return $this->_generateRequestUrl();
    }
}




