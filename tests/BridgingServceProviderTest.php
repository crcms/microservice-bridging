<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2019-03-03 11:57
 *
 * @link http://crcms.cn/
 *
 * @copyright Copyright &copy; 2019 Rights Reserved CRCMS
 */

namespace CrCms\Microservice\Bridging\Tests;

use CrCms\Microservice\Bridging\BridgingServiceProvider;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Encryption\Encrypter;
use Illuminate\Encryption\EncryptionServiceProvider;
use PHPUnit\Framework\TestCase;

class BridgingServceProviderTest extends TestCase
{

    public function testConfig()
    {
        $app = new Container();

        $config = \Mockery::mock(Repository::class);
        $config->shouldReceive('get')->with('bridging',[])->andReturn(['bridging' => []]);
        $config->shouldReceive('get')->with('bridging.encryption')->andReturn(true);
        $config->shouldReceive('set');
        $app->instance('config',$config);

        $key = 'base64:Bey9po1NfR9CHY65KxPqQIemqvhDfHLNTFeffewn3pY=';
        $key = base64_decode(substr($key, 7));
        $encrypt = new Encrypter($key,'AES-256-CBC');
        $app->instance('encrypter',$encrypt);

        $provider = new BridgingServiceProvider($app);
        $provider->register();

        $this->assertTrue($app->has('bridging.packer'));

//        dd($config->get('bridging'));
    }

}