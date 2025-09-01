import Dropzone from 'dropzone';

window.Dropzone = Dropzone;

// Desactiva la búsqueda automática de elementos con la clase 'dropzone'
// https://docs.dropzone.dev/getting-started/setup/declarative#the-auto-discover-feature
Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: '.png,.jpg,.jpeg,.gif',
    addRemoveLinks: true,
    dictRemoveFile: 'Eliminar archivo',
    maxFiles: 1,
    uploadMultiple: false,
});