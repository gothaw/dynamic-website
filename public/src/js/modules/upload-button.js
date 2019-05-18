/**
 * upload button behaviour
 */
if($('#real-input').length){
    (function () {
        // variables
        const uploadButton = document.querySelector('.browse-btn');
        const fileInfo = document.querySelector('.file-info');
        const realInput = document.getElementById('real-input');

        /**
         * @name        displayFileName
         * @desc        Functions displays file name in file info field.
         */
        function displayFileName() {
            const name = realInput.files[0].name;
            fileInfo.innerHTML = name.length > 20 ? name.substr(name.length - 20) : name;
        }

        function eventHandler() {
            uploadButton.addEventListener('click', function() {
                realInput.click();
            });
            realInput.addEventListener('change', function () {
                displayFileName();
            })
        }

        function init() {
            eventHandler();
        }

        window.addEventListener("load", init);
    })();
}
