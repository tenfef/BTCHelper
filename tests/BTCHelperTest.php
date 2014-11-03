<?php
 
use JaycoDesign\BTCHelper\BTCHelper;
 
class BTCHelperTest extends PHPUnit_Framework_TestCase {
 
	public function testconvertToBTCFromSatoshi()
	{
		$one_satoshi = BTCHelper::convertToBTCFromSatoshi(1);
		$one_satoshi = BTCHelper::formatBTCFloat($one_satoshi);
		$this->assertEquals("0.00000001", $one_satoshi);

		$result = BTCHelper::convertToBTCFromSatoshi(303490);
		$this->assertEquals("0.0030349", $result);		

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Expected Satoshis, received float: 0.34
	 */
	public function testAssertExpectingInteger()
	{
		BTCHelper::format(0.34);
	}

	public function testFormat()
	{
		$result = BTCHelper::format(303490);
		$this->assertEquals("0.0030349", $result);
	}

	public function testconvertToSatoshiFromBTC()
	{
		$one_satoshi = BTCHelper::convertToSatoshiFromBTC("0.00000001");		
		$this->assertEquals("1", $one_satoshi);
	}

	public function testConvertBTCToMillibits()
	{
		$millibit = BTCHelper::convertBTCToMilliBits("0.001");
		$this->assertEquals(1, $millibit);
	}

	public function testConvertMillibitsToBTC()
	{
		$btc = BTCHelper::convertMilliBitsToBTC(1);
		$this->assertEquals("0.001", $btc);
	}

	public function testConvertBTCToMicrobits()
	{
		$millibit = BTCHelper::convertBTCToMicroBits("0.000001");
		$this->assertEquals(1, $millibit);
	}

	public function testConvertMicrobitsToBTC()
	{
		$btc = BTCHelper::convertMicroBitsToBTC(1);
		$this->assertEquals("0.000001", $btc);
	}

	public function testValidBitcoinAddresss()
	{
		$valid_address = BTCHelper::validBitcoinAddress("1Af3EHHrbYRwaj4dcbKKcBxYxc6Z8j7xMZ");
		$this->assertTrue($valid_address);

		$invalid_address = BTCHelper::validBitcoinAddress("poo");
		$this->assertFalse($invalid_address);

		$invalid_address = BTCHelper::validBitcoinAddress(1324324324324324);
		$this->assertFalse($invalid_address);

		$invalid_address = BTCHelper::validBitcoinAddress("12-213-123-1233-21123-231-asd");
		$this->assertFalse($invalid_address);

		$invalid_address = BTCHelper::validBitcoinAddress("1Af3EHHrbYRwaj4dcbKKcBxYxc6Z8j7xM");
		$this->assertFalse($invalid_address);

		$doge_address = BTCHelper::validBitcoinAddress("DB3Na2iTbkfFWaadT45ykyoTJHL3DfbmZ9");
		$this->assertFalse($doge_address);
	}

}