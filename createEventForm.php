<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>College Club Management System</title>
        <title></title>
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
        
    </head>
    <body>
    <?php require 'utils/adminHeader.php'; ?>
  <form method="POST">
  
  <div class="w3-container"> 
  
  <div class ="content"><!--body content holder-->
            <div class = "container">
                <div class ="col-md-6 col-md-offset-3">
    
    <label>Event ID:</label><br>
    <input type="number" name="event_id" required class="form-control"><br><br>
    
    <label>Event Name:</label><br>
    <input type="text" name="event_title" required class="form-control"><br><br>

    <label>Event Price:</label><br>
    <input type="number" name="event_price" required class="form-control"><br><br>

    <label>Upload Path to Image:</label><br>
    <input type="text" name="img_link" required class="form-control"><br><br>

    <label>Event Date</label><br>
    <input type="date" name="Date" required class="form-control"><br><br>

     <label>Event Time</label><br>
    <input type="text" name="time" required class="form-control"><br><br>

    <label>Event Location</label><br>
    <input type="text" name="location" required class="form-control"><br><br>

    <label>Event Duration</label><br>
    <input type="text" name="duration" required class="form-control"><br><br>

    <label>Faculty co-ordinator name</label><br>
    <input type="text" name="sname" required class="form-control"><br><br>

    <label>Faculty co-ordinator Department</label><br>
    <input type="text" name="department" required class="form-control"><br><br>

    <label>Student co-ordinator name</label><br>
    <input type="text" name="st_name" required class="form-control"><br><br>

    <label>Student co-ordinator Phone</label><br>
    <input type="text" name="phone" required class="form-control"><br><br>

    <label>Student co-ordinator Address</label><br>
    <input type="text" name="address" required class="form-control"><br><br>

    <button type="submit" name="update" class = "btn btn-default pull-right">Create Event <span class="glyphicon glyphicon-send"></span></button>

    <a class="btn btn-default navbar-btn" href = "adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>

  
  </div></div></div>
  </form>
    

    
    </body>

  <?php require 'utils/footer.php'; ?>
</html>

<?php

  if (isset($_POST["update"]))
  {
  $event_id=$_POST["event_id"];
    $event_title=$_POST["event_title"];
    $event_price=$_POST["event_price"];

    $img_link=$_POST["img_link"];
    $name=$_POST["sname"];
    $st_name=$_POST["st_name"];
    $Date=$_POST["Date"];
    $time=$_POST["time"];
    $location=$_POST["location"];
    $duration=$_POST["duration"];
    $phone=$_POST["phone"];
    $address=$_POST["address"];
    $department=$_POST["department"];

    if(!empty($event_id) || !empty($event_title) || !empty($event_price) || !empty($participents) || !empty($img_link))

    {
      include 'classes/db1.php';
        
        
   
        $INSERT="INSERT INTO events(event_id,event_title,event_price,img_link) VALUES($event_id,'$event_title', $event_price,'$img_link');";

            $INSERT.= "INSERT INTO event_info (event_id,Date,time,location,duration) Values ($event_id,'$Date','$time','$location','$duration');";
            $INSERT.="INSERT into student_coordinator(sid,st_name,phone,event_id,address)  values($event_id,'$st_name','$phone',$event_id,'$address');";
            $INSERT.="INSERT into staff_coordinator(stid,name,phone,event_id,department)  values($event_id,'$name',NULL,$event_id,'$department');";

        if($conn->multi_query($INSERT)===True){
          echo "<script>
          alert('Event Inserted Successfully!');
          window.location.href='adminPage.php';
          </script>";
        }
        else
        {
          echo"<script>
          alert('Event already exsists!');
          window.location.href='createEventForm.php';
          </script>";
        }
     
        $conn->close();
      
    }
    else
    {
      echo"<script>
      alert('All fields are required');
      window.location.href='createEventForm1.php';
      </script>";
    }
  }
?>