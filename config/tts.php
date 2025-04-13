<?php

return [
    'credentials_path' => storage_path('app/google/google-tts.json'),

    'languages' => [
        'en' => [
            'languageCode' => 'en-US',
            'gender' => 'FEMALE',
            'voice' => 'en-US-Wavenet-D', // إضافة خيار للصوت
        ],
        'fr' => [
            'languageCode' => 'fr-FR',
            'gender' => 'FEMALE',
            'voice' => 'fr-FR-Wavenet-B', // إضافة خيار للصوت
        ],
        'ar' => [
            'languageCode' => 'ar-XA',
            'gender' => 'FEMALE',
            'voice' => 'ar-XA-Wavenet-A', // إضافة خيار للصوت
        ],
    ],
];
