<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>upload</title>
</head>
<body>
    <form action="https://upload.embed.ly/1/video?key=YOUR_API_KEY" method="POST" enctype="multipart/form-data">
        <input id="video_file" name="video_file" type="file">
        <input type="submit" class="button" value="Upload">
    </form>
    <div class="video-display"></div>
    
</body>
</html>