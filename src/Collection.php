<?php

namespace Metglobal\Utils;

class Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Create a new collection.
     *
     * @param array $items
     *
     * @return static
     */
    public static function make($items = []): Collection
    {
        return new static($items);
    }

    /**
     * Sort through each item with a callback.
     *
     * @param callable|int|null $callback
     *
     * @return static
     */
    public function sort($callback = null): Collection
    {
        $items = $this->items;

        $callback && is_callable($callback)
            ? uasort($items, $callback)
            : asort($items, $callback);

        return new static($items);
    }

    /**
     * Sort the collection keys.
     *
     * @param int  $options
     * @param bool $descending
     *
     * @return static
     */
    public function sortKeys($options = SORT_REGULAR, $descending = false): Collection
    {
        $items = $this->items;

        $descending ? krsort($items, $options) : ksort($items, $options);

        return new static($items);
    }

    /**
     * Create a collection with the given range.
     *
     * @param int $from
     * @param int $to
     *
     * @return static
     */
    public function range($from, $to, $step = 1): Collection
    {
        return new static(range($from, $to, $step));
    }

    /**
     * Get all of the items in the collection.
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Get the keys of the collection items.
     *
     * @return static
     */
    public function keys(): Collection
    {
        return new static(array_keys($this->items));
    }

    /**
     * Determine if an item exists in the collection.
     *
     * @param mixed $key
     */
    public function contains($key, bool $strict = false): bool
    {
        return in_array($key, $this->items, $strict);
    }

    /**
     * Search the collection for a given value and return the corresponding key if successful.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function search($value, bool $strict = false)
    {
        if (!$this->useAsCallable($value)) {
            return array_search($value, $this->items, $strict);
        }

        foreach ($this->items as $key => $item) {
            if ($value($item, $key)) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Get the items in the collection that are not present in the given items.
     *
     * @return static
     */
    public function diff(array $items, callable $callback): Collection
    {
        return new static(array_udiff($this->items, $items, $callback));
    }

    /**
     * Get all items except for those with the specified keys.
     *
     * @param string|array $keys
     *
     * @return static
     */
    public function except($keys): Collection
    {
        return new static(Arr::except($this->items, $keys));
    }

    /**
     * Get the items with the specified keys.
     *
     * @param string|array $keys
     *
     * @return static
     */
    public function only($keys): Collection
    {
        if (is_null($keys)) {
            return new static($this->items);
        }

        $keys = is_array($keys) ? $keys : func_get_args();

        return new static(Arr::only($this->items, $keys));
    }

    /**
     * Get the first item from the collection passing the given truth test.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        return Arr::first($this->items, $callback, $default);
    }

    /**
     * Get the last item from the collection.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        return Arr::last($this->items, $callback, $default);
    }

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return value($default);
    }

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param mixed $key
     */
    public function has($key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->items)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Run a map over each of the items.
     *
     * @return static
     */
    public function map(callable $callback): Collection
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Run a filter over each of the items.
     *
     * @return static
     */
    public function filter(callable $callback = null): Collection
    {
        if ($callback) {
            return new static(Arr::where($this->items, $callback));
        }

        return new static(array_filter($this->items));
    }

    /**
     * Count the number of items in the collection.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param mixed $value
     */
    protected function useAsCallable($value): bool
    {
        return !is_string($value) && is_callable($value);
    }
}
