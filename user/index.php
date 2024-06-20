<?php 
include 'include/header.php'; 

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    if (isset($_POST['date'])) {
        $showForm = '
        <div class="alert ggalert-success alert-dismissible fade show" role="alert">
            <strong>Are you sure you want to update your record?</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form method="post">
                <br>
                <input type="hidden" name="userID" value="' . htmlspecialchars($_SESSION['user_id']) . '">
                <button name="updateSave" type="submit" class="btn btn-danger">Yes</button>
                <button type="button" class="btn btn-info" data-dismiss="alert"><span aria-hidden="true">Oops! No</span></button>
            </form>
        </div>';
    }

    if (isset($_POST['userID'])) {
        $userID = $_POST['userID'];
        $crntDate = date_create();
        $crntDate = date_format($crntDate,'Y-m-d'); // Changed to 'Y-m-d' for the correct date format
        $sql = "UPDATE donor SET save_life_date='$crntDate' WHERE id='$userID'";
        if (mysqli_query($connection, $sql)) {
            $_SESSION['save_life_date'] = $crntDate;
            header("Location: index.php");
            exit;
        } else {
            $submitError = '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error updating record. Please try again later.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    }
?>

<style>
    h1, h3 {
        display: inline-block;
    }

    .name {
        color: #e74c3c;
        font-size: 22px;
        font-weight: 700;
    }

    .donors_data {
        background-color: white;
        border-radius: 5px;
        margin: 20px 5px 0 5px;
        box-shadow: 0px 2px 5px -2px rgba(89, 89, 89, 0.95);
        padding: 20px;
    }

    .panel-body {
        padding: 10px;
    }
</style>

<div class="container" style="padding: 60px 0;">
    <div class="row">
        <div class="col-md-12 col-md-push-1">
            <div class="panel panel-default" style="padding: 20px;">
                <div class="panel-body">
                    <?php if (isset($submitError)) echo $submitError; ?>
                    <div class="alert alert-danger alert-dismissable" style="font-size: 18px; display: none;">
                        <strong>Warning!</strong> Are you sure you want to save a life? If you press yes, then you will not be able to donate again for 3 months.
                        <div class="buttons" style="padding: 20px 10px;">
                            <input type="hidden" name="today" value="">
                            <button class="btn btn-primary" id="yes" name="yes" type="submit">Yes</button>
                            <button class="btn btn-info" id="no" name="no">No</button>
                        </div>
                    </div>
                    <div class="heading text-center">
                        <h3>Welcome</h3> 
                        <h1><?php if (isset($_SESSION['name'])) echo htmlspecialchars($_SESSION['name']); ?></h1>
                    </div>
                    <p class="text-center">Here you can manage your account and update your profile</p>
                    <div class="test-success text-center" id="data" style="margin-top: 20px;"><?php if (isset($showForm)) echo $showForm; ?></div>
                    <?php 
                    $safeDate = isset($_SESSION['save_life_date']) ? $_SESSION['save_life_date'] : '0';
                    if ($safeDate == '0') {
                        echo '
                        <form method="post">
                            <button style="margin-top: 20px;" name="date" id="save_the_life" type="submit" class="btn btn-lg btn-danger center-aligned">Save The Life</button>
                        </form>';
                    } else {
                        $start = date_create($safeDate);
                        $end = date_create();
                        if ($start && $end) {
                            $diff = date_diff($start, $end);
                            $diffMonths = $diff->m + ($diff->y * 12);
                            
                            if ($diffMonths >= 3) {
                                echo '
                                <form method="post">
                                    <button style="margin-top: 20px;" name="date" id="save_the_life" type="submit" class="btn btn-lg btn-danger center-aligned">Save The Life</button>
                                </form>';
                            } else {
                                echo '
                                <div class="donors_data">
                                    <span class="name">Congratulations!</span>
                                    <span>You have already saved a life. You can donate blood again after three months. We are very thankful to you.</span>
                                </div>';
                            }
                        } else {
                            echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong> Invalid date format. Please contact support.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
} else {
    header("Location: /index.php");
    exit;
}

include 'include/footer.php'; 
?>
