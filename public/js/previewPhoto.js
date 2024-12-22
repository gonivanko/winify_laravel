document.addEventListener('DOMContentLoaded', () => {
    const photoInput = document.getElementById('photo');
    const previewImg = document.getElementById('photo-preview');

    photoInput.addEventListener('change', () => {
        const file = photoInput.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                previewImg.src = e.target.result; // Set the image preview source
            };

            reader.readAsDataURL(file); // Read the file as a data URL
        }
    });
});