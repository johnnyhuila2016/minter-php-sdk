# Minter PHP SDK

## About

This is a pure PHP SDK for working with <b>Minter</b> blockhain

## Installing

```bash
composer require minter/minter-php-sdk
```

## Using MinterAPI

Create MinterAPI instance

```php
use Minter\MinterAPI;

$nodeUrl = 'http://156.123.34.5:8841'; // example of a node url

$api = new MinterAPI($nodeUrl);
```

### getBalance

Returns coins list and balance of an address.

``
getBalance(string $minterAddress): \stdClass
``

###### Example

```php
$api->getBalance('Mxfe60014a6e9ac91618f5d1cab3fd58cded61ee99')

// result: {MTN: 1000000, TESTCOIN: 2000000}

```

### getNonce

Returns current nonce of an address.

``
getNonce(string $minterAddress): integer
``

###### Example

```php
$api->getNonce('Mxfe60014a6e9ac91618f5d1cab3fd58cded61ee99')

// 5
```

### send

Returns the result of sending <b>signed</b> tx.

``
send(string $tx): \stdClass
``

###### Example

```php
$api->send('Mxf86d010101a6e58a4d494e540000000000009432143b4d9674b13b0868da425d049fd66910ebae843b9aca001ba0f0c64ae99c1f3f1acb9ad44cc1beeb3e29339353841b2a25dfa14529c41f6bbea02055b472434f7119ea5d7e928a2c357d9f5189b396cd1908bb1f9940391a79e4')

// {code: 0, tx: "Mx2f37ad1c22cf912c02a9f00c735a039d7da3169b"}
```

### getTransactionsFrom

Returns list of outgoing transactions of an address

``
getTransactionsFrom(string $minterAddress): \stdClass
``

###### Example

```php
$api->getTransactionsFrom('Mxfe60014a6e9ac91618f5d1cab3fd58cded61ee99')

// result: {code: 0, result: [{ height: 1, index: 0, proof: ..., tx: 'Mx...', tx_result: {...} }]}
```

### getTransactionsTo

Returns list of incoming transactions of an address

``
getTransactionsTo(string $minterAddress): \stdClass
``

###### Example

```php
$api->getTransactionsTo('Mxfe60014a6e9ac91618f5d1cab3fd58cded61ee99')

// result: {code: 0, result: [{ height: 1, index: 0, proof: ..., tx: 'Mx...', tx_result: {...} }]}
```

## Using MinterSDK

### Sign transaction

Returns a signed tx

###### Example

* Sign the <b>SendCoin</b> transaction

```php
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterSendCoinTx;

$tx = new MinterTx([
    'nonce' => $nonce,
    'gasPrice' => 1,
    'type' => MinterSendCoinTx::TYPE,
    'data' => [
        'coin' => 'MTN',
        'to' => 'Mxfe60014a6e9ac91618f5d1cab3fd58cded61ee99',
        'value' => '10'
    ],
    'payload' => '',
    'serviceData' => ''
]);

$tx->sign('your private key')
```

* Sign the <b>ConvertCoin</b> transaction

```php
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterConvertCoinTx;

$tx = new MinterTx([
    'nonce' => $nonce,
    'gasPrice' => 1,
    'type' => MinterConvertCoinTx::TYPE,
    'data' => [
         'coin_from' => 'MNT',
         'coin_to' => 'TESTCOIN',
         'value' => '1'
    ],
    'payload' => '',
    'serviceData' => ''
]);

$tx->sign('your private key')
```

* Sign the <b>CreateCoin</b> transaction

```php
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterCreateCoinTx;

$tx = new MinterTx([
    'nonce' => $nonce,
    'gasPrice' => 1,
    'type' => MinterCreateCoinTx::TYPE,
    'data' => [
        'name' => 'TEST COIN',
        'symbol' => 'TEST',
        'initialAmount' => '100',
        'initialReserve' => '10',
        'crr' => 10
    ],
    'payload' => '',
    'serviceData' => ''
]);

$tx->sign('your private key')
```

* Calculate fee of transaction
```php
use Minter\SDK\MinterTx;

$tx = new MinterTx([....]);

$tx->getFee();
```

* Get hash of encoded transaction
```php
use Minter\SDK\MinterTx;

$tx = new MinterTx([....]);
$sign = $tx->sign('your private key');

$hash = $tx->getHash();
```

* Get hash of decoded transaction
```php
use Minter\SDK\MinterTx;

$tx = new MinterTx('Mx....');

$hash = $tx->getHash();
```

### Decode transaction

Returns an array with transaction data

###### Example

* Decode transaction

```php
use Minter\SDK\MinterTx;

$tx = new MinterTx('string tx');

// $tx->from, $tx->data, $tx->nonce ...

```


## License

The Minter PHP SDK is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
