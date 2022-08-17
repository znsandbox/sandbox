<?php

$virtualMachineName = $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'];
$virtualBoxDirectory = $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'];
$backupZipFile = $_ENV['DEPLOYER_VIRTUAL_BOX_BACKUP_FILE'];

return [
    'title' => 'Hard reset server',
    'tasks' => [

        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\ShutdownServerTask::class,
            'name' => $virtualMachineName,
        ],

        /*[
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\WaitServerTask::class,
            'action' => 'shutdown',
            'title' => '  Wait for the server to shutdown',
        ],*/

        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common\WaitTask::class,
            'second' => 5,
            'title' => '  Wait for the server to shutdown',
        ],

        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\RemoveServerTask::class,
            'name' => $virtualMachineName,
            'directory' => $virtualBoxDirectory,
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\RestoreServerTask::class,
            'directory' => $virtualBoxDirectory,
            'backup' => $backupZipFile,
        ],

        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\StartServerTask::class,
            'name' => $virtualMachineName,
        ],

        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common\WaitTask::class,
            'second' => 10,
            'title' => '  Wait for the server to start',
        ],

        /*[
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\WaitServerTask::class,
            'action' => 'start',
            'title' => '  Wait for the server to start',
        ],*/
    ]
];
