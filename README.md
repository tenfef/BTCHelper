BTCHelper
=========

Btc Helper is a class with some helper methods for bitcoin

## Installation

Simply add a dependency to your project's `composer.json` file if you use [Composer](http://getcomposer.org/) to manage the dependencies of your project.

Here is a minimal example of a `composer.json` file that just defines a dependency on Money:

    {
        "require": {
            "jaycodesign/btchelper": "dev-master"
        }
    }

### Formatting

You can deal with Satoshis everywhere in your code and only convert to BTC at display time like so:

```php
  use JaycoDesign\BTCHelper\BTCHelper;
  $one_satoshi = BTCHelper::format(1); // 0.00000001
```

### Conversion  
```php
BTCHelper::convertToBTCFromSatoshi(303490); // 0.0030349
BTCHelper::convertToSatoshiFromBTC("0.00000001"); // 1
BTCHelper::convertBTCToMilliBits("0.001"); // 1
BTCHelper::convertMilliBitsToBTC(1); // 0.001
BTCHelper::convertBTCToMicroBits("0.000001"); // 1
BTCHelper::convertMicroBitsToBTC(1); // 0.000001

```

### Bitcoin Address Validation

```php
BTCHelper::validBitcoinAddress("1Af3EHHrbYRwaj4dcbKKcBxYxc6Z8j7xMZ"); // TRUE
BTCHelper::validBitcoinAddress("POO"); // FALSE
```
