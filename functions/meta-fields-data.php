<?php

// описание полей
/*
$exampleFieldsSet = [
    [
        'label' => 'Текст заголовка',
        'type'  => 'header'// большой заголовок посреди таблицы
    ],
    [
        'label' => 'Текстовое поле',
        'desc'  => 'Описание для поля.',
        'id'    => 'mytextinput',
        'type'  => 'text'
    ],
    [
        'label' => 'Большое текстовое поле',
        'desc'  => 'Описание для поля.',
        'id'    => 'mytextarea',
        'type'  => 'textarea'
    ],
    [
        'label' => 'Чекбоксы (флажки]',
        'desc'  => 'Описание для поля.',
        'id'    => 'mycheckbox',
        'type'  => 'checkbox'
    ],
    [
        'label' => 'Всплывающий список',
        'desc'  => 'Описание для поля.',
        'id'    => 'myselect',
        'type'  => 'select',
        'options' => [  // Параметры, всплывающие данные
            'one' => [
                'label' => 'Вариант 1',  // Название поля
                'value' => '1'  // Значение
            ],
            'two' => [
                'label' => 'Вариант 2',  // Название поля
                'value' => '2'  // Значение
            ],
            'three' => [
                'label' => 'Вариант 3',  // Название поля
                'value' => '3'  // Значение
            ]
        ]
    ],
    [
        'label' => 'Список заголовков постов',
        'desc'  => '',
        'id'    => 'author',
        'type'  => 'posts-list',
        'target_post_type' => 'workers',// тип постов для вывода
        'intro_text' => 'Вступительный текст для первого пункта меню'
    ],

    [
        'label' => 'Изображение',
        'desc'  => 'Выберите изображение',
        'id'    => 'my_image',  //айдишник элемента, у инпутов используется в качестве имени. нужен при выборке метаданных
        'type'  => 'image'  // Указываем тип поля.
    ],
    [
        'label' => 'Аудиозапись',
        'id' => 'audio',
        'type' => 'audio'
    ],
    [
        'label' => 'PDF-файл',
        'id' => 'pdf',
        'type' => 'pdf'
    ],
    [
        'label' => 'Визуальный редактор',
        'id' => 'visual_editor', // только нижнее подчеркивание. с тире будет ошибка
        'type' => 'wysiwyg'
    ],
    [
        'label' => 'Галерея',
        'desc'  => 'Описание для поля.',
        'id'    => 'my_combo_gallery', // даем идентификатор.
        'type'  => 'combo',  // Указываем тип поля.
        'display' => 'line', // stack || line
        'behavior' => 'gallery', // list || gallery
        'data-description' => [
            [
                'type' => 'image',
                'label' => 'Изображение'
            ],
            [
                'type' => 'text',
                'label' => 'Текстовый ввод',
            ],
        ]
    ],
    [
        'label' => 'Смешанный массив',
        'desc'  => 'Описание для поля.',
        'id'    => 'my_combo', // даем идентификатор.
        'type'  => 'combo',  // Указываем тип поля.
        'display' => 'stack', //  stack || line
        'behavior' => 'list', // list || gallery
        'data-description' => [
            [
                'type' => 'text',
                'label' => 'Текстовый ввод',
            ],
            [
                'type' => 'textarea',
                'label' => 'Текстовое поле'
            ],
            [
                'type' => 'image',
                'label' => 'Изображение'
            ],
            [
                'type' => 'audio',
                'label' => 'Аудиозапись'
            ],
            [
                'type' => 'pdf',
                'label' => 'PDF'
            ],
        ]
    ],
];
*/


// metaboxes description
$meta_boxes = [
/*
    [
        'post_type' => 'page',
        'post_id' => '2',
        'meta_fields' => $exampleFieldsSet,
        'title' => 'Данные для страницы',
    ],
    [
        'post_type' => 'page',
        'post_id' => [3, 4, 5],
        'meta_fields' => $exampleFieldsSet,
        'title' => 'Данные для страницы',
    ],
	[
        'post_type' => 'page',
        'post_not_id' => ['2', 3, 4],
        'meta_fields' => $exampleFieldsSet,
        'title' => 'Данные для страницы',
    ],
    [
        'post_type' => 'post',
        'meta_fields' => $exampleFieldsSet,
        'title' => 'Данные для страницы',
    ],
    [
        'template' => 'page-sample.php',
        'post_type' => 'page',
        'meta_fields' => $exampleFieldsSet,
        'title' => 'Данные для страницы',
    ],
	[
        'template' => ['page-sample.php', 'page-other.php'],
        'post_type' => 'page',
        'meta_fields' => $exampleFieldsSet,
        'title' => 'Данные для страницы',
    ],
	*/
];
