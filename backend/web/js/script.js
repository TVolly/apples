$(function () {
    var $doc = $(document);

    function onFallBtnClick(e) {
        e.preventDefault();
        var $btn = $(this);

        postRequest($btn.data('url'), {}, $btn.parents('.apple-row'))
    }
    
    function onEatSubmit(e) {
        e.preventDefault();
        var $form = $(this),
            $eatValue = $form.find('input').val();

        postRequest($form.attr('action'), {
            eat: $eatValue,
        }, $form.parents('.apple-row'))
    }

    function postRequest(url, data, $appleRow) {
        var $errorBlock = $appleRow.find('.alert-danger')
        $appleRow.removeClass('has-error');
        $errorBlock.empty();
        
        $.post(url, data)
            .done(function (response) {
                var $block = $('#apple-' + response.id);
                $block.html(response.content);
                if (response.action === 'delete') {
                    $block.fadeOut();
                } 
            })
            .fail(function (jqXHR) {
                $appleRow.addClass('has-error');
                $errorBlock.text(jqXHR.responseJSON.message);
            });
    }

    $doc.on('click', '.apple-row .h-fall', onFallBtnClick)
    $doc.on('submit', '.apple-row .h-eat', onEatSubmit)
})