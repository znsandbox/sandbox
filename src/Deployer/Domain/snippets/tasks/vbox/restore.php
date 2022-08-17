<?php

//$vmName = $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'];
//$vmDirectory = $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'];
//$vmBackup = $_ENV['DEPLOYER_VIRTUAL_BOX_BACKUP_FILE'];

return [
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\ShutdownServerTask::class,
        'vmName' => $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'],
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
        'vmName' => $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'],
        'vmDirectory' => $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'],
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\RestoreServerTask::class,
        'vmDirectory' => $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'],
        'vmBackup' => $_ENV['DEPLOYER_VIRTUAL_BOX_BACKUP_FILE'],
    ],
    
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox\StartServerTask::class,
        'vmName' => $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'],
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
