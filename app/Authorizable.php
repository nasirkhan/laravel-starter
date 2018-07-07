<?php

namespace App;

trait Authorizable
{
    private $abilities = [
        'index'   => 'view',
        'edit'    => 'edit',
        'show'    => 'view',
        'update'  => 'edit',
        'create'  => 'add',
        'store'   => 'add',
        'destroy' => 'delete',
        'restore' => 'restore',
        'trashed' => 'restore',
    ];

    /**
     * Override of callAction to perform the authorization before.
     *
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            // dd($ability);
            // dd(auth()->user()->hasPermissionTo($ability));
            // dd(auth()->user()->getAllPermissions());
            // dd($ability);
            $this->authorize($ability);


            if (!auth()->user()->hasPermissionTo($ability)) {
                abort(403);
            } else {

            }
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        $routeName = explode('.', \Request::route()->getName());
        $action = array_get($this->getAbilities(), $method);

        \Debugbar::info('$routeName:'.$routeName[1]);
        \Debugbar::info('$action:'.$action);
        \Debugbar::info('$action:'.$action.'_'.$routeName[1]);

        return $action ? $action.'_'.$routeName[1] : null;
    }

    private function getAbilities()
    {
        return $this->abilities;
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}
