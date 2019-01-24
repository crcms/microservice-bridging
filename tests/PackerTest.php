<?php

namespace CrCms\Microservice\Bridging\Tests;

use CrCms\Microservice\Bridging\Packer;
use Illuminate\Encryption\Encrypter;
use PHPUnit\Framework\TestCase;

/**
 * Class PackerTest.
 */
class PackerTest extends TestCase
{
    /**
     * @var Packer
     */
    protected $packer;

    public function setUp()
    {
        parent::setUp();

        $key = 'base64:Bey9po1NfR9CHY65KxPqQIemqvhDfHLNTFeffewn3pY=';
        $key = base64_decode(substr($key, 7));

        $this->packer = new Packer(new Encrypter($key,'AES-256-CBC'),true);
    }

    public function testEmptyValuePack()
    {
        $data = ['call' => 'test', 'data'=>['x'=>1]];
        $result = $this->packer->pack($data);

        $this->assertNotEmpty($result);

        return $result;
    }

    /**
     * @depends testEmptyValuePack
     */
    public function testEmptyValueUnpack(string $data)
    {
        $data = $this->packer->unpack($data);
        $this->assertArrayHasKey('call', $data);
        $this->assertEquals('test', $data['call']);
        $this->assertEquals(['x'=>1], $data['data']);
    }

    public function testNotEmptyPack()
    {
        $data = ['call' => 'test', 'data' => ['key' => 'value']];
        $value = $this->packer->pack($data);
        $this->assertNotEmpty($value);

        return $value;
    }

    /**
     * @depends testNotEmptyPack
     */
    public function testNotEmptyValueUnpack(string $value)
    {
        $data = $this->packer->unpack($value);
        $this->assertArrayHasKey('call', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals('test', $data['call']);
        $this->assertEquals('value', $data['data']['key']);
    }

    public function testNotEncryptPack()
    {
        $data = ['call' => 'test', 'data' => ['key' => 'value']];
        $value = $this->packer->pack($data);
        $this->assertNotEmpty($value);

        return $value;
    }

    /**
     * @depends testNotEncryptPack
     *
     * @param string $value
     */
    public function testNotEncryptUnpack(string $value)
    {
        $data = $this->packer->unpack($value);
        $this->assertArrayHasKey('call', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals('test', $data['call']);
        $this->assertEquals('value', $data['data']['key']);
    }

    public function testEmptyNotEncryptPack()
    {
        $data = ['call' => 'test'];
        $value = $this->packer->pack($data);
        $this->assertNotEmpty($value);

        return $value;
    }

    /**
     * @depends testEmptyNotEncryptPack
     *
     * @param $value
     */
    public function testEmptyNotEncryptUnpack($value)
    {
        $data = $this->packer->unpack($value);
        $this->assertArrayHasKey('call', $data);
        $this->assertEquals(1, count($data));
        $this->assertEquals(['call' => 'test'], $data);
    }
}
