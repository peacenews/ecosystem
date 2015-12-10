<?php
$subject="Test mail";
$to="srinu5117@gmail.com";
$body="This is a test mail";
if (mail($to,$subject,$body))
echo "Mail sent successfully!";
else
echo"Mail not sent!";
?>