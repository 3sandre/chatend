<?php 
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        //check if user email is valid
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //if email is valid
            //check email is already exist
            $sql = mysqli_query($conn, "SELECT email FROM user WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){//if email already exist
                echo "$email - This email already exist ";
            }else{
                //check if user upload file or not
                if(isset($_FILES['image'])){//if file uploaded
                    $img_name = $_FILES['image']['name'];//getting user img name
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];//temporary name is used to save/move file in our folder

                    //explode image and get the last extension like jpg png jpeg and svg
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);//get extension

                    $extensions = ['png', 'jpg', 'jpeg' 'svg'];//valid extensions
                    if(in_array($img_ext, $extensions) === true){//if user img ext is valid
                        $time = time();//return current time
                        $new_img_name = $time.$img_name;
                        if(move_uploaded_file($tmp_name, "images/".$new_img_name)){//if user upload img move to our folder successefully
                            $status = "Online";//when user signin
                            $random_id = rand(time(), 10000000);//creating id for user

                            //insrt user data in the table
                            $sql2 = mysqli_query($conn, "INSERT INTO user (unique_id, fname, lname, email, password, img, status) VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");
                            if($sql2){//if data inserted
                                $sql3 = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
                                if(mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id'] = $row['unique_id'];//using this session we used unique_id in other php file
                                    echo "success";
                                }
                            }else{
                                echo "Something went wrong";
                            }
                        }
                    }else{
                        echo "Please select an Image file - jpeg, png, jpg, svg";
                    }

                }else{
                    echo "Please select an Image file";
                }
            }
        }else{
            echo "$email - This email is not valid";
        }
    }else{
        echo "All input field are required";
    }

?>