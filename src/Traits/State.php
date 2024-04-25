<?php

namespace FerProjekt\LaravelStateMachine\Traits;

trait State
{
    public function transitions(): array
    {
        return [];
    }

    public function initialState(): array
    {
        return [];
    }

    public function canTransitTo(self $status): bool
    {
        return in_array($status, $this->transitions());
    }

    public function inInitialState(): bool
    {
        return in_array($this, $this->initialState());
    }
}
