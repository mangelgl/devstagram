import Dropzone from 'dropzone';

// Desactiva la búsqueda automática de elementos con la clase 'dropzone'
// https://docs.dropzone.dev/getting-started/setup/declarative#the-auto-discover-feature
Dropzone.autoDiscover = false;

let dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: '.png,.jpg,.jpeg,.gif',
    addRemoveLinks: true,
    dictRemoveFile: 'Eliminar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        let inputImageHidden = document.querySelector('[name="imagen"]');
        if (inputImageHidden.value.trim()) {
            let imagenPublicada = {};
            imagenPublicada.size = 1024;
            imagenPublicada.name = inputImageHidden.value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);
            
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
});

dropzone.on('success', function(file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
})

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = '';
})