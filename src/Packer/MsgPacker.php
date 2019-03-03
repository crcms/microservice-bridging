<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2019-03-03 16:08
 *
 * @link http://crcms.cn/
 *
 * @copyright Copyright &copy; 2019 Rights Reserved CRCMS
 */

namespace CrCms\Microservice\Bridging\Packer;

use CrCms\Microservice\Bridging\Contracts\PackerContract;

class MsgPacker implements PackerContract
{
    /**
     * Pack data
     *
     * @param array $data
     * @return string
     */
    public function pack(array $data): string
    {
        return msgpack_pack($data);
    }

    /**
     * Unpack data
     *
     * @param string $data
     * @return array
     */
    public function unpack(string $data): array
    {
        return msgpack_unpack($data);
    }
}