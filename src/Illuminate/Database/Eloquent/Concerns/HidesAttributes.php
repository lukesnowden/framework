<?php

namespace Illuminate\Database\Eloquent\Concerns;

use Closure;

trait HidesAttributes
{
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * Get the hidden attributes for the model.
     *
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the hidden attributes for the model.
     *
     * @param  array  $hidden
     * @return $this
     */
    public function setHidden(array $hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get the visible attributes for the model.
     *
     * @return array
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set the visible attributes for the model.
     *
     * @param  array  $visible
     * @return $this
     */
    public function setVisible(array $visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Make the given, typically hidden, attributes visible.
     *
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeVisible($attributes)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->hidden = array_diff($this->hidden, $attributes);

        if (! empty($this->visible)) {
            $this->visible = array_merge($this->visible, $attributes);
        }

        return $this;
    }

    /**
     * Make the given, typically hidden, attributes visible if the given truth test passes.
     *
     * @param  bool|Closure  $condition
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeVisibleIf($condition, $attributes)
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        return $condition ? $this->makeVisible($attributes) : $this;
    }

    /**
     * Make the given, typically visible, attributes hidden.
     *
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeHidden($attributes)
    {
        $this->hidden = array_merge(
            $this->hidden, is_array($attributes) ? $attributes : func_get_args()
        );

        return $this;
    }

    /**
     * Make all, typically visible attributes hidden, except ones given.
     * @param array|string|null $attributes
     * @return $this
     */
    public function makeAllHiddenExcept($attributes)
    {
        $this->hidden = array_diff(
            array_keys($this->getAttributes()),
            is_array($attributes) ? $attributes : func_get_args()
        );

        return $this;
    }

    /**
     * Make all, typically visible attributes hidden, except ones given, if the given truth test passes.
     * @param bool|closure $condition
     * @param array $attributes
     * @return $this
     */
    public function makeAllHiddenExceptIf($condition, array $attributes)
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        $attributesToHide = array_diff(
            array_keys($this->getAttributes()),
            $attributes
        );

        return value($condition) ? $this->makeHidden($attributesToHide) : $this;
    }

    /**
     * Make the given, typically visible, attributes hidden if the given truth test passes.
     *
     * @param  bool|Closure  $condition
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeHiddenIf($condition, $attributes)
    {
        $condition = $condition instanceof Closure ? $condition($this) : $condition;

        return value($condition) ? $this->makeHidden($attributes) : $this;
    }
}
