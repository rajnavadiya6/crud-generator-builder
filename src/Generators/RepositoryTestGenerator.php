<?php

namespace Crud\GeneratorBuilder\Generators;

use Crud\GeneratorBuilder\Common\CommandData;
use Crud\GeneratorBuilder\Utils\FileUtil;

class RepositoryTestGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $fileName;

    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = config('crud.generator_builder.path.repository_test', base_path('tests/Repositories/'));
        $this->fileName = $this->commandData->modelName.'RepositoryTest.php';
    }

    public function generate()
    {
        $templateData = get_template('test.repository_test', 'generator-builder');

        $templateData = $this->fillTemplate($templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandObj->comment("\nRepositoryTest created: ");
        $this->commandData->commandObj->info($this->fileName);
    }

    private function fillTemplate($templateData)
    {
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        return $templateData;
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Repository Test file deleted: '.$this->fileName);
        }
    }
}
