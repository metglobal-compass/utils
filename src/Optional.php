<?php

namespace Metglobal\Utils;

class Optional
{
    /**
     * The target being transformed
     * Use _ prefix to avoid namespace conflict on __get().
     *
     * @var mixed
     */
    protected $_target;

    /**
     * Create a new transform proxy instance.
     *
     * @param mixed $_target
     */
    public function __construct($_target)
    {
        $this->_target = $_target;
    }

    /**
     * Dynamically pass property fetching to the target when it's present.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (is_object($this->_target)) {
            return $this->_target->{$name};
        }
    }

    /**
     * Dynamically pass method calls to the target when it's present.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (is_object($this->_target)) {
            return $this->_target->{$name}(...$arguments);
        }
    }

    /**
     * Allow optional(null)->present()->prop to return null without a decorated
     * null deference exception.
     *
     * @return mixed|Optional
     */
    public function present()
    {
        if (is_object($this->_target)) {
            return $this->_target->present(...func_get_args());
        }

        return new Optional(null);
    }
}
