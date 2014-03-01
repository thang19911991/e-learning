<?php 
   if(isset($current_user)) 
    echo 'Hello, Student '. $current_user['username'];
   else   
   echo 'Hello, Anonymoux Student';
   
   
?> 