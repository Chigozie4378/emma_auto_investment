<?php
class IP{

    public static function getMacAddress() {
        // Use shell_exec to call system commands
        $output = shell_exec('getmac');
    
        // Split the output into lines
        $lines = explode("\n", $output);
    
        // Array to store MAC addresses
        $macAddresses = [];
    
        // Loop through each line and extract MAC addresses
        foreach ($lines as $line) {
            // Split the line into columns based on spaces
            $columns = preg_split('/\s+/', $line);
    
            // Check if the first column is a valid MAC address
            if (isset($columns[0]) && preg_match('/([0-9A-F]{2}[-]){5}[0-9A-F]{2}/i', $columns[0])) {
                $macAddresses[] = $columns[0];
            }
        }
    
        // Return the MAC addresses as a string
        return implode(", ", $macAddresses);
    }
}