<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/10/23
 * Time: 16:09.
 */

namespace App\Service;

class BaseService
{
    private $error = '';
    private $code  = 200;
    private $data  = [];
    private $bcode = 1000;

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     *
     * @return BaseService
     */
    public function setError(string $error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return BaseService
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return BaseService
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return int
     */
    public function getBcode(): int
    {
        return $this->bcode;
    }

    /**
     * @param int $bcode
     *
     * @return BaseService
     */
    public function setBcode(int $bcode): self
    {
        $this->bcode = $bcode;

        return $this;
    }
}
