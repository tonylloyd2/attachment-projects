<!DOCTYPE html>
<html>

<head>
    <title>All Downloader</title>
    <style>
        body {
            text-align: center;
        }

        h1 {
            margin-top: 50px;
        }

        a {
            text-decoration: none;
        }

        #linkInput {
            margin: 20px auto;
            height: 40px;
            width: 500px;
            text-align: center;
            border-style: 5px solid green;
            border-radius: 30px;
        }

        #downloadButton {
            margin-bottom: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #downloadButton:hover {
            background-color: #45a049;
        }

        #formatLinks {
            margin: 20px auto;
            max-width: 500px;
            text-align: left;
        }

        .formatLink {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>All Downloader</h1>
    <div>
        <input type="text" id="linkInput" placeholder="Enter video or audio link">
        <br>
        <button id="downloadButton">Fetch Details</button>
    </div>

    <div id="preview"></div>
    <div id="formatLinks"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var downloadButton = document.getElementById('downloadButton');
            var linkInput = document.getElementById('linkInput');
            var preview = document.getElementById('preview');
            var formatLinks = document.getElementById('formatLinks');

            downloadButton.addEventListener('click', function () {
                var link = linkInput.value.trim();
                if (link !== '') {
                    var videoId = getVideoId(link);

                    // Fetch video information from YouTube Data API
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'https://www.googleapis.com/youtube/v3/videos?id=' + videoId + '&part=snippet&key=AIzaSyA0K1jdwyNB5vux4yoSZqokc6AoHnJv6CQ');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                var title = response.items[0].snippet.title;

                                // Display the preview
                                var previewElement;
                                if (link.includes('youtube')) {
                                    // Video preview
                                    previewElement = document.createElement('iframe');
                                    previewElement.src = 'https://www.youtube.com/embed/' + videoId;
                                    previewElement.width = '560';
                                    previewElement.height = '315';
                                    previewElement.allowfullscreen = true;
                                } else {
                                    // Audio preview
                                    previewElement = document.createElement('audio');
                                    previewElement.src = link;
                                    previewElement.controls = true;
                                }
                                preview.innerHTML = '';
                                preview.appendChild(previewElement);
                                showPreviewAndDownload(link, title);
                            } else {
                                formatLinks.innerHTML = 'Error occurred while fetching the video information.';
                            }
                        }
                    };
                    xhr.send();
                }
            });

            // Function to extract video ID from YouTube link
            function getVideoId(link) {
                var videoId = '';
                var regex = /(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})(?:.*)?/;
                var match = link.match(regex);
                if (match && match[1]) {
                    videoId = match[1];
                }
                return videoId;
            }

        });
        function showPreviewAndDownload(link, title) {
            // Create the preview element
            var previewElement;
            if (link.includes('youtube')) {
                // Video preview
                previewElement = document.createElement('iframe');
                previewElement.src = 'https://www.youtube.com/embed/' + getVideoId(link);
                previewElement.width = '560';
                previewElement.height = '315';
                previewElement.allowfullscreen = true;
            } else {
                // Audio preview
                previewElement = document.createElement('audio');
                previewElement.src = link;
                previewElement.controls = true;
            }

            // Create the download link
            var downloadLink = document.createElement('a');
            downloadLink.href = link;
            downloadLink.download = title + '.mp4';
            downloadLink.textContent = 'Download ' + title;

            // Attach click event listener to trigger the file download
            downloadLink.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default link behavior
                downloadFile(link, title);
            });

            // Create the container for the details
            var detailsContainer = document.createElement('div');
            detailsContainer.classList.add('details-container');
            detailsContainer.appendChild(previewElement);
            detailsContainer.appendChild(downloadLink);

            // Insert the details at the beginning of the formatLinks container
            formatLinks.insertBefore(detailsContainer, formatLinks.firstChild);
        }

        function downloadFile(link, title) {
            var a = document.createElement('a');
            var downloadUrl = 'download.php?link=' + encodeURIComponent(link) + '&title=' + encodeURIComponent(title);
            window.open(downloadUrl, '_blank');
            a.href = link;
            a.download = title + '.mp4';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</body>