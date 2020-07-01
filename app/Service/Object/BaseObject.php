<?php

namespace App\Service\Object;

/**
 * Class BaseObject.
 */
class BaseObject
{
    private $data;

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->data[$name] = $value;
        }
    }

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        $value = isset($this->data[$name]) ? $this->data[$name] : null;

        return $value;
    }

    /**
     * 批量填充属性.
     *
     * @param array $data
     */
    public function populate(array $data)
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * 将对象属性以数组形式返回.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * 子类定义setter时，把相应的属性保存在data私有属性中.
     *
     * @param $name
     * @param $value
     */
    protected function setOneData($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * 子类定义getterr时，从data中获取相应的属性.
     *
     * @param $name
     *
     * @return mixed|null
     */
    protected function getOneData($name)
    {
        $value = isset($this->data[$name]) ? $this->data[$name] : null;

        return $value;
    }
}
