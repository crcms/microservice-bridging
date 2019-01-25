<?php

namespace CrCms\Microservice\Bridging;

use CrCms\Microservice\Bridging\Contracts\PackerContract;
use Illuminate\Contracts\Encryption\Encrypter as IlluminateEncrypter;

class DataPacker
{
    /**
     * @var PackerContract
     */
    protected $packer;

    /**
     * @var IlluminateEncrypter
     */
    protected $encrypter;

    /**
     * @param PackerContract $packer
     * @param IlluminateEncrypter|null $encrypter
     */
    public function __construct(PackerContract $packer, ?IlluminateEncrypter $encrypter = null)
    {
        $this->packer = $packer;
        $this->encrypter = $encrypter;
    }

    /**
     * packing
     *
     * @param array $data
     * @return string
     */
    public function pack(array $data): string
    {
        $data = $this->packer->pack($data);

        return $this->encrypter ?
            $this->encrypter->encrypt($data) :
            $data;
    }

    /**
     * unpacking
     *
     * @param string $data
     * @return array
     */
    public function unpack(string $data): array
    {
        if ($this->encrypter) {
            $data = $this->encrypter->decrypt($data);
        }

        return $this->packer->unpack($data);
    }
}
