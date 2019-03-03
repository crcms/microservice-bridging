<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2019-03-03 16:27
 *
 * @link http://crcms.cn/
 *
 * @copyright Copyright &copy; 2019 Rights Reserved CRCMS
 */

namespace CrCms\Microservice\Bridging\Tests;

use CrCms\Microservice\Bridging\Packer\JsonPacker;
use CrCms\Microservice\Bridging\Packer\MsgPacker;
use CrCms\Microservice\Bridging\PackerFactory;
use PHPUnit\Framework\TestCase;

class PackerFactoryTest extends TestCase
{

    public function testMsg()
    {
        $result = PackerFactory::factory('msg');

        $this->assertInstanceOf(MsgPacker::class,$result);
    }

    public function testJson()
    {
        $result = PackerFactory::factory('json');

        $this->assertInstanceOf(JsonPacker::class,$result);
    }

}