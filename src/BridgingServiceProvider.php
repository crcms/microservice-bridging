<?php

namespace CrCms\Microservice\Bridging;

use CrCms\Microservice\Bridging\Packer\JsonPacker;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

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
    protected $packagePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->isLumen()) {
            $this->publishes([
                $this->packagePath.'config/config.php' => $this->app->configPath($this->name.'.php'),
            ]);
        }
    }

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        if ($this->isLumen()) {
            $this->app->configure($this->name);
        }

        $this->mergeConfigFrom($this->packagePath.'config/config.php', 'bridging');

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
            $packer = $app['config']->get('bridging.packer');
            return new DataPacker(PackerFactory::factory($packer), $encryption === true ? $app['encrypter'] : null);
        });
    }

    /**
     * @return bool
     */
    protected function isLumen(): bool
    {
        return class_exists(Application::class) && $this->app instanceof Application;
    }

    /**
     * provides
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'bridging.packer',
            DataPacker::class,
        ];
    }
}
