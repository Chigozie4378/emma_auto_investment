<?php
    
    class Form {
        public static function  oldValue($value)
        {
            if (isset($_POST["$value"])) {
                echo $_POST["$value"];
            }
        }
        public static function oldSelect($value)
        {
            if (isset($_POST["$value"])) { ?>
                <option><?php echo $_POST["$value"] ?></option>
    
                <?php
            }
        }
        public static function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
    }
?>