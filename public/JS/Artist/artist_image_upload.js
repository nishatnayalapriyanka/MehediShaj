function previewImage(input) {
    var preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function previewGallery(input) {
    var preview = document.getElementById('preview_gallery');
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            preview.style.zIndex = 1; 
        };
        reader.readAsDataURL(file);
    }
}

