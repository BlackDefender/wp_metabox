# wp_metabox
Custom metaboxes for WordPress

## Installation
Add this string into your functions.php file:

include_once 'functions/meta-fields.php';

## Description
There is a few data types available:
* Text input
* Textarea
* Checkbox
* Select
* Posts select
* Image
* Audio file
* PDF file
* List with combination of previous types

## Usage
### 1. Create array with metafields description

Block header
```
array(
  'label' => 'Текст заголовка',
  'type'  => 'header'
),
```

Text input
```
array(
  'label' => 'Текстовое поле',
  'desc'  => 'Описание для поля.',
  'id'    => 'mytextinput', // даем идентификатор.
  'type'  => 'text'  // Указываем тип поля.
),
```

Textarea
```
array(
  'label' => 'Большое текстовое поле',
  'desc'  => 'Описание для поля.',
  'id'    => 'mytextarea',  //айдишник элемента, у инпутов используется в качестве имени. нужен при выборке метаданных
  'type'  => 'textarea'  // Указываем тип поля.
),
```

Checkbox
```
array(
  'label' => 'Чекбоксы (флажки)',
  'desc'  => 'Описание для поля.',
  'id'    => 'mycheckbox',  // даем идентификатор.
  'type'  => 'checkbox'  // Указываем тип поля.
),
```

Select
```
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
```
  
Posts select
```
array(
  'label' => 'Список заголовков постов',
  'desc'  => '',
  'id'    => 'author',
  'type'  => 'posts-list',
  'target_post_type' => 'workers',// тип постов для вывода
  'intro_text' => 'Вступительный текст для первого пункта меню'
),
```
Image
```
array(
  'label' => 'Изображение',
  'desc'  => 'Выберите изображение',
  'id'    => 'my_image',  //айдишник элемента, у инпутов используется в качестве имени. нужен при выборке метаданных
  'type'  => 'image'  // Указываем тип поля.
),
```

Audio file
```
array(
  'label' => 'Аудиозапись',
  'id' => 'audio',
  'type' => 'audio'
),
```

PDF file
```
array(
    'label' => 'PDF-файл',
    'id' => 'pdf',
    'type' => 'pdf'
),
```

List with combination of different types
```
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
```
