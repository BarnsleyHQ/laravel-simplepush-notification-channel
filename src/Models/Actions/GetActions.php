<?php

namespace BarnsleyHQ\SimplePush\Models\Actions;

class GetActions
{
    /**
     * The options to display for the action.
     *
     * @var array<GetAction>
     */
    public $options = [];

    /**
     * Create new instance with option(s).
     *
     * @param  GetAction|array<GetAction>  $action
     * @return $this
     */
    public static function make(GetAction|array $action): self
    {
        return (new self())->add($action);
    }

    /**
     * Add action option(s).
     *
     * @param  GetAction|array<GetAction>  $action
     * @return $this
     */
    public function add(GetAction|array $action): self
    {
        if (is_a($action, GetAction::class)) {
            $action = [$action];
        }

        foreach ($action as $item) {
            if (! is_a($item, GetAction::class)) {
                continue;
            }

            $this->options[] = $item;
        }

        return $this;
    }

    /**
     * Add action from name and url.
     *
     * @param  string  $name
     * @param  string  $url
     * @return $this
     */
    public function addAction(string $name, string $url): self
    {
        $this->add(GetAction::make($name, $url));

        return $this;
    }

    /**
     * Convert actions to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(fn ($action) => $action->toArray(), $this->options);
    }
}
