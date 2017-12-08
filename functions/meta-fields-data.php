<?php

// описание полей
$some_meta_fields = array(
    array(
        'label' => 'Текст заголовка',
        'type'  => 'header'// большой заголовок посреди таблицы
    ),
    array(
        'label' => 'Текстовое поле',
        'desc'  => 'Описание для поля.',
        'id'    => 'mytextinput',
        'type'  => 'text'
    ),
    array(
        'label' => 'Большое текстовое поле',
        'desc'  => 'Описание для поля.',
        'id'    => 'mytextarea',
        'type'  => 'textarea'
    ),
    array(
        'label' => 'Чекбоксы (флажки)',
        'desc'  => 'Описание для поля.',
        'id'    => 'mycheckbox',
        'type'  => 'checkbox'
    ),
    array(
        'label' => 'Всплывающий список',
        'desc'  => 'Описание для поля.',
        'id'    => 'myselect',
        'type'  => 'select',
        'options' => array (  // Параметры, всплывающие данные
            'one' => array (
                'label' => 'Вариант 1',  // Название поля
                'value' => '1'  // Значение
            ),
            'two' => array (
                'label' => 'Вариант 2',  // Название поля
                'value' => '2'  // Значение
            ),
            'three' => array (
                'label' => 'Вариант 3',  // Название поля
                'value' => '3'  // Значение
            )
        )
    ),
    array(
        'label' => 'Список заголовков постов',
        'desc'  => '',
        'id'    => 'author',
        'type'  => 'posts-list',
        'target_post_type' => 'workers',// тип постов для вывода
        'intro_text' => 'Вступительный текст для первого пункта меню'
    ),

    array(
        'label' => 'Изображение',
        'desc'  => 'Выберите изображение',
        'id'    => 'my_image',  //айдишник элемента, у инпутов используется в качестве имени. нужен при выборке метаданных
        'type'  => 'image'  // Указываем тип поля.
    ),
    array(
        'label' => 'Аудиозапись',
        'id' => 'audio',
        'type' => 'audio'
    ),
    array(
        'label' => 'PDF-файл',
        'id' => 'pdf',
        'type' => 'pdf'
    ),
    array(
        'label' => 'Визуальный редактор',
        'id' => 'visual_editor', // только нижнее подчеркивание. с тире будет ошибка
        'type' => 'wysiwyg'
    ),
    array(
        'label' => 'Галерея',
        'desc'  => 'Описание для поля.',
        'id'    => 'my_combo_gallery', // даем идентификатор.
        'type'  => 'combo',  // Указываем тип поля.
        'display' => 'line', // stack || line
        'behavior' => 'gallery', // list || gallery
        'data-description' => array(
            array(
                'type' => 'image',
                'label' => 'Изображение'
            ),
            array(
                'type' => 'text',
                'label' => 'Текстовый ввод',
            ),
        )
    ),
    array(
        'label' => 'Смешанный массив',
        'desc'  => 'Описание для поля.',
        'id'    => 'my_combo', // даем идентификатор.
        'type'  => 'combo',  // Указываем тип поля.
        'display' => 'stack', //  stack || line
        'behavior' => 'list', // list || gallery
        'data-description' => array(
            array(
                'type' => 'text',
                'label' => 'Текстовый ввод',
            ),
            array(
                'type' => 'textarea',
                'label' => 'Текстовое поле'
            ),
            array(
                'type' => 'image',
                'label' => 'Изображение'
            ),
            array(
                'type' => 'audio',
                'label' => 'Аудиозапись'
            ),
            array(
                'type' => 'pdf',
                'label' => 'PDF'
            ),
        )
    ),
);


// metaboxes description
$meta_boxes = array(
    array(
        'post_type' => 'page',
        'post_id' => '2',
        'meta_fields' => $some_meta_fields,
        'title' => 'Данные для страницы',
    ),
    array(
        'post_type' => 'page',
        'post_id' => array(3, 4, 5),
        'meta_fields' => $some_meta_fields,
        'title' => 'Данные для страницы',
    ),
    array(
        'post_type' => 'post',
        'meta_fields' => $some_meta_fields,
        'title' => 'Данные для страницы',
    ),
    array(
        'template' => 'page-sample.php',
        'post_type' => 'page',
        'meta_fields' => $some_meta_fields,
        'title' => 'Данные для страницы',
    ),
);
