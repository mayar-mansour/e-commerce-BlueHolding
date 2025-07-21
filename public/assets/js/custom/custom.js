document.addEventListener('DOMContentLoaded', function() {
    // Select all upload buttons dynamically
    document.querySelectorAll('button[id$="UploadButton"], button[id="uploadButton"]').forEach(uploadButton => {
        // Find the closest file input inside the same parent div
        const fileInput = uploadButton.closest('.input-group').querySelector('input[type="file"]');

        if (fileInput) {
            // Clicking the upload button triggers the file input click event
            uploadButton.addEventListener('click', function() {
                fileInput.click();
            });

            // When a file is selected, update the placeholder text
            fileInput.addEventListener('change', function() {
                const placeholder = uploadButton.closest('.input-group').querySelector('span.text-muted');

                if (fileInput.files.length > 0) {
                    placeholder.textContent = fileInput.files[0].name; // Display the selected file name
                    uploadButton.classList.add('btn-success'); // Highlight the button to show file selection
                } else {
                    placeholder.textContent = 'اختار لوجو'; // Reset placeholder text
                    uploadButton.classList.remove('btn-success');
                }
            });
        }
    });
});
