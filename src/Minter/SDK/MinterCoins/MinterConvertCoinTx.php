<?php

namespace Minter\SDK\MinterCoins;

use Minter\Contracts\MinterTxInterface;
use Minter\Library\Helper;
use Minter\SDK\MinterConverter;

class MinterConvertCoinTx extends MinterCoinTx implements MinterTxInterface
{
    /**
     * Type
     */
    const TYPE = 2;

    /**
     * Fee in PIP
     */
    const COMMISSION = 10000;

    /**
     * Send coin tx data
     *
     * @var array
     */
    public $data = [
        'coin_from' => '',
        'coin_to' => '',
        'value' => ''
    ];

    /**
     * MinterCreateCoinTx constructor.
     * @param $data
     * @param bool $convert
     * @throws \Exception
     */
    public function __construct($data, $convert = false)
    {
        parent::__construct($data, $convert);
    }

    /**
     * Prepare tx data for signing
     *
     * @return array
     */
    public function encode(): array
    {
        return [
            'coin_from' => MinterConverter::convertCoinName($this->data['coin_from']),
            'coin_to' => MinterConverter::convertCoinName($this->data['coin_to']),
            'value' => MinterConverter::convertValue($this->data['value'], 'pip')
        ];
    }

    /**
     * Prepare output tx data
     *
     * @param array $txData
     * @return array
     */
    public function decode(array $txData): array
    {
        return [
            'coin_from' => Helper::pack2hex($txData[0]),
            'coin_to' => Helper::pack2hex($txData[1]),
            'value' => MinterConverter::convertValue(
                Helper::hexDecode($txData[2]),
                'bip'
            )
        ];
    }
}