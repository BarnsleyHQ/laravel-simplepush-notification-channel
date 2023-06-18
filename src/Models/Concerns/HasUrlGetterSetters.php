<?php

namespace BarnsleyHQ\SimplePush\Models\Concerns;

trait HasUrlGetterSetters
{
    /**
     * Magic method used to get urls.
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if (property_exists($this, '_'.$name)) {
            return $this->{'_'.$name};
        }

        throw new \Exception("Property [{$name}] does not exist");
    }

    /**
     * Magic method used to pass urls through the method validation.
     *
     * @param  string  $name
     * @param  string  $value
     * @return void
     */
    public function __set(string $name, string $value): void
    {
        $method = 'set'.ucfirst($name);
        if (! method_exists($this, $method)) {
            throw new \Exception("Property [{$name}] does not exist");
        }

        $this->{$method}($value);
    }
}
