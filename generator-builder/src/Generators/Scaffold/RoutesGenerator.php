<?php

namespace Crud\GeneratorBuilder\Generators\Scaffold;

use Illuminate\Support\Str;
use Crud\GeneratorBuilder\Common\CommandData;

class RoutesGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $routeContents;

    /** @var string */
    private $routesTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathRoutes;
        $this->routeContents = file_get_contents($this->path);
        if (! empty($this->commandData->config->prefixes['route'])) {
            $this->routesTemplate = get_template('scaffold.routes.prefix_routes', 'generator-builder');
        } else {
            $this->routesTemplate = get_template('scaffold.routes.routes', 'generator-builder');
        }
        $this->routesTemplate = fill_template($this->commandData->dynamicVars, $this->routesTemplate);
    }

    public function generate()
    {
        $this->routeContents .= "\n\n".$this->routesTemplate;
        $existingRouteContents = file_get_contents($this->path);
        if (Str::contains($existingRouteContents, "Route::resource('".$this->commandData->config->mSnakePlural."',")) {
            $this->commandData->commandObj->info('Route '.$this->commandData->config->mPlural.' is already exists, Skipping Adjustment.');

            return;
        }

        file_put_contents($this->path, $this->routeContents);
        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' routes added.');
    }

    public function rollback()
    {
        if (Str::contains($this->routeContents, $this->routesTemplate)) {
            $this->routeContents = str_replace($this->routesTemplate, '', $this->routeContents);
            file_put_contents($this->path, $this->routeContents);
            $this->commandData->commandComment('scaffold routes deleted');
        }
    }
}
