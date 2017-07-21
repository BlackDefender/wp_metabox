<?php
/* Пользовательские поля в посте */


// подключение скриптов и стилей
function add_metabox_scripts($hook) {
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_script('metabox-assets', get_template_directory_uri() . '/functions/assets/metabox.js', array('jquery', 'jquery-ui-sortable'));
		wp_enqueue_style('metabox-assets', get_template_directory_uri() . '/functions/assets/metabox.css');
	}
}
add_action('admin_enqueue_scripts', 'add_metabox_scripts');


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



function add_custom_meta_boxes(){
	// подключение metabox к конкретному посту
    global $post;
    if(!empty($post)) {
        if( $post->ID == 2 )
        {
            global $some_meta_fields;
            add_meta_box(
                'front_page_meta_box', // Идентификатор(id)
                'Тексты для главной страницы', // Заголовок области с мета-полями(title)
                'show_custom_metabox', // Вызов(callback)
                'page', // Где будет отображаться наше поле, в нашем случае на главной странице
                'normal',
                'high',
                $some_meta_fields);
        }
    }

    global $some_meta_fields;
    add_meta_box(
        'services_preview_meta_box', // Идентификатор(id)
        'Тексты для общей страницы услуг', // Заголовок области с мета-полями(title)
        'show_custom_metabox', // Вызов(callback)
        'post', // Где будет отображаться наше поле, в нашем случае в Записях
        'normal',
        'high',
	    $some_meta_fields);
}
add_action('add_meta_boxes', 'add_custom_meta_boxes'); // Запускаем функцию


// Отрисовка метаполей
function show_custom_metabox($post, $meta_fields) {
	// Выводим скрытый input, для верификации.
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    echo '<table class="form-table">';
    foreach ($meta_fields['args'] as $field) {
        // вывод заголовков
        if($field['type'] == 'header'){
            echo '<tr><td colspan="2"><h1 style="text-align: center">'.$field['label'].'</h1></td></tr>';
            continue;
        }
        // Получаем значение если оно есть для этого поля
        $meta = get_post_meta($post->ID, $field['id'], true);

        // Начинаем выводить таблицу
        echo '<tr><th>'.$field['label'];
        if(isset($field['desc']) && $field['desc'] != ''){
            echo '<br><span class="metabox-item-description">('.$field['desc'].')</span>';
        }
        echo '</th><td>';
        switch($field['type']) {
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_attr($meta).'" size="98" />';
                break;

            case 'textarea':
                echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="100" rows="4">'.esc_attr($meta).'</textarea>';
                break;

            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;

            case 'select':
                echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                }
                echo '</select>';
                break;

            case 'image':
                $image = wp_get_attachment_image_src($meta);
                $style = '';
                if($image){
                    $style = "background-image: url( $image[0] )";
                }
                ?>
                <div class="wrap">
                    <input type="hidden" name="<?= $field['id'] ?>" value="<?= $meta ?>">
                    <div class="image-preview add-image" style="<?= $style ?>"></div>
                </div>
                <?php
                break;

            case 'audio':
                ?>
                <div class="wrap">
                    <input type="hidden" name="<?= $field['id'] ?>" value="<?= $meta ?>">
                    <input type="text" class="filename-input" disabled value="<?= substr($meta, strrpos($meta, '/')+1) ?>">
                    <button class="button add-audio add-file-btn">Добавить/изменить аудиозапись</button>
                </div>
                <?php
                break;
            case 'pdf':
                ?>
                <div class="wrap">
                    <input type="hidden" name="<?= $field['id'] ?>" value="<?= $meta ?>">
                    <input type="text" class="filename-input" disabled value="<?= substr($meta, strrpos($meta, '/')+1) ?>">
                    <button class="button add-pdf add-file-btn">Добавить/изменить PDF</button>
                </div>
                <?php
                break;
	    case 'wysiwyg':
                wp_editor($meta, $field['id']);
                break;
            case 'posts-list':
                $posts_list = new WP_Query(array('post_type' => $field['target_post_type']));
                if($posts_list->have_posts()){
                    echo '<select name="'.$field['id'].'" class="posts-list">';
                    if(!$meta){
                        echo '<option disabled selected value="-1">'. $field['intro_text'] .'</option>';
                    }
                    for($i = 0; $i < count($posts_list->posts); ++$i){
                        echo '<option value="'. $posts_list->posts[$i]->ID .'" ',  $meta == $posts_list->posts[$i]->ID ? ' selected="selected"' : '', '>'. $posts_list->posts[$i]->post_title .'</option>';
                    }
                    echo '</select>';
                }
                break;
            case 'combo':
                $internal_items_json = json_encode($field['internal-items']);
                if($meta){
		            foreach ($meta as $combo_item_index => $combo_item_val){
                        foreach ($combo_item_val as $i => $val){
                            if($field['data-description'][$i]['type'] == 'image'){
                                $src = wp_get_attachment_image_src($val)[0];
                                $meta[$combo_item_index][$i] = array('id' => $val, 'src' => $src);
                            }
                    	}
                    }
                    $meta_json = json_encode($meta);
                }else{
                    $meta_json = '';
                }
                ?>
                <ul class="combo <?= $field['display'] ?>"
                    data-internal-items='<?= $internal_items_json ?>'
                    data-meta='<?= $meta_json ?>'
                    data-id="<?= $field['id'] ?>"
                    data-get-image-url="<?= get_template_directory_uri(); ?>/functions/assets/get-image-thumbnail-url.php"></ul>
                <button class="button add-combo-item">Добавить элемент</button>
                <?php
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

// Функция для сохранения
function save_custom_meta_fields($post_id){
    // проверяем наш проверочный код
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) return;
    // Проверяем авто-сохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    // Проверяем права доступа
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) return;
    } elseif (!current_user_can('edit_post', $post_id)) return;


    // определяем переменную с описанием полей
    $fields = NULL;
    $post_type = get_post_type($post_id);

    switch ($post_type) {
        case 'page':
            switch($post_id){
                case 2:
                    global $some_meta_fields;
                    $fields = $some_meta_fields;
                    break;
            }
            break;
        case 'post':
            global $some_meta_fields;
            $fields = $some_meta_fields;
            break;
    }

    if(is_null($fields)){
        return;
    }

    // Если все отлично, прогоняем массив через foreach
    foreach ($fields as $field) {
        // Тип header предназначен для вывода заголовков в таблице. Там нет никакой информации.
        if($field['type'] == 'header') continue;

        $old = get_post_meta($post_id, $field['id'], true); // Получаем старые данные (если они есть), для сверки
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {  // Если данные новые
            update_post_meta($post_id, $field['id'], $new); // Обновляем данные
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old); // Если данных нет, удаляем мету.
        }
    }
}
add_action('save_post', 'save_custom_meta_fields'); // Запускаем функцию сохранения

