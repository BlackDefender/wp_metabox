jQuery(function($) {

    var file_frame;
    var $document = $(document);

    /* Image */
    $document.on('click', '.add-image', function() {
        var $that = $(this);
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
            var imageURL = getAttachedImageURL(attachment);
            $that.parent().find('input:hidden').attr('value', attachment.id);
            $that.css('background-image', 'url('+imageURL+')');
        });
        file_frame.open();
    });
    $document.on('click', '.add-image .remove', function (e) {
        e.stopPropagation();
        $(this).parent().removeAttr('style').addClass('empty').parent().find('input[type="hidden"]').val('');
    });
    $document.on('mouseenter', '.add-image', function () {
        var value = $(this).parent().find('input[type="hidden"]').val();
        if(value === '' && !this.classList.contains('empty')){
            this.classList.add('empty');
        }else{
            if(value !== '' && this.classList.contains('empty')){
                this.classList.remove('empty');
            }
        }
    });

    /* PDF */
    $document.on('click', '.add-pdf', function(e) {
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
    $document.on('click', '.add-audio', function(e) {
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
            var dataDescription = $currentCombo.data('data-description');
            currentCombo.$emptyItem = getComboJqueryEmptyItem(dataDescription);
            deserializeComboData($currentCombo, dataDescription);
            makeSortable($currentCombo);
        });

        function deserializeComboData($combo, dataDescription) {
            var data = $combo.parent().find('script[type="combo-data"]').text();
            if(data != ''){
                data = JSON.parse(data);
                var getImageUrl = $combo.data('get-image-url');
                data.forEach(function (value, index){
                    var $newComboItemObj = getNewJqueryComboItem($combo);
                    var $newComboItemObjFields = $newComboItemObj.find('.combo-item-field-body');
                    $newComboItemObjFields.each(function (index) {
                        if(value[index] !== '') {
                            var $field = $(this);
                            switch (dataDescription[index].type) {
                                case 'text':
                                    $field.find('input').val(value[index]);
                                    break;
                                case 'textarea':
                                    $field.find('textarea').val(value[index]);
                                    break;
                                case 'image':
                                    if(value[index]['id'] !== ''){
                                        $field.find('input[type="hidden"]').val(value[index]['id']);
                                        $field.find('.image-preview').css('background-image', 'url(' + value[index]['src'] + ')');
                                    }
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
                    $combo.append($newComboItemObj);
                });
            }
        }

        function getComboJqueryEmptyItem(dataDescription) {
            var comboItemTemplateHTML = '<li>';
            dataDescription.forEach(function (item) {
                comboItemTemplateHTML += '<div class="combo-item-field-wrap">';
                comboItemTemplateHTML += '<div class="combo-item-field-title">'+ item.label +'</div>';
                comboItemTemplateHTML += '<div class="combo-item-field-body">';
                switch(item.type){
                    case 'text':
                        comboItemTemplateHTML += '<input type="text">';
                        break;
                    case 'textarea':
                        comboItemTemplateHTML += '<textarea></textarea>';
                        break;
                    case 'image':
                        comboItemTemplateHTML += '<input type="hidden"><div class="image-preview add-image"><div class="remove"></div></div>';
                        break;
                    case 'audio':
                        comboItemTemplateHTML += '<input type="hidden">' +
                            '<input type="text" disabled class="no-index filename-input">' +
                            '<button class="button add-audio add-file-btn">Добавить/изменить аудиозапись</button>';
                        break;
                    case 'pdf':
                        comboItemTemplateHTML += '<input type="hidden">' +
                            '<input class="no-index filename-input" type="text" disabled>' +
                            '<button class="button add-pdf add-file-btn">Добавить/изменить PDF</button>';
                        break;
                }
                comboItemTemplateHTML += '</div>';
                comboItemTemplateHTML += '</div>';
            });
            comboItemTemplateHTML += '<button class="button remove-combo-item">Удалить элемент</button></li>';
            return $(comboItemTemplateHTML);
        }

        function getNewJqueryComboItem($currentCombo){
            var itemIndex = $currentCombo.children('li').length;
            var id = $currentCombo.data('id');
            var $newItem = $currentCombo[0].$emptyItem.clone();
            $newItem.find('input:not(.no-index), textarea').each(function (inputIndex, item) {
                item.name = id + '[' + itemIndex + '][' + inputIndex + ']';
            });
            return $newItem;
        }

        function appendNewItemToComboAnimated($combo, $newItem){
            $combo.append($newItem);
            if($combo.hasClass('stack')){
                var itemHeight = $newItem[0].scrollHeight + 'px';
                $newItem.css({ opacity: 0, height: 0, width: 0 });
                $newItem.animate({ opacity: 1, height: itemHeight, width: '100%' }, 300, function () {
                    $newItem.css({ height: 'auto' });
                });
            }
        }

        $('.add-combo-item-btn.list').click(function (e) {
            e.preventDefault();
            var $currentCombo = $(this).parent().find('.combo');
            var $newcurrentComboItem = getNewJqueryComboItem($currentCombo);
            appendNewItemToComboAnimated($currentCombo, $newcurrentComboItem);
        });

        $('.add-combo-item-btn.gallery').click(function (e) {
            e.preventDefault();

            var $currentCombo = $(this).parent().find('.combo');

            var that = $(this);
            if (file_frame) file_frame.close();
            file_frame = wp.media({
                title: 'Добавить изображения',
                button:{
                    text: 'Добавить изображения'
                },
                multiple: true
            });
            file_frame.on( 'select', function() {
                var attachments = file_frame.state().get('selection').toJSON();
                attachments.forEach(function (attachment) {
                    if(attachment.type !== 'image') return false;
                    var imageURL = getAttachedImageURL(attachment);
                    var $newcurrentComboItem = getNewJqueryComboItem($currentCombo);

                    $newcurrentComboItem.find('.image-preview').eq(0).css('background-image', 'url('+imageURL+')')
                        .parent().find('input[type="hidden"]').attr('value', attachment.id);

                    appendNewItemToComboAnimated($currentCombo, $newcurrentComboItem);
                });
            });
            file_frame.open();

        });




        $document.on('click', '.remove-combo-item', function(e) {
            e.preventDefault();
            $(this).parents('li').animate({ opacity: 0, height: 0, width: 0 }, 300, function() {
                $(this).remove();
                resetIndex($(this).parents('ul'));
            });
        });

    }

    function getAttachedImageURL(attachment) {
        var imageURL = '';
        if(attachment.sizes.thumbnail) imageURL = attachment.sizes.thumbnail.url;
        else if(attachment.sizes.medium) imageURL = attachment.sizes.medium.url;
        else if(attachment.sizes.large) imageURL = attachment.sizes.medium.url;
        else if(attachment.sizes.full) imageURL = attachment.sizes.full.url;
        return imageURL;
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