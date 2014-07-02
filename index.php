<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>

</head>
<body>

<form id="fileForm" method="post" action="saveFile.php" enctype="multipart/form-data">
    <input id="file" type="file" accept="image/*" multiple/>
    <input id="submit" type="button" value="sendForm">
</form>
<div id="output"></div>


<script>

    var myForm = document.getElementById('fileForm');
    var fileInput = document.getElementById('file');
    var output = document.getElementById('output');
    var submit = document.getElementById('submit');
    var myFormData = new FormData(myForm);
    var Images = Array();
    var imageId = 0;
    var div = document.createElement("div");
    div.style.cssText = "display: inline-block;";
    output.appendChild(div);

    function fileInputOnChange() {
        if (!myFormData) {
            alert('Please update your browser to Google Chrome');
        }
        var fileList = fileInput.files;
        var i = 0;
        for (i = 0; i < fileList.length; i++) {
            Images.push(fileList[i]);
            var file = fileList[i];
            var imageType = /image.*/;
            if (!file.type.match(imageType)) {
                continue;
            }
            readAndShowImages(file, imageId);
            imageId++;
        }
    }

    function readAndShowImages(file, imageid) {

        var reader = new FileReader();
        reader.onload = (function (id) {
            return function (e) {
                div.innerHTML += '<div id="' + id + '" style="display:inline-block; text-align:center; ">' +
                '<img style="width:120px" src="' + e.target.result + '"> <br>' +
                '<span style="border-bottom: 1px dotted black; cursor: pointer;" onclick="deleteImage(' + id + ')">delete</span>' +
                '</div>';
            }
        })(imageid);
        reader.readAsDataURL(file);
    }


    function sendForm() {
        var i = 0;
        for (i = 0; i < Images.length; i++) {
            myFormData.append('file[]', Images[i]);
        }

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                //window.location="index.php";
                var responseText = xhr.responseText;
                output.innerHTML = responseText;
                Images.splice(0, Images.length);
            }
        }
        xhr.open('POST', 'saveFile.php', true);
        xhr.send(myFormData);
    }

    function deleteImage(id) {
        var divToDelete = document.getElementById(id);
        divToDelete.remove();
        delete Images[id];
    }


    fileInput.addEventListener('change', fileInputOnChange);
    submit.addEventListener('click', sendForm);


</script>


</body>
</html>

