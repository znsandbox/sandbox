<?php

$vmName = $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'];
$vmDirectory = $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'];
$vmBackup = $_ENV['DEPLOYER_VIRTUAL_BOX_BACKUP_FILE'];

return [
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\ShutdownServerTask::class,
        'name' => $vmName,
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
        'name' => $vmName,
        'directory' => $vmDirectory,
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\RestoreServerTask::class,
        'directory' => $vmDirectory,
        'backup' => $vmBackup,
    ],

    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\StartServerTask::class,
        'name' => $vmName,
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
];
