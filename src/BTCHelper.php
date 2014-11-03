<?php namespace JaycoDesign\BTCHelper;

use JaycoDesign\Decimal\Decimal;

class BTCHelper {

  public static $satoshi_quotient = '100000000';
  public static $millibit_quotient = '1000';
  public static $microbit_quotient = '1000000';

  public static function convertToBTCFromSatoshi($value)
  {
      return Decimal::div($value, self::$satoshi_quotient);      
  }

  public static function convertToSatoshiFromBTC($value)
  {      
      return Decimal::mul($value, self::$satoshi_quotient);      
  }

  public static function convertBTCToMilliBits($btc)
  {
      return Decimal::mul($btc, self::$millibit_quotient);
  }

  public static function convertMilliBitsToBTC($btc)
  {
      return Decimal::div($btc, self::$millibit_quotient);
  }

  public static function convertBTCToMicroBits($btc)
  {
      return Decimal::mul($btc, self::$microbit_quotient);
  }

  public static function convertMicroBitsToBTC($btc)
  {
      return Decimal::div($btc, self::$microbit_quotient);
  }

  public static function format($value)
  {
      if (floor( $value ) != $value)
      {
        throw new \Exception("Expected Satoshis, received float: " . $value, 1);        
      }
      $btc = BTCHelper::convertToBTCFromSatoshi($value);
      return self::formatBTCFloat($btc);
  }  

  public static function formatBTCFloat($value)
  {
      $value = sprintf('%.8f', $value);
      $value = rtrim($value, '0');
      return $value;
  }

   /**
     * Determine if a string is a valid Bitcoin address
     *
     * @author theymos
     * @param string $addr String to test
     * @param string $addressversion
     * @return boolean
     * @access public
     */
    public static function validBitcoinAddress($address) {
      $addressversion = "00";
      $addr = static::decodeBase58($address);
      if (strlen($addr) != 50) {
        return false;
      }
      $version = substr($addr, 0, 2);
      if (hexdec($version) > hexdec($addressversion)) {
        return false;
      }
      $check = substr($addr, 0, strlen($addr) - 8);
      $check = pack("H*", $check);
      $check = strtoupper(hash("sha256", hash("sha256", $check, true)));
      $check = substr($check, 0, 8);
      return $check == substr($addr, strlen($addr) - 8);
    }

    private static function encodeHex($dec) {
      $hexchars = "0123456789ABCDEF";

          $return = "";
          while (bccomp($dec, 0) == 1) {
            $dv = (string) bcdiv($dec, "16", 0);
            $rem = (integer) bcmod($dec, "16");
            $dec = $dv;
            $return = $return . $hexchars[$rem];
          }
          return strrev($return);
     }


  public static function exp2dec($number) {
      
      preg_match('/(.*)E-(.*)/', str_replace(".", "", $number), $matches);
      if (! $matches){
        return $number;
      }

      $num = "0.";
      $i = 0;
      while ($matches[2] > 1) {
          $i++;
          $num .= "0";
          $matches[2]--;
      }
      if ($i > 16){
        return 0;
      }
      return $num . rtrim($matches[1], '0');
  }

  // -----

    /**
     * Convert a Base58-encoded integer into the equivalent hex string representation
     *
     * @param string $base58
     * @return string
     * @access private
     */
    private static function decodeBase58($base58) {
      $origbase58 = $base58;
      $base58chars = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

      $return = "0";
      for ($i = 0; $i < strlen($base58); $i++) {
        $current = (string) strpos($base58chars, $base58[$i]);
        $return = (string) bcmul($return, "58", 0);
        $return = (string) bcadd($return, $current, 0);
      }

      $return = static::encodeHex($return);

      //leading zeros
      for ($i = 0; $i < strlen($origbase58) && $origbase58[$i] == "1"; $i++) {
        $return = "00" . $return;
      }

      if (strlen($return) % 2 != 0) {
        $return = "0" . $return;
      }

      return $return;
    }
}