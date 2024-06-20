<?php 
    //include header file
    include ('include/header.php');
?>
<style>
    .size{
        min-height: 0px;
        padding: 60px 0 40px 0;
    }
    .loader{
        display:none;
        width:69px;
        height:89px;
        position:absolute;
        top:25%;
        left:50%;
        padding:2px;
        z-index: 1;
    }
    .loader .fa{
        color: #e74c3c;
        font-size: 52px !important;
    }
    .form-group{
        text-align: left;
    }
    h1{
        color: white;
    }
    h3{
        color: #e74c3c;
        text-align: center;
    }
    .red-bar{
        width: 25%;
    }
    span{
        display: block;
    }
    .name{
        color: #e74c3c;
        font-size: 22px;
        font-weight: 700;
    }
    .donors_data{
        background-color: white;
        border-radius: 5px;
        margin: 25px;
        -webkit-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
        -moz-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
        box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
        padding: 20px 10px 20px 30px;
    }
</style>
<div class="container-fluid red-background size">
    <div class="row">
        <div class="col-md-6 offset-md-3"> <!-- Corrected typo here -->
            <h1 class="text-center">Search Donors</h1>
            <hr class="white-bar">
            <br>
            <div class="form-inline text-center" style="padding: 40px 0px 0px 5px;">
                <div class="form-group text-center center-aligned">
                    <select style="width: 220px; height: 45px;" name="city" id="city" class="form-control demo-default" required>
                        <option value="">-- Select --</option><?php if(isset($city)) echo '<option selected="" value="'.$city.'">'.$city.'</option>'; ?> 
                        <option value=" Amravati " > Amravati </option><option value="Aurangabad" >Aurangabad</option>
