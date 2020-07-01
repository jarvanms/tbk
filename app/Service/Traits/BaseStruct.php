<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/4
 * Time: 18:11.
 */

namespace App\Service\Traits;

trait BaseStruct
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
     * @return BaseStruct
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
     * @return BaseStruct
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
     * @return BaseStruct
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
     * @return BaseStruct
     */
    public function setBcode(int $bcode): self
    {
        $this->bcode = $bcode;

        return $this;
    }
}
