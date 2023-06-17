<?php

namespace BarnsleyHQ\SimplePush\Models\Actions;

use BarnsleyHQ\SimplePush\Exceptions\InvalidGetActionUrl;

class GetAction
{
    /**
     * The name of the action to be displayed.
     *
     * @var string
     */
    public string $name;

    /**
     * The url for the actual to perform the request to.
     *
     * @var string
     */
    private string $_url;

    /**
     * Create new instance.
     *
     * @param  string  $name
     * @param  string  $url
     * @return $this
     */
    public static function make(string $name, string $url): self
    {
        return (new self())->setName($name)
            ->setUrl($url);
    }

    /**
     * Set the name of the action.
     *
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the url of the action.
     *
     * @param  string  $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        if (! preg_match('/^https?:\/\//', $url)) {
            throw new InvalidGetActionUrl();
        }

        $this->_url = $url;

        return $this;
    }

    /**
     * Magic method used to get url.
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
     * Magic method used to pass url through the method validation.
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

    /**
     * Convert action to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->_url,
        ];
    }
}
