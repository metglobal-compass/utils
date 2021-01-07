<?php

namespace Metglobal\Utils\Tests\Fixtures;

class DummyOptional
{
    private $foo;
    private $baz;

    /**
     * @return mixed
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @param mixed $foo
     * @return DummyOptional
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaz()
    {
        return $this->baz;
    }

    /**
     * @param mixed $baz
     * @return DummyOptional
     */
    public function setBaz($baz)
    {
        $this->baz = $baz;

        return $this;
    }
}