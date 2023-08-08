<?php
    
    function cleanInput($input){
        $input = trim($input);
        $input = strip_tags($input);
        $input = stripslashes($input);
        return $input;
    }


    function validateDateTime($date, $time) {
        // Combine date and time into a single string
        $dateTimeString = $date . ' ' . $time;
      
        // Create DateTime objects for current time and the input date/time
        $currentDateTime = new DateTime();
        $inputDateTime = DateTime::createFromFormat('Y-m-d H:i', $dateTimeString);
      
        // Calculate the minimum allowed time (current time + 24 hours)
        $minimumDateTime = $currentDateTime->add(new DateInterval('PT24H'));
      
        // Compare the input date/time with the minimum allowed time
        if ($inputDateTime < $minimumDateTime) {
          // The input date/time is before the next 24 hours
          return false;
        }
      
        // The input date/time is valid
        return true;
      }


      function toAr($number) {
        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishDigits = range(0, 9);

        // Convert English digits to Arabic digits
        $arabicNumber = str_replace($englishDigits, $arabicDigits, $number);

        return $arabicNumber;
    }
      

    
?>

