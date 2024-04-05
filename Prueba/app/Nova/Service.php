<?php

namespace App\Nova;

use App\Models\RoleUser;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Service>
     */
    public static $model = \App\Models\Service::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Servicio', 'name')
                ->rules('required', 'max:100'),
            Textarea::make('Descripción', 'description')->maxlength(250)
                ->rules('required'),
            Currency::make('Precio', 'price')->currency('USD')
                ->rules('required'),
            BelongsTo::make('Autor', 'author', 'App\Nova\User')
                ->rules('required'),
            BelongsToMany::make('Clientes', 'users', 'App\Nova\User'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    //Es funcion se llama cuando obtenemos los datos de la relacion con la tabla user
    public static function relatableUsers(NovaRequest $request, $query, Field $field)
    {
        $roleCliente = 2;
        $roleAdmin = 1;
        $roleSeleccionado = 0;
        //selecciona el rol que vamos a filtrar
        if ($field instanceof BelongsToMany) {
            $roleSeleccionado = $roleCliente;
        } else {
            $roleSeleccionado = $roleAdmin;
        }
        //filtra la tabla pibote por la coluna role_id usando el rol seleccionado
        $roles = RoleUser::where('role_id', $roleSeleccionado)
            ->pluck('user_id')
            ->toArray();

        return $query->whereIn('id', $roles);
    }
}
