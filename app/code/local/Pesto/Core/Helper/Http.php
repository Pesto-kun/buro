<?php
/**
 * File: Http.php
 * Date: 26.03.13 - 14:29
 *
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

class BestArt_Core_Helper_Http extends Mana_Core_Helper_Data {

    /**
     * check site status
     */
    public function checkSiteStatus($url) {
        return $this->_check_http_status($url);
    }

    /**
     * Проверка http статуса
     */
    protected function _check_http_status($url) {

        $user_agent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)';
        $httpcode = 0;

        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_exec($ch);
            $err = curl_error($ch);
            if(!empty($err)) {
                return $err;
            }
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__("Error get site [" . $url . "] status. " . $e->getMessage()));
        }

        return $httpcode;
    }
}