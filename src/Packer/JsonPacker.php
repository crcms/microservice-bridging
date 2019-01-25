<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2019-01-25 20:37
 *
 * @link http://crcms.cn/
 *
 * @copyright Copyright &copy; 2019 Rights Reserved CRCMS
 */

namespace CrCms\Microservice\Bridging\Packer;

use CrCms\Microservice\Bridging\Contracts\PackerContract;
use UnexpectedValueException;

class JsonPacker implements PackerContract
{
    /**
     * packing to json
     *
     * @param array $data
     * @return string
     *
     * @throws UnexpectedValueException
     */
    public function pack(array $data): string
    {
        $data = json_encode($data);
        if ($data === false) {
            throw new UnexpectedValueException('Data packing error.');
        }

        return $data;
    }

    /**
     * unpacking to array
     *
     * @param string $data
     * @return array
     *
     * @throws UnexpectedValueException
     */
    public function unpack(string $data): array
    {
        $data = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new UnexpectedValueException('Data unpacking error.');
        }

        return $data;
    }
}