<option value=" Akkalkot " > Akkalkot </option><option value="Akola" > Akola</option>
<option value="Bhandara" > Bhandara </option><option value="Beed " > Beed</option>
<option value=" Buldhana" > Buldhana </option><option value="Chandrapur " > Chandrapur </option>
<option value="Dhule " > Dhule </option><option value=" Gadchiroli" > Gadchiroli </option>
<option value=" Gondia" > Gondia </option><option value="Hingoli " > Hingoli </option>
<option value="Jalgaon " > Jalgaon </option><option value="Jalna " > Jalna </option>
<option value=" Kolhapur" > Kolhapur </option><option value=" Latur" > Latur </option>
<option value="Mumbai " > Mumbai </option><option value=" Nagpur" > Nagpur </option>
<option value="Nanded " > Nanded </option><option value="Nashik " > Nashik </option>
<option value="Osmanabad " > Osmanabad </option><option value=" Parbhani" > Parbhani </option>
<option value="Pune " > Pune </option><option value=" Raigad" > Raigad </option>
<option value="Ratnagiri " > Ratnagiri </option><option value=" Sangali" > Sangali </option>
<option value="Satara " > Satara </option><option value="Sindhudurg " > Sindhudurg </option>
<option value=" Solapur" > Solapur </option><option value=" Thane" > Thane </option>
<option value=" Wardha" > Wardha </option><option value=" Washim" > Washim </option>
<option value=" Yavatmal" > Yavatmal </option><option value=" Yeola" > Yeola </option>
<optgroup title="Andhra Pradesh" label="&raquo;Andhra Pradesh"></optgroup>
<option value="Adoni" > Adoni </option><option value="Akkarampalle" > Akkarampalle </option>
<option value="Amalpuram" >Bagh</option><option value=" Amalpuram " >Bhimber</option>
<option value="Avilala" > Avilala </option><option value="Amadalavalasa" > Amadalavalasa </option>
<option value="Badvel" > Badvel </option><option value="Balaga" > Balaga </option>
<option value="Banaganapalle" > Banaganapalle </option><option value="Bobbili" > Bobbili </option>
<option value="Bowluvada" > Bowluvada </option><option value="Bapatla" > Bapatla </option>
<option value="Bandarulanka" > Bandarulanka </option><option value="Beemunipatnam" > Beemunipatnam </option>
<option value="Cherlopalle" > Cherlopalle </option><option value="Chidiga" > Chidiga </option>
<option value="Chirala" > Chirala </option><option value="Chittoor" > Chittoor </option>
<option value="Cumbum" > Cumbum </option><option value="Chodavaram" > Chodavaram </option>
<option value="Dharamvaram" > Dharamvaram </option><option value="Dhone" > Dhone </option>
<option value="Dommara Nandyala" > Dommara Nandyala </option><option value="Dowleswaram" > Dowleswaram </option>
<option value="Dwarakatirumala" > Dwarakatirumala </option><option value="Eluru" > Eluru </option>
<option value="Gooty" > Gooty </option><option value="Gopavaram" > Gopavaram </option>
<option value="Gudur" > Gudur </option><option value="Guntakal" > Guntakal </option>
<option value="Hindapur" > Hindapur </option><option value="Hiramandalam" > Hiramandalam </option>
<option value="Hukumpeta" > Hukumpeta </option><option value="Ichchapuram" > Ichchapuram </option>
<option value="Jaggaiahpet" > Jaggaiahpet </option><option value="Jarjapupeta" > Jarjapupeta </option>
<option value="Kadapa" > Kadapa </option><option value="Kadiri" > Kadiri </option>
<option value="Kanktabamsuguda" > Kanktabamsuguda </option><option value="Kothavalasa" > Kothavalasa </option>
<option value="L.A.Sagaram" > L.A.Sagaram </option><option value="Macherla" > Macherla </option>
<option value="Machilipatnam" > Machilipatnam </option><option value="Mamidalapadu" > Mamidalapadu </option>
<option value="Modameedipalle" > Modameedipalle </option><option value="Moragudi" > Moragudi </option>
<option value="Mulaguntapadu" > Mulaguntapadu </option><option value="Nadim Tiruvuru" > Nadim Tiruvuru </option>
<option value="Nagari" > Nagari </option><option value="Nagireddipalle" > Nagireddipalle </option>
<option value="Nakkapalle" > Nakkapalle </option><option value="Narasapur" > Narasapur </option>
<option value="Ongole" > Ongole </option><option value="Palacole" > Palacole </option>
<option value="Payakaraopeta" > Payakaraopeta </option><option value="Peddapuram" > Peddapuram </option>
<option value="Rajam" > Rajam </option><option value="Ramchandrapuram" > Ramchandrapuram </option>
<option value="Samalkot" > Samalkot </option><option value="Sulluru" > Sulluru </option>
<option value="Tadepalligudem" > Tadepalligudem </option><option value="Thummalamenta" > Thummalamenta </option>
<option value="Tirupati NMA" > Tirupati NMA </option><option value="Uravakonda" > Uravakonda </option>
<option value="Vaddeswaram" > Vaddeswaram </option><option value="Vetapalem" > Vetapalem </option>
<option value="Vizianagaram" > Vizianagaram </option><option value="Yelamanchilli" > Yelamanchilli </option>
<option value="Yenumalapalle" > Yenumalapalle </option><option value="Yerraguntla" > Yerraguntla </option>
</select>
                    </select>
                </div>
                <div class="form-group center-aligned">
                    <select name="blood_group" id="blood_group" style="padding: 0 20px; width: 220px; height: 45px;" class="form-control demo-default text-center margin10px">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="form-group center-aligned">
                    <button type="button" class="btn btn-lg btn-default" id="search">Search</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" style="padding: 60px 0 60px 0;">
    <div class="row " id="data">
        <!-- Display The Search Result -->
        <?php
        if (isset($_GET['city']) && !empty($_GET['city']) && isset($_GET['blood_group']) && !empty($_GET['blood_group'])) {
            // Your logic here
            $city = $_GET['city'];
            $blood_group = $_GET['blood_group']; // Removed the $ sign before 'blood_group'

            $sql = "SELECT * FROM DONOR WHERE city='$city' OR blood_group='$blood_group' ";

            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['save_life_date'] == '0') {
                        echo 
                        '<div class="col-md-3 col-sm-12 col-lg-3 donors_data">
                            <span class="name">' . $row['name'] . '</span>
                            <span>' . $row['city'] . '</span>
                            <span>' . $row['blood_group'] . '</span>
                            <span>' . $row['gender'] . '</span>
                            <span>' . $row['email'] . '</span>
                            <span>' . $row['contact_no'] . '</span>
                        </div>';
                    } else {
                        echo 
                        '<div class="col-sm-12 col-lg-3  donors_data">
                            <span class="name">'.$row['name'].'</span>
                            <span>'.$row['city'].'</span>
                            <span>'.$row['blood_group'].'</span> 
                            <span>'.$row['gender'].'</span>
                            <h4 class="name text-center">Donated</h4>
                        </div>';
                    }
                }
            } else {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Data Not found.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            }
        }
        ?>
    </div>
</div>
<div class="loader" id="wait">
    <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
</div>
<?php 
    //include footer file
    include ('include/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#search").on('click', function(){
            var city = $("#city").val();
            var blood_group = $("#blood_group").val();

            $.ajax({
                type: 'GET',
                url: 'ajaxsearch.php',
                data: { city: city, blood_group: blood_group },
                success: function(response){
                    $("#data").html(response);
                }
            });
        });
    });
</script>
