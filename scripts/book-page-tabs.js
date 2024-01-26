
$('.tab-list').each(function(){
    var $this = $(this);
    var $tab = $this.find('li.active');
    var $link = $tab.find('a');
    var $panel = $($link.attr('href'));

    $this.on('click', '.tab-control', function(e) {
        e.preventDefault();
        var $link = $(this),
            id = this.hash;

        if (id && !$link.is('.active')) {
            $panel.removeClass('active');
            $tab.removeClass('active');

            $panel = $(id).addClass('active');
            $tab = $link.parent().addClass('active');
        }
    });
});

$(document).ready(function() {
    // set the width of <span> elements

    const ul = document.querySelector("ul.tab-list");

    if(ul) {
        ul.addEventListener('DOMSubtreeModified', function() {
            const li = ul.querySelector('li:nth-child(2)');

            if (li.classList.contains('active')) {
                setSpanWidthv2();
            }
        });
    }


});
