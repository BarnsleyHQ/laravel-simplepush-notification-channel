<?php

namespace BarnsleyHQ\SimplePush\Models\Actions;

use BarnsleyHQ\SimplePush\Exceptions\InvalidGetActionUrlException;
use BarnsleyHQ\SimplePush\Models\Concerns\HasUrlGetterSetters;

/**
 * @property string $url
 */
class GetAction
{
    use HasUrlGetterSetters;

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
            throw new InvalidGetActionUrlException();
        }

        $this->_url = $url;

        return $this;
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
