<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="imageUpload">Upload an profile image</label>
    <input type="file" name="file" id="imageUpload"/>
    <button type="submit" name="submit">Upload</button>

    <?php
    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];


        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'png', 'gif');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true) . '.' . $fileActualExt;
                    $fileDestination = 'uploads/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header('Location: upload.php?uploadsuccess');
                } else {
                    echo 'Your file is too big!';
                }
            } else {
                echo 'there was an error uploading your file!';
            }
        } else {
            echo 'you cannot upload files of this type!';
        }
    }


    $files = new FilesystemIterator(__DIR__ . '/uploads', FilesystemIterator::SKIP_DOTS);
    foreach ($files as $file):
        ?>
        <figure>
            <img src="uploads/<?php $file->getFilename() ?>"
                 alt="<?php $file->getFilename() ?>">
            <figcaption> <?php $file->getFilename() ?> </figcaption>
        </figure>
    <?php endforeach;
    ?>


</form>
</body>
</html>