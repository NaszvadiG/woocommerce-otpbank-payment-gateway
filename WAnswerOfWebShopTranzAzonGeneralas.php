<?php

require_once 'WebShopTranzAzon.php';
require_once 'WebShopXmlUtils.php';

/**
* A fizet�si tranzakci� azonos�t� gener�l�s szolg�ltat�s 
* v�lasz XML-j�nek feldolgoz�s�sa �s a megfelel� value object el��ll�t�sa.
* 
* @version 4.0
*/
class WAnswerOfWebShopTranzAzonGeneralas {

    /**
    * A fizet�si tranzakci� azonos�t� gener�l�s szolg�ltat�s 
    * v�lasz XML-j�nek feldolgoz�s�sa �s a megfelel� value object el��ll�t�sa.
    * 
    * @param DomDocument $answer A tranzakci�s v�lasz xml
    * @return WebShopTranzAzon a v�lasz tartalma, 
    *         vagy NULL �res/hib�s v�lasz eset�n
    */
    function load($answer) {
        $webShopTranzAzon = null;

        $record = WebShopXmlUtils::getNodeByXPath($answer, '//answer/resultset/record');
        if (!is_null($record)) {
            $webShopTranzAzon = new WebShopTranzAzon();
            $webShopTranzAzon->setAzonosito(WebShopXmlUtils::getElementText($record, "id"));
            $webShopTranzAzon->setPosId(WebShopXmlUtils::getElementText($record, "posid"));
            $webShopTranzAzon->setTeljesites(WebShopXmlUtils::getElementText($record, "timestamp"));
        }
        
        return $webShopTranzAzon;
    }

}

?>