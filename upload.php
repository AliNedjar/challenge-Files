<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST['submit'])) {

            for ($i = 0; $i < count($_FILES['file']['name']); $i++) {

                $errors = [];

                if (empty($_FILES['file']['name'][$i])) {
                    $errors[] = "No file has been selected!";
                }

                if ($_FILES['file']['size'][$i] > 1000000) {
                    $errors[] = 'Your file is too big!';
                }

                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['file']['type'][$i], $allowed)) {
                    $errors[] = 'you cannot upload files of this type!';
                }

                if (!empty($errors)) { ?>
                    <ul> <?php
                        foreach ($errors as $error): ?>
                            <li> <?= $error; ?> </li> <?php
                        endforeach; ?>
                    </ul> <?php
                } else {
                    $fileDestination = 'uploads/';
                    $fileExtension = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                    $fileNameNew = uniqid() . '.' . $fileExtension;
                    $fileUpload = $fileDestination . basename($fileNameNew);
                    move_uploaded_file($_FILES['file']['tmp_name'][$i], $fileUpload);
                    header('Location: upload.php?uploadsuccess');
                }
            }
        }
    }
    ?>
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
        <label for="imageUpload">Upload a profile image:</label>
        <input type="file" name="file[]" id="imageUpload" multiple="multiple">
        <button type="submit">Upload</button>
</form>
<?php

$files = new FilesystemIterator('uploads/', FilesystemIterator::KEY_AS_FILENAME);

foreach ($files as $file) {
    $file->getFilename(); ?>
    <figure>
    <img src="<?= 'uploads/' . $file->getFilename() ?>" alt="profilePicture">
    <figcaption><?= $file->getFilename() ?></figcaption>
    </figure><?php
} ?>


