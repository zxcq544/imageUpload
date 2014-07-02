<?php
$numFiles = count($_FILES['file']['name']);

echo $numFiles;



for ($i = 0; $i < $numFiles; $i++) {
    move_uploaded_file($_FILES['file']['tmp_name'][$i],
        __DIR__ . '/' . $_FILES['file']['name'][$i]);
    echo '
    <div style="display: inline-block">
<img width="120px" src="', $_FILES['file']['name'][$i], '">', '
<span id="', $i, '" style="display: block;text-align:center"> delete </span>

</div>



';

}
