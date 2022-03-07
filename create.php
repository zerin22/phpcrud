<?php
    include_once('config.php');

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['create_post'])){
       $title = $_POST['post_title'];
       $description = $_POST['post_description'];
    //     echo "<pre>";
    //    print_r($_FILES['post_image']);
    //    echo "</pre>";
    //    exit();
        //UPLOADING FILE TO SERVER
       if(isset($_FILES['post_image']) && $_FILES['post_image']['error'] == 0)
       {
            $allowed = array(
                "jpg" => "image/jpg", 
                "jpeg" => "image/jpeg", 
                "png" => "image/png"
            );

            $filename = $_FILES["post_image"]["name"];
            $filetype = $_FILES["post_image"]["type"]; // image/jpg - image/jpeg - image/ png
            $filesize = $_FILES["post_image"]["size"];

            // Validate file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION); // jpg / jpeg/ png
            if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

            // Validate file size - 700KB maximum 
            //For megabyte limit 2*1024*1024 =  2MB
            $maxsize = 0.7 * 1024 *1024;
            if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
            
            
            // Validate type of the file
            
            $ft = in_array($filetype, $allowed);
            
            if(in_array($filetype, $allowed)){
                //Check wheather directory is exists
                $dir = "assets/img/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                // Check whether file exists before uploading it
                //generating unique file name to conflict with existing file
                // $rand_1 = random_int(100, 999); 
                // $rand_2 = random_int(100, 999); 
                // $rand_3 = str_shuffle($rand_1.$rand_2);

                //Generating unique filename
                $filename = str_shuffle(time()).'.'.$ext; 
            }else{
                echo "Error: There was a problem uploading your file. Please try again."; 
            }
        }else{
            echo "Error: " . $_FILES["anyfile"]["error"];
        }
       
        $sql = "INSERT INTO `posts` (`title`, `description`, `image`)
               VALUES ('$title', '$description', '$filename')";
        
        if($conn->query($sql) === TRUE)
        {
            //uploading file to server if post quiery is success
            if(file_exists($dir . $filename)){
                echo $filename . " is already exists.";
            }else{
                move_uploaded_file($_FILES["post_image"]["tmp_name"], $dir . $filename);
            }
            header("location:index.php");
        }else{
            echo "Error:" .$conn->error;
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>New Post</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <div>
                    <div class="mt-5">
                        <a href="index.php" class="d-block text-right">All Posts</a>
                    </div>
                    
                    
                    <form action="create.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="postTitle">Post Title</label>
                            <input id="postTitle" class="form-control" type="text" name="post_title" placeholder="Post Title" required>
                        </div>

                        <div class="form-group">
                            <label for="postDescription">Post Description</label>
                            <textarea id="postDescription" class="form-control" name="post_description" cols="30" rows="5" placeholder="Post Description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="postImage">Image</label>
                            <input id="postImage" class="form-control" type="file" name="post_image" placeholder="Post Image" required>
                           </div>

                        <div class="form-group">
                            <input type="submit" name="create_post"  class="btn btn-primary float-right" value="POST">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
  </body>
</html>