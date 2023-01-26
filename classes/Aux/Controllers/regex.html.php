<!DOCTYPE html>
<html>
<body>

<?php
$str = "123456789";
$pattern = "^[0-9]{10}";
 if (preg_match($pattern, $str)){
  echo "matched";
  } else {
  echo "no match";

?> 

</body>
</html>