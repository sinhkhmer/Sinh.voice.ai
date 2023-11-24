<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file is uploaded successfully
    if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === UPLOAD_ERR_OK) {
        $videoFileName = $_FILES['videoFile']['name'];
        $videoTmpName = $_FILES['videoFile']['tmp_name'];

        // Create a unique filename for the WAV file
        $wavFileName = uniqid('converted_', true) . '.wav';
        $wavFilePath = 'converted/' . $wavFileName;

        // Debugging: Log intermediate steps
        error_log("Video file name: $videoFileName", 0);
        error_log("Video tmp name: $videoTmpName", 0);
        error_log("WAV file name: $wavFileName", 0);
        error_log("WAV file path: $wavFilePath", 0);

        // Use FFmpeg to convert the video to WAV
        $command = "ffmpeg -i $videoTmpName -f wav $wavFilePath";
        shell_exec($command);

        // Debugging: Log result of the conversion
        if (file_exists($wavFilePath)) {
            error_log("Conversion successful. WAV file exists.", 0);
            echo json_encode(['success' => true, 'wavLink' => $wavFilePath]);
        } else {
            error_log("Conversion failed. WAV file does not exist.", 0);
            echo json_encode(['success' => false]);
        }
    } else {
        error_log("File upload failed.", 0);
        echo json_encode(['success' => false]);
    }
} else {
    error_log("Invalid request method.", 0);
    echo json_encode(['success' => false]);
}
?>
