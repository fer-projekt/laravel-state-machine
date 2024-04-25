<?php

namespace FerProjekt\LaravelStateMachine\Traits;

use FerProjekt\LaravelStateMachine\Exceptions\InitailStateIsNotAllowedException;
use FerProjekt\LaravelStateMachine\Exceptions\StateEnumDoesntExistException;
use FerProjekt\LaravelStateMachine\Exceptions\StateTransitionNotAllowedException;

trait HasState
{
    protected static function bootHasState()
    {
        static::creating(function ($model) {
            foreach ($model->getStates() as $stateToCheck) {
                $state = $model->$stateToCheck;

                if (empty($state)) {
                    return;
                }

                if (
                    !isset($model->getCasts()[$stateToCheck]) ||
                    !function_exists('enum_exists') ||
                    !enum_exists($model->getCasts()[$stateToCheck])
                ) {
                    throw new StateEnumDoesntExistException("You need to define enum for your variable `{$stateToCheck}`");
                }

                if (count($state->initialState()) === 0) {
                    throw new InitailStateIsNotAllowedException("You need to define initial state array");
                }

                if (!$state->inInitialState()) {
                    $allowedStates = collect($state->initialState())
                        ->implode('value', ',');

                    throw new InitailStateIsNotAllowedException("Only allowed initial states: " . $allowedStates);
                }
            }
        });

        static::updating(function ($model) {
            foreach ($model->getStateMachines() as $stateToCheck) {
                $state = $model->getOriginal($stateToCheck);
                
                if (empty($state) || $state === $model->$stateToCheck) {
                    return;
                }
                
                if (
                    !isset($model->getCasts()[$stateToCheck]) ||
                    !function_exists('enum_exists') ||
                    !enum_exists($model->getCasts()[$stateToCheck])
                ) {
                    throw new StateEnumDoesntExistException("You need to define enum for your variable `{$stateToCheck}`");
                }

                if (count($state->transitions()) === 0) {
                    throw new StateTransitionNotAllowedException("You need to define transitions array");
                }

                if (!$state->canTransitTo($model->$stateToCheck)) {
                    $allowedStates = collect($state->transitions())
                        ->implode('value', ',');

                    throw new StateTransitionNotAllowedException("Only allowed transition states: " . $allowedStates);
                }
            }
        });
    }

    public function getStates()
    {
        return $this->states ?? [];
    }
}
