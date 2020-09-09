<?php
return [
    'rAdministrator' => [
        'type' => 1,
        'description' => 'Администратор системы',
        'children' => [
            'rUser',
            'rGuest',
            'rUnknownUser',
            'rModerator',
            'rDeveloper',
            'oRestClientAll',
            'oGiiManage',
            'oLangManage',
            'oRbacManage',
            'oBackendAll',
            'oLogreaderManage',
            'oOfflineManage',
            'oCleanerManage',
            'oNotifyManage',
            'oEncryptManage',
            'oVendorManage',
            'oGuideModify',
        ],
    ],
    'rUser' => [
        'type' => 1,
        'description' => 'Идентифицированный пользователь',
    ],
    'rGuest' => [
        'type' => 1,
        'description' => 'Гость системы',
    ],
    'rUnknownUser' => [
        'type' => 1,
        'description' => 'Не идентифицированный пользователь',
    ],
    'rRoot' => [
        'type' => 1,
        'description' => 'Корневой администратор системы',
        'children' => [
            'oBackendAll',
        ],
    ],
    'rModerator' => [
        'type' => 1,
        'description' => 'Модератор системы',
        'children' => [
            'oLangManage',
            'oBackendAll',
        ],
    ],
    'rDeveloper' => [
        'type' => 1,
        'description' => 'Разработчик',
        'children' => [
            'oRestClientAll',
            'oGiiManage',
            'oRbacManage',
            'oBackendAll',
        ],
    ],
    'oRestClientAll' => [
        'type' => 2,
        'description' => 'Доступ к REST-клиенту',
    ],
    'oGiiManage' => [
        'type' => 2,
        'description' => 'Доступ к Yii генератору',
    ],
    'oLangManage' => [
        'type' => 2,
        'description' => 'Управление языками',
    ],
    'oRbacManage' => [
        'type' => 2,
        'description' => 'Управление RBAC',
    ],
    'oBackendAll' => [
        'type' => 2,
        'description' => 'Доступ в админ панель',
    ],
    'oLogreaderManage' => [
        'type' => 2,
        'description' => 'Управление логами',
    ],
    'oOfflineManage' => [
        'type' => 2,
        'description' => 'Управление статусом оффлайн',
    ],
    'oCleanerManage' => [
        'type' => 2,
        'description' => 'Управление чистильщиком',
    ],
    'oNotifyManage' => [
        'type' => 2,
        'description' => 'Управление уведомлениями',
    ],
    'oEncryptManage' => [
        'type' => 2,
        'description' => 'Шифрование данных',
    ],
    'oVendorManage' => [
        'type' => 2,
        'description' => 'Управление композер-пакетами',
    ],
    'oGuideModify' => [
        'type' => 2,
        'description' => 'Редактирование руководства',
    ],
    'rTester' => [
        'type' => 1,
        'description' => 'Тестировщик',
        'children' => [
            'rUser',
            'rGuest',
            'rUnknownUser',
            'oRestClientAll',
            'oLangManage',
            'oRbacManage',
            'oBackendAll',
            'oLogreaderManage',
            'oNotifyManage',
        ],
    ],
];
