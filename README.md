# php-image-upload
A class libarary which allows you to upload images without writing any validation and lengthy code.
<h2>Installation</h2>
<p>Clone or Download the package.<br/>
Include ImageUpload.php file in your page.<br/>
use namespace 'PHPLib\Core\ImageUpload' to access the ImageUpload class. </p>
<br/><h2>Example</h2>
$imageUpload = new ImageUpload();  <br/>
$imageUpload->setUploadPath('path/to/upload');  <br/>
$imageUpload->upload('File Control Name');  <br/><br/>
<p> Optional methods to display uploaded / invalid files. </p>
$imageUpload->displayInvalidFiles();  <br/>
$imageUpload->displayUploadedFiles();  <br/>
