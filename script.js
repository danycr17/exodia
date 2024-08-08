$(document).ready(function() {
    $('form input, form select, form textarea').on('input change', function() {
        var formData = $(this).closest('form').serialize();
        var contenedor = $(this).closest('.contenedor-respuestas');
        console.log('Datos del formulario:', formData); 

        $.ajax({
            type: 'POST',
            url: 'procesar_formulario.php',
            data: formData,
            success: function(response) {
                console.log('Datos enviados: ' + response);
                contenedor.removeClass('error').addClass('guardado');
                $('#mensaje-confirmacion').show().delay(3000).fadeOut();
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error); 
                contenedor.removeClass('guardado').addClass('error');
                $('#mensaje-error').show().delay(3000).fadeOut();
            }
        });
    });
});
