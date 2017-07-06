function tree_toggle(event) {
    event = event || window.event
    var clickedElem = event.target || event.srcElement

    if (!hasClass(clickedElem, 'Expand')) {
        return // клик не там
    }

    // Node, на который кликнули
    var node = clickedElem.parentNode
    if (hasClass(node, 'ExpandLeaf')) {
        return // клик на листе
    }

    // определить новый класс для узла
    var newClass = hasClass(node, 'ExpandOpen') ? 'ExpandClosed' : 'ExpandOpen'
    // заменить текущий класс на newClass
    // регексп находит отдельно стоящий open|close и меняет на newClass
    var re = /(^|\s)(ExpandOpen|ExpandClosed)(\s|$)/
    node.className = node.className.replace(re, '$1' + newClass + '$3')
}
function hasClass(elem, className) {
    return new RegExp("(^|\\s)" + className + "(\\s|$)").test(elem.className)
}
$(document).ready(function () {
    $('input[type="checkbox"]').on("click", function () {
        var items = $(this).closest("li").find("input");
        if ($(this).is(':checked')) {
            for (var i = 0; i < items.length; i++) {
                items[i].checked = true;
            }
        } else {
            for (var i = 0; i < items.length; i++) {
                items[i].checked = false;
            }
        }
    });
    $('.checkbox').on('click', function () {
        if ($('.checkbox').is(':checked')) {
            $('input[name="utm_source"]').removeAttr('disabled', 'true');
            $('input[name="utm_medium"]').removeAttr('disabled', 'true');
            $('input[name="utm_campaign"]').removeAttr('disabled', 'true');
        }
        if (!$('.checkbox').is(':checked')) {
            $('input[name="utm_source"]').attr('disabled', 'false');
            $('input[name="utm_medium"]').attr('disabled', 'false');
            $('input[name="utm_campaign"]').attr('disabled', 'false');
        }
    });
});