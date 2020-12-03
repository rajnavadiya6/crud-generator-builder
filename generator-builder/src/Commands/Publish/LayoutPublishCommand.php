<?php

namespace Crud\GeneratorBuilder\Commands\Publish;

use Illuminate\Support\Str;
use Crud\GeneratorBuilder\Utils\FileUtil;
use Symfony\Component\Console\Input\InputOption;

class LayoutPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud.publish:layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes auth files';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->copyView();
        $this->publishHomeController();
    }

    private function copyView()
    {
        $viewsPath = config('crud.generator_builder.path.views', resource_path('views/'));
        $templateType = config('crud.generator_builder.templates', 'generator-builder');

        $this->createDirectories($viewsPath);

        if ($this->option('localized')) {
            $files = $this->getLocaleViews();
        } else {
            $files = $this->getViews();
        }

        foreach ($files as $stub => $blade) {
            $sourceFile = get_template_file_path('scaffold/'.$stub, $templateType);
            $destinationFile = $viewsPath.$blade;
            $this->publishFile($sourceFile, $destinationFile, $blade);
        }
        // Publish Package.json and webpack mix
        $rootViews = [
            'vendors/package' => 'package.json',
            'vendors/webpack' => 'webpack.mix.js',
        ];

        foreach ($rootViews as $stub => $blade) {
            $sourceFile = get_template_file_path('scaffold/'.$stub, $templateType);
            $destinationFile = base_path($blade);
            $this->publishFile($sourceFile, $destinationFile, $blade);
        }

        $assets = [
            'vendors/public/img'       => 'public/img',
            'vendors/public/js'        => 'public/js',
            'vendors/resources/assets' => 'resources/assets',
            'vendors/resources/js'     => 'resources/js',
            'vendors/seeds'            => 'database/seeders',
        ];

        foreach ($assets as $asset => $destination) {
            $sourceFile = get_template_directory('scaffold/'.$asset, $templateType);
            $destinationFile = base_path($destination);
            $this->publishDirectory($sourceFile, $destinationFile, $destination);
        }

    }

    private function createDirectories($viewsPath)
    {
        FileUtil::createDirectoryIfNotExist($viewsPath.'layouts');
        FileUtil::createDirectoryIfNotExist($viewsPath.'auth');

        FileUtil::createDirectoryIfNotExist($viewsPath.'auth/passwords');
        FileUtil::createDirectoryIfNotExist($viewsPath.'auth/emails');
    }

    private function getViews()
    {
        $views = [
            'layouts/app'             => 'layouts/app.blade.php',
            'layouts/sidebar'         => 'layouts/sidebar.blade.php',
            'layouts/menu'            => 'layouts/menu.blade.php',
            'layouts/footer'          => 'layouts/footer.blade.php',
            'auth/login'              => 'auth/login.blade.php',
            'auth/register'           => 'auth/register.blade.php',
            'emails/password'         => 'auth/emails/password.blade.php',
            'auth/auth_app'           => 'layouts/auth_app.blade.php',
            'auth/forgot-password'    => 'auth/forgot-password.blade.php',
            'auth/reset-password'     => 'auth/reset-password.blade.php',
            'layouts/header'          => 'layouts/header.blade.php',
            'profile/change_password' => 'profile/change_password.blade.php',
            'profile/edit_profile'    => 'profile/edit_profile.blade.php',
            'auth/verify'             => 'auth/verify.blade.php',
        ];

        $version = $this->getApplication()->getVersion();
        if (Str::contains($version, '6.')) {
            $verifyView = [
                'auth/verify_6' => 'auth/verify.blade.php',
            ];
        } else {
            $verifyView = [
                'auth/verify' => 'auth/verify.blade.php',
            ];
        }

        $views = array_merge($views, $verifyView);

        return $views;
    }

    private function getLocaleViews()
    {
        return [
            'layouts/app_locale'     => 'layouts/app.blade.php',
            'layouts/sidebar_locale' => 'layouts/sidebar.blade.php',
            'layouts/datatables_css' => 'layouts/datatables_css.blade.php',
            'layouts/datatables_js'  => 'layouts/datatables_js.blade.php',
            'layouts/menu'           => 'layouts/menu.blade.php',
            'layouts/home'           => 'home.blade.php',
            'auth/login_locale'      => 'auth/login.blade.php',
            'auth/register_locale'   => 'auth/register.blade.php',
            'auth/email_locale'      => 'auth/passwords/email.blade.php',
            'auth/reset_locale'      => 'auth/passwords/reset.blade.php',
            'emails/password_locale' => 'auth/emails/password.blade.stub',
        ];
    }

    private function publishHomeController()
    {
        $templateData = get_template('home_controller', 'generator-builder');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = config('crud.generator_builder.path.controller', app_path('Http/Controllers/'));

        $fileName = 'HomeController.php';

        if (file_exists($controllerPath.$fileName) && ! $this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('HomeController created');
    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param  string  $templateData
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('crud.generator_builder.namespace.controller'),
            $templateData
        );

        $templateData = str_replace(
            '$NAMESPACE_REQUEST$',
            config('crud.generator_builder.namespace.request'),
            $templateData
        );

        return $templateData;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['localized', null, InputOption::VALUE_NONE, 'Localize files.'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
