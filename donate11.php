<?php 
include 'include/header.php';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    include 'include/sidebar.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validate and sanitize inputs
        $errors = [];
        
        // Validate name
        if (!empty($_POST['name']) && preg_match('/^[A-Za-z\s]+$/', $_POST['name'])) {
            $name = $_POST['name'];
        } else {
            $errors['nameError'] = 'Only letters and spaces are allowed';
        }

        // Validate gender
        if (!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
        } else {
            $errors['genderError'] = 'Please select your gender';
        }

        // Validate date of birth
        if (!empty($_POST['day']) && !empty($_POST['month']) && !empty($_POST['year'])) {
            $dob = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
        } else {
            $errors['dobError'] = 'Please select a complete date of birth';
        }

        // Validate blood group
        if (!empty($_POST['blood_group'])) {
            $blood_group = $_POST['blood_group'];
        } else {
            $errors['blood_groupError'] = 'Please select your blood group';
        }

        // Validate city
        if (!empty($_POST['city']) && preg_match('/^[A-Za-z\s]+$/', $_POST['city'])) {
            $city = $_POST['city'];
        } else {
            $errors['cityError'] = 'Please enter a valid city name';
        }

        // Validate email
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
            $check_email = "SELECT email FROM donor WHERE email = '$email' AND ID != " . $_SESSION['user_id'];
            $result = mysqli_query($connection, $check_email);
            if (mysqli_num_rows($result) > 0) {
                $errors['emailError'] = 'Email already exists';
            }
        } else {
            $errors['emailError'] = 'Please enter a valid email address';
        }

        // Validate contact number
        if (!empty($_POST['contact_no']) && preg_match('/^\d{10}$/', $_POST['contact_no'])) {
            $contact = $_POST['contact_no'];
        } else {
            $errors['contactError'] = 'Contact number should consist of 11 digits';
        }

        if (empty($errors)) {
            if ($connection) {
                $name = mysqli_real_escape_string($connection, $name);
                $blood_group = mysqli_real_escape_string($connection, $blood_group);
                $gender = mysqli_real_escape_string($connection, $gender);
                $email = mysqli_real_escape_string($connection, $email);
                $city = mysqli_real_escape_string($connection, $city);
                $contact = mysqli_real_escape_string($connection, $contact);

                $sql = "UPDATE donor SET name='$name', blood_group='$blood_group', gender='$gender', email='$email', city='$city', contact_no='$contact', dob='$dob' WHERE ID=" . $_SESSION['user_id'];

                if (mysqli_query($connection, $sql)) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Data Updated</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data update failed: ' . mysqli_error($connection) . '</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            }
        } else {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>' . $error . '</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }

    $sql = "SELECT * FROM donor WHERE ID = " . $_SESSION['user_id'];
    $result = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($result);
    $userID = $user['ID'];
    $name = $user['name'];
    $blood_group = $user['blood_group'];
    $gender = $user['gender'];
    $email = $user['email'];
    $contact = $user['contact_no'];
    $city = $user['city'];
    $dob = $user['dob'];
    $date = explode("-", $dob);
    $dbPassword = $user['password'];

    if (isset($_POST['update_pass'])) {
        $old_password = md5($_POST['old_password']);
        $new_password = $_POST['new_password'];
        $c_password = $_POST['c_password'];
        
        if ($old_password == $dbPassword) {
            if (strlen($new_password) >= 6) {
                if ($new_password == $c_password) {
                    $password = md5($new_password);
                    $sql = "UPDATE donor SET password ='$password' WHERE ID='$userID'";
                    if (mysqli_query($connection, $sql)) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Updated Password</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                        exit;
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error updating record. Please try again later.</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Passwords do not match</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Password should be at least 6 characters long</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please enter valid password</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }

    if (isset($_POST['delete_account'])) {
        if (!empty($_POST['oldpassword'])) {
            $delete_password = md5($_POST['oldpassword']);
            if ($delete_password == $dbPassword) {
                $sql = "DELETE FROM donor WHERE ID='$userID'";
                if (mysqli_query($connection, $sql)) {
                    session_destroy();
                    header("Location: index.php");
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error deleting account. Please try again later.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Please enter a valid password</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please enter your password</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }
    ?>

    <style>
        .form-container {
            margin: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn {
            width: 100%;
        }

        label {
            font-weight: bold;
        }

        .alert {
            margin-top: 20px;
        }
    </style>

    <div class="form-container">
        <form action="setting.php" method="POST" enctype="multipart/form-data">
            <h2 class="text-center">Edit Profile</h2>
            
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" placeholder="Full Name" required>
                <span class="text-danger"><?php if (isset($errors['nameError'])) echo $errors['nameError']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                </select>
                <span class="text-danger"><?php if (isset($errors['genderError'])) echo $errors['genderError']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <div class="d-flex">
                    <select name="day" class="form-control" required>
                        <option value="">Day</option>
                        <?php for ($i = 1; $i <= 31; $i++) {
                            echo "<option value='$i' " . ($date[2] == $i ? 'selected' : '') . ">$i</option>";
                        } ?>
                    </select>
                    <select name="month" class="form-control" required>
                        <option value="">Month</option>
                        <?php for ($i = 1; $i <= 12; $i++) {
                            echo "<option value='$i' " . ($date[1] == $i ? 'selected' : '') . ">$i</option>";
                        } ?>
                    </select>
                    <select name="year" class="form-control" required>
                        <option value="">Year</option>
                        <?php for ($i = 1970; $i <= date('Y'); $i++) {
                            echo "<option value='$i' " . ($date[0] == $i ? 'selected' : '') . ">$i</option>";
                        } ?>
                    </select>
                </div>
                <span class="text-danger"><?php if (isset($errors['dobError'])) echo $errors['dobError']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="blood_group">Blood Group:</label>
                <select name="blood_group" class="form-control" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+" <?php if ($blood_group == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if ($blood_group == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if ($blood_group == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if ($blood_group == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="AB+" <?php if ($blood_group == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if ($blood_group == 'AB-') echo 'selected'; ?>>AB-</option>
                    <option value="O+" <?php if ($blood_group == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if ($blood_group == 'O-') echo 'selected'; ?>>O-</option>
                </select>
                <span class="text-danger"><?php if (isset($errors['blood_groupError'])) echo $errors['blood_groupError']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" name="city" value="<?php echo $city; ?>" class="form-control" placeholder="City" required>
                <span class="text-danger"><?php if (isset($errors['cityError'])) echo $errors['cityError']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" placeholder="Email" required>
                <span class="text-danger"><?php if (isset($errors['emailError'])) echo $errors['emailError']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="contact_no">Contact No:</label>
                <input type="text" name="contact_no" value="<?php echo $contact; ?>" class="form-control" placeholder="Contact No" required>
                <span class="text-danger"><?php if (isset($errors['contactError'])) echo $errors['contactError']; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" name="update" class="btn btn-success" value="Update">
            </div>
        </form>
        
        <form action="setting.php" method="POST">
            <h2 class="text-center">Update Password</h2>
            
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
            </div>
            
            <div class="form-group">
                <label for="c_password">Confirm Password:</label>
                <input type="password" name="c_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            
            <div class="form-group">
                <input type="submit" name="update_pass" class="btn btn-primary" value="Update Password">
            </div>
        </form>
        
        <form action="setting.php" method="POST">
            <h2 class="text-center">Delete Account</h2>
            
            <div class="form-group">
                <label for="oldpassword">Password:</label>
                <input type="password" name="oldpassword" class="form-control" placeholder="Password" required>
            </div>
            
            <div class="form-group">
                <input type="submit" name="delete_account" class="btn btn-danger" value="Delete Account">
            </div>
        </form>
    </div>
    <?php 
} else {
    header("Location: donate.php");
}
include 'include/footer.php';
?>
