<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

trait Authorizable
{
    /**
     * List of default method names of the Controllers and the related permission.
     */
    private $abilities = [
        'index' => 'view',
        'index_data' => 'view',
        'index_list' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete',
        'restore' => 'restore',
        'trashed' => 'restore',
    ];

    /**
     * Override of callAction to perform the authorization before.
     *
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            Gate::authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        $routeName = explode('.', Route::currentRouteName());
        $action = Arr::get($this->getAbilities(), $method);

        return $action ? $action.'_'.$routeName[1] : null;
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }

    private function getAbilities()
    {
        return $this->abilities;
    }
}
