jQuery(function($) {

    var file_frame;

    /* Image */
    $(document).on('click', '.add-image', function(e) {
        var that = $(this);
        if (file_frame) file_frame.close();
        file_frame = wp.media({
            title: 'Добавить изображение',
            button:{
                text: 'Добавить изображение'
            },
            multiple: false
        });
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            if(attachment.type !== 'image') return;
            var imageURL = '';
            if(attachment.sizes.thumbnail) imageURL = attachment.sizes.thumbnail.url;
            else if(attachment.sizes.medium) imageURL = attachment.sizes.medium.url;
            else if(attachment.sizes.full) imageURL = attachment.sizes.full.url;
            that.parent().find('input:hidden').attr('value', attachment.id);
            that.css('background-image', 'url('+imageURL+')');
        });
        file_frame.open();
    });

    /* PDF */
    $(document).on('click', '.add-pdf', function(e) {
        e.preventDefault();
        var that = $(this);
        if (file_frame) file_frame.close();
        file_frame = wp.media({
            title: 'Добавить PDF',
            button:{
                text: 'Добавить PDF'
            },
            multiple: false
        });
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            if(attachment.subtype !== 'pdf') return;
            that.parent().find('input[type="hidden"]').attr('value', attachment.url);
            that.parent().find('input[type="text"]').val( attachment.filename);
        });
        file_frame.open();
    });

    /* Audio */
    $(document).on('click', '.add-audio', function(e) {
        e.preventDefault();
        var that = $(this);
        if (file_frame) file_frame.close();
        file_frame = wp.media({
            title: 'Добавить аудиозапись',
            button:{
                text: 'Добавить аудиозапись'
            },
            multiple: false
        });
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            if(attachment.type !== 'audio') return;
            that.parent().find('input[type="hidden"]').attr('value', attachment.url);
            that.parent().find('input[type="text"]').attr('value', attachment.filename);
        });
        file_frame.open();
    });


    /* Combo */
    if(document.querySelector('.combo')){
        Array.prototype.forEach.call(document.querySelectorAll('.combo'), function (currentCombo) {
            var $currentCombo = $(currentCombo);
            var internalItems = $currentCombo.data('internal-items');
            currentCombo.internalTypes = internalItems;
            var currentComboItemHTML = '<li>';
            internalItems.forEach(function (item) {
                currentComboItemHTML += '<div class="combo-item-field-wrap">';
                    currentComboItemHTML += '<div class="combo-item-field-title">'+ item.label +'</div>';
                    currentComboItemHTML += '<div class="combo-item-field-body">';
                    switch(item.type){
                        case 'text':
                            currentComboItemHTML += '<input type="text">';
                            break;
                        case 'textarea':
                            currentComboItemHTML += '<textarea></textarea>';
                            break;
                        case 'image':
                            currentComboItemHTML += '<input type="hidden"><div class="image-preview add-image"></div>';
                            break;
                        case 'audio':
                            currentComboItemHTML += '<input type="hidden">' +
                                '<input type="text" disabled class="no-index filename-input">' +
                                '<button class="button add-audio add-file-btn">Добавить/изменить аудиозапись</button>';
                            break;
                        case 'pdf':
                            currentComboItemHTML += '<input type="hidden">' +
                                '<input class="no-index filename-input" type="text" disabled>' +
                                '<button class="button add-pdf add-file-btn">Добавить/изменить PDF</button>';
                            break;
                    }
                    currentComboItemHTML += '</div>';
                currentComboItemHTML += '</div>';
            });
            currentComboItemHTML += '<button class="button remove-combo-item">Удалить элемент</button></li>';
            currentCombo.$item = $(currentComboItemHTML);


            var data = $currentCombo.data('meta');
            if(data != ''){
                var getImageUrl = $currentCombo.data('get-image-url');
                data.forEach(function (value, index){
                    var $newComboItemObj = addComboItem($currentCombo, false);
                    var $newComboItemObjFields = $newComboItemObj.find('.combo-item-field-body');
                    $newComboItemObjFields.each(function (index) {
                        if(value[index] !== '') {
                            var $field = $(this);
                            switch (internalItems[index].type) {
                                case 'text':
                                    $field.find('input').val(value[index]);
                                    break;
                                case 'textarea':
                                    $field.find('textarea').val(value[index]);
                                    break;
                                case 'image':
                                    $field.find('input[type="hidden"]').val(value[index]);
                                    $.get(getImageUrl, {'image_id': value[index]}, function (data) {
                                        $field.find('.image-preview').css('background-image', 'url(' + data + ')');
                                    });
                                    break;
                                case 'audio':
                                case 'pdf':
                                    $field.find('input[type="hidden"]').val(value[index]);
                                    var fileName = value[index];
                                    fileName = fileName.substring(fileName.lastIndexOf('/') + 1);
                                    $field.find('input[type="text"]').val(fileName);
                                    break;
                            }
                        }
                    });
                });
            }
            makeSortable($currentCombo);
        });

        function addComboItem($currentCombo, animate) {
            var itemIndex = $currentCombo.children('li').length;
            var id = $currentCombo.data('id');
            var $newItem = $currentCombo[0].$item.clone();
            $newItem.find('input:not(.no-index), textarea').each(function (inputIndex, item) {
                item.name = id + '[' + itemIndex + '][' + inputIndex + ']';
            });
            $currentCombo.append($newItem);
            if($currentCombo.hasClass('list') && animate){
                var itemHeight = $newItem[0].scrollHeight + 'px';
                $newItem.css({ opacity: 0, height: 0, width: 0 });
                $newItem.animate({ opacity: 1, height: itemHeight, width: '100%' }, 300, function () {
                    $newItem.css({ height: 'auto' });
                });
            }
            return $newItem;
        }

        $('.add-combo-item').click(function (e) {
            e.preventDefault();
            var $currentCombo = $(this).parent().find('.combo');
            addComboItem($currentCombo, true);
        });

        $(document).on('click', '.remove-combo-item', function(e) {
            e.preventDefault();
            $(this).parents('li').animate({ opacity: 0, height: 0, width: 0 }, 300, function() {
                $(this).remove();
                resetIndex($(this).parents('ul'));
            });
        });

    }


    /* функции перетаскивания */
    function makeSortable($list) {
        $list.sortable({
            opacity: 0.6,
            stop: function() {
                resetIndex($list);
            }
        });
    }
    function resetIndex($list) {
        $list.children().each(function(i) {
            $(this).find('input:not(.no-index), textarea').each(function () {
                var name = $(this).attr('name').substring(0, $(this).attr('name').indexOf('['));
                var subIndex =  $(this).attr('name').substring($(this).attr('name').indexOf(']') + 1);
                $(this).attr('name', name + "[" + i + "]" + subIndex);
            });
        });
    }
});