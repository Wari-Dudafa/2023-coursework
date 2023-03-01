<?php // Video upload handler
    session_start();   
    include_once("connection.php");          

    if(isset($_POST['but_upload'])) {
        $maxsize = 62993998; // Approx 60MB

        $name = $_FILES['file']['name'];
        $traget_dir = "TblVideos/";// Target folder files will be uploaded to
        $target_file = $traget_dir . $_FILES["file"]["name"];// Name of file from the form
        $tag = $_POST["tag"];// Video tag

        //File type
        $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Acceptable extensions
        $extensions_arr = array("mp4", "mov", "mpeg", "mkv");// accepted file types

        // Checks the video extension
        // For picture uploads skip this if and go to the next
        if (in_array($videoFileType, $extensions_arr)) {
            
            // Now we compare file size
            if (($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]['size'] == 0)) {
                echo "<br>UploadStatus: Video file is too big";
            }else{
                // Picture upload starts here
                // Thumnbnail upload handler
                if (move_uploaded_file($_FILES['file']['tmp_name'],$target_file)) {

                    $name_t = $_FILES['thumb']['name'];
                    $traget_dir_t = "TblVideos/";
                    $target_file_t = $traget_dir_t . $_FILES["thumb"]["name"];
        
                    // File type
                    $videoFileType_t = strtolower(pathinfo($target_file_t,PATHINFO_EXTENSION));
        
                    // Acceptable file types
                    $extensions_arr_t = array("png", "jpeg", "jpg");
        
                    // Checks the video extension
                    if (in_array($videoFileType_t, $extensions_arr_t)) {
        
                        // Now we compare file size
                        if (($_FILES['thumb']['size'] >= $maxsize) || ($_FILES["thumb"]['size'] == 0)) {
                            echo "<br>UploadStatus: Thumbnail file is too big";
                        }else{
        
                            // Starts uploading
                            if (move_uploaded_file($_FILES['thumb']['tmp_name'],$target_file_t)) {
                                
                                // Uploading data to table
                                $stmt = $conn->prepare("INSERT INTO TblVideos (VideoID,VideoTitle,FileName,Location,FileName_thumbnail,Location_thumbnail,Tag)VALUES (null,:videotitle,'".$name."','".$target_file."','".$name_t."','".$target_file_t."','".$tag."')");
                                $stmt->bindParam(':videotitle', $_POST["Videotitle"]);
                                $stmt->execute();

                                //<Uploaded by segment
                                    //<Gets user id
                                        $stmt1 = $conn->prepare("SELECT * FROM TblUsers WHERE Username = :Username ;");
                                        $stmt1->bindParam(':Username', $_SESSION['CurrentUser']);
                                        $stmt1->execute();

                                        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                            $userid = $row["UserID"] ?? 1;
                                        }
                                    //>
                                    
                                    //<Gets video id
                                        $stmt2 = $conn->prepare("SELECT MAX(VideoID) FROM TblVideos;");
                                        $stmt2->execute();

                                        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                            $videoid=$row["MAX(VideoID)"];
                                        }
                                        
                                    //>

                                    //<Puts user id's into Tblvideos
                                        $stmt_ = $conn->prepare("UPDATE TblVideos SET UserID = :userid WHERE VideoID = :videoid");
                                        $stmt_->bindParam(':userid', $userid);
                                        $stmt_->bindParam(':videoid', $videoid);
                                        $stmt_->execute();
                                        $conn=null;
                                    //>
                                //>
                                // Head to a new page after your upload has completed
                                header('Location: homepage.php');                                                
                            }
                        }
                    }
                }
            }
        } else {
            echo "<br>UploadStatus: Video file format is incorrect";
        }
    } else {
        //If upload fails- this happend
        echo "<br>UploadStatus: Video file doesnt exist";
    }
?>