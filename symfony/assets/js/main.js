import $ from 'jquery';

require("materialize-css/dist/js/materialize");

global.$ = global.jQuery = $;

$('.alert').append('<button class="waves-effect btn-flat close"><i class="material-icons">close</i></button>');
$('body').on('click', '.alert .close', function () {
    $(this).parent().fadeOut(300, function () {
        $(this).remove();
    });
});

let triangles = $('.trianglify');
let trianglesMin = $('.trianglify-min');

if (triangles !== null || trianglesMin !== null) {
    import('trianglify').then( Trianglify => {
        for (let tri of triangles) {
            setGeometricBackground(tri);
        }

        for (let tri of trianglesMin) {
            setGeometricBackground(tri, 20);
        }

        function setGeometricBackground(element, size = 200) {
            let pattern = Trianglify({
                height   : element.offsetHeight,
                width    : element.offsetWidth,
                x_colors : $(element).data('trianglify') || 'random',
                cell_size: size
            });

            element.style.backgroundImage = `url('${pattern.png()}')`;
        }
    });

    $('.background-form-item').click( (event) => {
        let elem = $(event.target);
        let value = elem.data('trianglify');
        $(`input[name="fos_user_profile_form[background]"]`).val([value]);
        $('.background-form-item').removeClass('active');
        elem.addClass('active');
    })
}
