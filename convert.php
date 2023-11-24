<?php
if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === UPLOAD_ERR_OK) {
    $videoFileName = $_FILES['videoFile']['name'];
    $videoTmpName = $_FILES['videoFile']['tmp_name'];

    // Create a unique filename for the WAV file
    $wavFileName = uniqid('converted_', true) . '.wav';
    $wavFilePath = 'converted/' . $wavFileName;

    // Use FFmpeg to convert the video to WAV
    $command = "ffmpeg -i $videoTmpName -f wav $wavFilePath";
    shell_exec($command);

    // Check if the conversion was successful
    if (file_exists($wavFilePath)) {
        // Provide a download link to the user
        echo json_encode(['success' => true, 'wavLink' => $wavFilePath]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
