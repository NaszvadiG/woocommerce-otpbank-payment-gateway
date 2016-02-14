<?php

require_once 'WebShopJovairasValasz.php';
require_once 'WebShopXmlUtils.php';

/**
* Fizet�s j�v��r�s v�lasz XML-j�nek feldolgoz�s�sa �s a megfelel� value object el��ll�t�sa.
* 
* @version 4.0
*/
class WAnswerOfWebShopJovairas {

    /**
    * Fizet�s j�v��r�s v�lasz XML-j�nek feldolgoz�s�sa �s a megfelel� value object el��ll�t�sa.
    * 
    * @param DomDocument $answer A tranzakci�s v�lasz xml
    * @return WebShopJ�v��r�sValasz a v�lasz tartalma, 
    *         vagy NULL �res/hib�s v�lasz eset�n
    */
    function load($answer) {
        $webShopJovairasValasz = new WebShopJovairasValasz();
       
        $record = WebShopXmlUtils::getNodeByXPath($answer, '//answer/resultset/record');
        if (!is_null($record)) {
            $webShopJovairasValasz->setMwTransactionId(WebShopXmlUtils::getElementText($record, "mwTransactionId"));
            $webShopJovairasValasz->setValaszKod(WebShopXmlUtils::getElementText($record, "responsecode"));
            $webShopJovairasValasz->setAuthorizaciosKod(WebShopXmlUtils::getElementText($record, "authorizationcode"));
        }
        
        return $webShopJovairasValasz;
    }

}

?>