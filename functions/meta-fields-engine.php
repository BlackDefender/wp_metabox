<?php
/* Пользовательские поля в посте */


// подключение скриптов для галереи
function add_metabox_scripts($hook) {
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_script('metabox-assets', get_template_directory_uri() . '/functions/assets/metabox.js', array('jquery', 'jquery-ui-sortable'));
		wp_enqueue_style('metabox-assets', get_template_directory_uri() . '/functions/assets/metabox.css');
	}
}
add_action('admin_enqueue_scripts', 'add_metabox_scripts');


require_once 'meta-fields-data.php';

function add_custom_meta_box(){
    // подключение metabox к конкретному посту
    global $post;
    global $meta_boxes;
    foreach ($meta_boxes as $box_index => $box){
        if($post->post_type == $box['post_type']){
            if(isset($box['post_id'])){
                if(is_array($box['post_id'])){
                    if(!in_array($post->ID, $box['post_id'])) continue;
                }else{
                    if($box['post_id'] != $post->ID) continue;
                }
            }

	    if(isset($box['template']) && $box['template'] != get_post_meta( $post->ID, '_wp_page_template', true )){
                continue;
            }

            add_meta_box(
                $box['post_type'].'_meta_box_'.$box_index, // Идентификатор(id)
                isset($box['title']) ? $box['title'] : 'Данные для страницы', // Заголовок области с мета-полями(title)
                'show_custom_metabox', // Вызов(callback)
                $box['post_type'], // Где будет отображаться наше поле, в нашем случае на главной странице
                'normal',
                'high',
                $box['meta_fields']);
        }
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box'); // Запускаем функцию


// Отрисовка метаполей
function show_custom_metabox($post, $meta_fields) {
	// Выводим скрытый input, для верификации.
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    echo '<table class="form-table">';
    foreach ($meta_fields['args'] as $field) {
        // вывод заголовков
        if($field['type'] == 'header'){
            echo '<tr><td colspan="2"><div class="metabox-header">'.$field['label'].'</div></td></tr>';
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
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.format_to_edit($meta).'" size="98" />';
                break;

            case 'textarea':
                echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="100" rows="4">'.format_to_edit($meta).'</textarea>';
                break;

            case 'checkbox':
                echo '<input type="checkbox" value="1" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>';
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
                    <div class="image-preview add-image"<?= empty($style)? '': ' style="'.$style.'"'; ?>><div class="remove"></div></div>
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
            case 'wysiwyg':
                wp_editor($meta, $field['id']);
                break;
            case 'combo':
                $data_description = json_encode($field['data-description']);
                if($meta){
                    foreach ($meta as $combo_item_index => $combo_item_val){
                        foreach ($combo_item_val as $i => $val){
                            if($field['data-description'][$i]['type'] == 'image'){
                                if($val !== ''){
                                    $src = wp_get_attachment_image_src($val)[0];
                                }else{
                                    $src = '';
                                }
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
                    data-data-description='<?= $data_description ?>'
                    data-id="<?= $field['id'] ?>"
                    data-get-image-url="<?= get_template_directory_uri(); ?>/functions/assets/get-image-thumbnail-url.php"></ul>
                <button class="button add-combo-item-btn <?= $field['behavior']; ?>">Добавить элемент</button>
                <script type="combo-data"><?= $meta_json; ?></script>
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
    $post_type = get_post_type($post_id);

    global $meta_boxes;
    foreach ($meta_boxes as $box){
        if($post_type == $box['post_type']){
            if(isset($box['post_id'])){
                if(is_array($box['post_id'])){
                    if(!in_array($post_id, $box['post_id'])) continue;
                }else{
                    if($box['post_id'] != $post_id) continue;
                }
            }
			if(isset($box['template']) && $box['template'] != get_post_meta( $post_id, '_wp_page_template', true )){
                continue;
            }
			foreach ($box['meta_fields'] as $field) {
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
    }
}
add_action('save_post', 'save_custom_meta_fields'); // Запускаем функцию сохранения

