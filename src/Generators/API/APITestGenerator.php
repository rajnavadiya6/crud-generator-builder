<?php

namespace Crud\GeneratorBuilder\Generators\API;

use Crud\GeneratorBuilder\Common\CommandData;
use Crud\GeneratorBuilder\Generators\BaseGenerator;
use Crud\GeneratorBuilder\Utils\FileUtil;

class APITestGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $fileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathApiTests;
        $this->fileName = $this->commandData->modelName.'ApiTest.php';
    }

    public function generate()
    {
        $templateData = get_template('api.test.api_test', 'generator-builder');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandObj->comment("\nApiTest created: ");
        $this->commandData->commandObj->info($this->fileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('API Test file deleted: '.$this->fileName);
        }
    }
}
