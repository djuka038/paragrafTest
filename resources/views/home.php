<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
</head>

<body>
    <div class="container fluid">
        <hr>
        <div class="row">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#documentModal">
                Add document
            </button>
        </div>
        <hr>
        <div class="row">
            <table id="documents" class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Download original</th>
                        <th scope="col">Download modified</th>
                        <th scope="col">Uploaded at</th>
                        <th scope="col">Modified at</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr w3-repeat="documents">
                        <td>
                            <button class="btn btn-primary w-100" onclick="download('{{ original_pdf_location }}')">
                                Download original
                            </button>
                        </td>
                        <td id="modifiedPdf">
                            <button class="btn btn-primary w-100" onclick="download('{{ modified_pdf_location }}')">
                                Download modified
                            </button>
                        </td>
                        <td>
                            {{ created_at }}
                        </td>
                        <td>
                            {{ updated_at }}
                        </td>
                        <td>
                            <a class="btn btn-success w-100 m-1" href="/update/{{ id }}">Update</a>
                            <button class="btn btn-danger w-100 m-1" onclick="deleteDocument('{{ id }}')">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
</body>

<!-- Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        Chose pdf file
                    </div>
                    <div class="col-8">
                        <input id="document" type="file">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="uploadDocument()">Upload file</button>
            </div>
        </div>
    </div>
</div>

</html>

<script>
    "use strict";

    var apiUrl = "http://127.0.0.1:8000";
    var httpRequest;

    window.onload = function() {
        onLoad();
    };

    function onLoad() {
        getDocuments();
    }

    function getDocuments() {
        httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = renderDocuments;
        httpRequest.open("GET", apiUrl + "/documents");
        httpRequest.send();
    }

    function renderDocuments() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                w3.displayObject("documents", {
                    documents: JSON.parse(httpRequest.responseText)
                });
            } else {
                alert("There was a problem with the request.");
            }
        }
    }

    function uploadDocument() {
        var data = new FormData();
        data.append("document", document.getElementById("document").files[0]);

        var httpRequest = new XMLHttpRequest();
        httpRequest.open("POST", apiUrl + "/document", true);
        httpRequest.onreadystatechange = getDocuments;
        httpRequest.send(data);
    }

    function deleteDocument(documentId) {
        httpRequest = new XMLHttpRequest();
        httpRequest.open("DELETE", apiUrl + "/document/" + documentId, true);
        httpRequest.onreadystatechange = getDocuments;
        httpRequest.send();
    }

    function download(filePath) {
        window.open(apiUrl + filePath);
    }
</script>