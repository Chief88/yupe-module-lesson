<?php
/**
 * Файл конфигурации модуля lesson
 *
 * @author Chief88 <serg.latyshkov@gmail.com>
 */
return [
    'module'   => [
        'class'  => 'application.modules.lesson.LessonModule',
    ],
    'import'    => [
        'application.modules.lesson.models.*',
    ],
    'component' => [],
    'rules'     => [
        '/lessons' => 'lesson/lesson/index',
        '/lessons/<slug>' => 'lesson/lesson/show',
    ],
];