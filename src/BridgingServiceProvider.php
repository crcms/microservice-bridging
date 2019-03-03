<?php

namespace CrCms\Microservice\Bridging;

use CrCms\Microservice\Bridging\Packer\JsonPacker;
use Illuminate\Support\ServiceProvider;

class BridgingServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @var string
     */
    protected $name = 'bridging';

    /**
     * @var string
     */
    protected $basePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->basePath.'config/config.php', 'bridging');

        $this->registerAlias();

        $this->registerServices();
    }

    /**
     * registerAlias
     *
     * @return void
     */
    protected function registerAlias(): void
    {
        $this->app->alias('bridging.packer', DataPacker::class);
    }

    /**
     * @return void
     */
    protected function registerServices(): void
    {
        $this->app->singleton('bridging.packer', function ($app) {
            $encryption = $app['config']->get('bridging.encryption');
            return new DataPacker(new JsonPacker, $encryption === true ? $app['encrypter'] : null);
        });
    }

    /**
     * provides
     *
     * @return array
     */
    public function provides(): array
    {
        return ['bridging.packer'];
    }
}
