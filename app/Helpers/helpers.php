<?php
/**
 * @param $v
 * @return string
 *
 * 获取图片地址
 */
function getImgUrl($v) {
    if (filter_var($v, FILTER_VALIDATE_URL)) {
        return $v;
    } elseif (!is_null($v)) {
        return asset('upload'. '/' . $v) ;
    }
}

function confirmSms($phone, $code) {
    if (!$phone || !$code) {
        return false;
    }

    return true;
    $client = new \GuzzleHttp\Client([
        'timeout' => 10.0,
        'base_uri' => 'http://112.81.84.7:8000'
    ]);
    $res = $client->request('POST', 'api/v1/common/sms/confirm', [
        'json' => [
            'phone' => $phone,
            'code' => $code
        ]
    ]);
    $content = $res->getBody()->getContents();

    return (bool)$content;
}
