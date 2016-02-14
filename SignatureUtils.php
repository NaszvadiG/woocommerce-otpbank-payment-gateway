<?php

class SignatureUtils {

    public static function loadPrivateKey($key_original) {
/*
        $key_original = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQCpRN6hb8pQaDen9Qjt18P2FqScF2uhjKfd0DZ1t0HWtvYMmJGf
M6+wgjQGDHHc4LAcLIHF1TQVLCYdbyLzsOTRUhi4UFsW18IBznoEAx2wxiTCyzxt
ONpIkr5HD2E273UbXvVKA2hig2BgpOA2Poil9xtOXIm63iVw6gjP2qDnNwIDAQAB
AoGBAKP1ctTbDRRPrsGBB3IjEsz3Z+FOilIEhcHE4kuqBBswRCs1SbD1BtQpeqz1
NwGlntDbh6SSfQ2ZIx5VvXxhN3G6lNC0Mb15ra3XMjyHVHG7c/q3rDzhxFE361NO
uIgPdN1kVDCKm+RNmTbyLhCCpfbNIv8UlT2XnlajdMnPOzCZAkEA2trOehgWMFnl
IDDYAu1MtoNPPXCLfa44oCwwUmWg2Q/DbFWYs5u2wlk4xfnv9qGbv0DBuGesTYT0
DzjP0nqBkwJBAMX/kyNJ4TBouRDDnSj99Sdx57aYbzC1Xikt6FJVpT4P1KiGSoj6
OYSF8hz5kG90Dbv6W8Q4TwMbiFIOy9pFGk0CQQDG1OWj7UAze2h8H4QQ3LDGXHPg
WOCSNXeCpcLdCTHiIr0kLnwGKaEX3uGClDlb86VBU77sH1xeLT1imvXMvrn7AkEA
iktDqz88EYLj2Gi5Cduv8vglPy1jZGMZvKt6/J8jhqCqCXea8efMatrfzAsoLiCi
QyzQEdK+pU4CvkXlbrQbdQJAdLTPLSakZaN47bijXY05v11aC5ydb2pOpLHGKneX
wOt1vzdPct1YSk88YMD9RUi/xk/VnJHQ7cq8ltAXK/QNYA==
-----END RSA PRIVATE KEY-----
EOD;
*/
          $key = openssl_get_privatekey(str_replace("\r\n", "\n", $key_original));
          return $key;
    }

    /**
    * Al��rand� sz�veg el��ll�t�sa az al��rand� sz�veg �rt�kek list�j�b�l:
    * [s1, s2, s3, s4]  ->  's1|s2|s3|s4'
    *
    * @param array al��rand� mez�k
    * @return string al��rand� sz�veg
    */
    public static function getSignatureText($signatureFields) {
        $signatureText = '';
        foreach ($signatureFields as $data) {
            $signatureText = $signatureText.$data.'|';
        }

        if (strlen($signatureText) > 0) {
            $signatureText = substr($signatureText, 0, strlen($signatureText) - 1);
        }

        return $signatureText;
    }

    /**
    * Digit�lis al��r�s gener�l�sa a Bank �ltal elv�rt form�ban.
    * Az al��r�s sor�n az MD5 hash algoritmust haszn�ljuk 5.4.8-n�l kisebb verzi�j� PHP
    * eset�n, egy�bk�nt SHA-512 algoritmust.
    *
    * @param string $data az al��rand� sz�veg
    * @param resource $pkcs8PrivateKey priv�t kulcs
    *
    * @return string digit�lis al��r�s, hexadecim�lis form�ban (ahogy a banki fel�let elv�rja).
    */
    public static function generateSignature($data, $pkcs8PrivateKey) {

    	global $signature;

    	if (version_compare(PHP_VERSION, '5.4.8', '>=')) {
        	openssl_sign($data, $signature, $pkcs8PrivateKey, OPENSSL_ALGO_SHA512);
    	}
    	else {
    		openssl_sign($data, $signature, $pkcs8PrivateKey, OPENSSL_ALGO_MD5);
    	}

        return bin2hex($signature);
    }

}

?>
