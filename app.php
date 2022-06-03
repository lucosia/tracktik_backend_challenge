<?php

require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Console\Application;
use App\Console\Command\TestScenariosTotalCommand;

$application = new Application();
$application->add(new TestScenariosTotalCommand());
$application->run();