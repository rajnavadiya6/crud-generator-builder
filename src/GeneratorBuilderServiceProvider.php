<?php

namespace Crud\GeneratorBuilder;

use Illuminate\Support\ServiceProvider;
use Crud\GeneratorBuilder\Commands\GeneratorBuilderRoutesPublisherCommand;
use Crud\GeneratorBuilder\Commands\API\APIControllerGeneratorCommand;
use Crud\GeneratorBuilder\Commands\API\APIGeneratorCommand;
use Crud\GeneratorBuilder\Commands\API\APIRequestsGeneratorCommand;
use Crud\GeneratorBuilder\Commands\API\TestsGeneratorCommand;
use Crud\GeneratorBuilder\Commands\APIScaffoldGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Common\MigrationGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Common\ModelGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Common\RepositoryGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Publish\GeneratorPublishCommand;
use Crud\GeneratorBuilder\Commands\Publish\LayoutPublishCommand;
use Crud\GeneratorBuilder\Commands\Publish\PublishStislaLayout;
use Crud\GeneratorBuilder\Commands\Publish\PublishTemplateCommand;
use Crud\GeneratorBuilder\Commands\Publish\PublishUserCommand;
use Crud\GeneratorBuilder\Commands\RollbackGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Scaffold\ControllerGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Scaffold\RequestsGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Scaffold\ViewsGeneratorCommand;
use Crud\GeneratorBuilder\Commands\Scaffold\ScaffoldGeneratorCommand;

class GeneratorBuilderServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/generator_builder.php';

        $this->publishes([
            $configPath => config_path('crud/generator_builder.php'),
        ], 'generator_builder.config');

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../views/', 'generator-builder');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('crud.publish.gui', function ($app) {
            return new GeneratorBuilderRoutesPublisherCommand();
        });

        $this->app->singleton('crud.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('crud.api', function ($app) {
            return new APIGeneratorCommand();
        });

        $this->app->singleton('crud.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('crud.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('crud.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('crud.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('crud.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('crud.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('crud.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('crud.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('crud.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('crud.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('crud.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('crud.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('crud.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('crud.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->app->singleton('crud.publish.user', function ($app) {
            return new PublishUserCommand();
        });

        $this->app->singleton('crud.publish.stisla', function ($app) {
            return new PublishStislaLayout();
        });

        $this->commands([
            'crud.publish.gui',
            'crud.publish',
            'crud.api',
            'crud.scaffold',
            'crud.api_scaffold',
            'crud.publish.layout',
            'crud.publish.templates',
            'crud.migration',
            'crud.model',
            'crud.repository',
            'crud.api.controller',
            'crud.api.requests',
            'crud.api.tests',
            'crud.scaffold.controller',
            'crud.scaffold.requests',
            'crud.scaffold.views',
            'crud.rollback',
            'crud.publish.user',
            'crud.publish.stisla',
        ]);
    }
}
