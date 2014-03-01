<?php 
   if(isset($current_user)) 
    echo 'Hello, Admin '. $current_user['username'];
   else   
   echo 'Hello, Anonymoux Admin';
   
   
?> 