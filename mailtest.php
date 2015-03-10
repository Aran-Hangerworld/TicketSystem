<?php
    $mailto = 'ben.lee@hangerworld.co.uk';
    $subject = 'the subject';
    $message = 'the message';
    $from = 'info@hangerworld.co.uk';
    $header = 'From:'.$from;

    if(mail($mailto,$subject,$message,$header)) {
        echo 'Email on the way';
    }


?>