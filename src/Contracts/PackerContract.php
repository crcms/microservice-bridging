<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2019-01-25 20:13
 *
 * @link http://crcms.cn/
 *
 * @copyright Copyright &copy; 2019 Rights Reserved CRCMS
 */

namespace CrCms\Microservice\Bridging\Contracts;

/**
 * Interface PackerContract
 */
interface PackerContract
{
    /**
     * @param array $data
     *
     *
     * @return string
     */
    public function pack(array $data): string ;

    /**
     * @param string $data
     *
     *
     * @return array
     */
    public function unpack(string $data): array ;
}