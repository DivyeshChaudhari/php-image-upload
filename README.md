# php-image-upload
A class libarary which allows you to upload images without writing any validation and lengthy code.

<br/><h2>Exampple</h2>
$imageUpload = new ImageUpload();  <br/>
$imageUpload->setUploadPath('path/to/upload');  <br/>
$imageUpload->upload('File Control Name');  <br/>
$imageUpload->displayInvalidFiles();  <br/>
$imageUpload->displayUploadedFiles();  <br/>
