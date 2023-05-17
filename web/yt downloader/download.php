<?php
if (isset($_GET['link'])) {
    $link = $_GET['link'];

    // Validate the link or perform any necessary checks

    // Generate a unique filename for the downloaded file
    $filename = uniqid('download_') . '.mp4'; // Assuming the file format is MP4

    // Download the file using cURL or any other method suitable for your case
    // Replace this part with your actual implementation to download the file
    // Here, we are using cURL to download the file
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $fileContent = curl_exec($ch);
    curl_close($ch);

    // Save the downloaded content to a file
    file_put_contents($filename, $fileContent);

    // Set appropriate headers to force download the file
    header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\"");
    header("Content-Type: application/octet-stream");
    header("Content-Length: " . filesize($filename));

    // Output the file content
    readfile($filename);

    // Delete the temporary file
    unlink($filename);

    // Stop further execution
    exit();
}
?>