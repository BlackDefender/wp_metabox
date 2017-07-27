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
		'id'    => 'mytextinput', // даем идентификатор.
		'type'  => 'text'  // Указываем тип поля.
	),
	array(
		'label' => 'Большое текстовое поле',
		'desc'  => 'Описание для поля.',
		'id'    => 'mytextarea',  //айдишник элемента, у инпутов используется в качестве имени. нужен при выборке метаданных
		'type'  => 'textarea'  // Указываем тип поля.
	),
	array(
		'label' => 'Чекбоксы (флажки)',
		'desc'  => 'Описание для поля.',
		'id'    => 'mycheckbox',  // даем идентификатор.
		'type'  => 'checkbox'  // Указываем тип поля.
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
        'id' => 'visual_editor', // только нижнее подчеркивание
        'type' => 'wysiwyg'
    ),
    array(
        'label' => 'Смешанный массив',
        'desc'  => 'Описание для поля.',
        'id'    => 'my_combo', // даем идентификатор.
        'type'  => 'combo',  // Указываем тип поля.
        'display' => 'list', // Способ отображения: list || gallery
        'internal-items' => array(
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
        'title' => 'Тексты для главной страницы',
    ),
    array(
        'post_type' => 'post',
        'meta_fields' => $some_meta_fields,
        'title' => 'Тексты для страницы поста',
    ),
);
