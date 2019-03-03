<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2019-03-03 16:22
 *
 * @link http://crcms.cn/
 *
 * @copyright Copyright &copy; 2019 Rights Reserved CRCMS
 */

namespace CrCms\Microservice\Bridging;

use CrCms\Microservice\Bridging\Contracts\PackerContract;
use CrCms\Microservice\Bridging\Packer\JsonPacker;
use CrCms\Microservice\Bridging\Packer\MsgPacker;
use RuntimeException;

class PackerFactory
{
    /**
     * Get packer
     *
     * @param string $packer
     * @return PackerContract
     */
    public static function factory(string $packer): PackerContract
    {
        switch ($packer) {
            case 'msg':
                if (!extension_loaded('msgpack')) {
                    throw new RuntimeException("The PHP extension[msgpack] not found");
                }
                return new MsgPacker;
            case 'json':
                return new JsonPacker;
            default:
                return new JsonPacker;
        }
    }
}