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
