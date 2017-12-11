import $ from 'jquery';
import Trianglify from 'trianglify';

require("materialize-css/dist/js/materialize");

global.$ = global.jQuery = $;

$('.alert').append('<button class="waves-effect btn-flat close"><i class="material-icons">close</i></button>');
$('body').on('click', '.alert .close', function () {
    $(this).parent().fadeOut(300, function () {
        $(this).remove();
    });
});

let triangles = $('.trianglify');

if (triangles !== null) {
    for (let tri of triangles) {
        let pattern = Trianglify({
            height   : tri.offsetHeight,
            width    : tri.offsetWidth,
            cell_size: 200
        });

        tri.style.backgroundImage = `url('${pattern.png()}')`
    }
}
