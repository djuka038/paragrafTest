<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.js" integrity="sha512-0QMJSMYaer2wnpi+qbJOy4rOAlE6CbYImSlrgQuf2MBBMqTvK/k6ZJV126/EbdKzMAXaB6PHzdYxOX6Qey7WWw==" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <hr>
        <div class="row">
            <button class="btn btn-success">Sačuvaj</button>
        </div>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row h-100">
            <div class="col-9">
                <object data="{{ url($document->original_pdf_location) }}" type="application/pdf" width="100%" height="95%"></object>
            </div>
            <div class="col-3">
                <div class="row">
                    <div class="drop-zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                        <p>Drag one or more files to this Drop Zone ...</p>
                    </div>
                </div>
                <hr>
                <div id="preview" class="row">

                </div>
            </div>
        </div>
        <hr>
    </div>
</body>


</html>

<style>
    .container-fluid {
        height: 90vh;
        overflow: hidden;
    }

    .drop-zone {
        width: 100%;
        height: 100px;
        border: 1px solid black;
    }

    .img-preview {
        width: 100%;
        height: 100px;
        object-fit: contain;
        margin-bottom: 10px;
        z-index: 10;
    }

    #preview {
        position: absolute;
    }

    #dragable {
        cursor: move;
        padding: 5px;
    }
</style>

<script>
    "use strict";

    var apiUrl = "http://127.0.0.1:8000";
    var httpRequest;

    function dropHandler(ev) {
        ev.preventDefault();

        var url = ev.dataTransfer.getData('url');

        if (ev.dataTransfer.items) {
            for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                if (ev.dataTransfer.items[i].kind === 'file') {
                    var file = ev.dataTransfer.items[i].getAsFile();
                    var reader = new FileReader();

                    reader.addEventListener("load", function() {
                        appendPreview(reader.result);
                    }, false);

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                }
            }
        } else {
            for (var i = 0; i < ev.dataTransfer.files.length; i++) {}
        }
    }

    function dragOverHandler(ev) {
        ev.preventDefault();
    }

    function appendPreview(path) {
        var parent = document.getElementById("preview");

        var node = document.createElement("div");
        node.setAttribute("id", "dragable");

        var child = document.createElement("img");
        child.classList.add("img-preview");
        child.src = path;

        node.appendChild(child);
        parent.appendChild(node);
    }

    dragElement(document.getElementById("preview"));

    function dragElement(elmnt) {
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
</script>