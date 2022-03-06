<?php

// Dummy index.php

$s1 = "hello";
$s2 = "world";
$s3 = $s1 . $s2;

print($s1);
print('<br>');
print($s2);
print('<br>');
print($s3);
print("<br>");

$servername = "localhost";
$username = "root";
$password = "";
$database = "wordpress";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";



function recur(string $path, array &$files) {
    if(is_dir($path)) {
        $dirIter = new DirectoryIterator($path);
        foreach ($dirIter as $curr) {
            if($curr == '.' || $curr == "..") {
                continue;
            }
            $nowPath = $path . '/' .  $curr;
            if(is_dir($nowPath)) {
                recur($nowPath, $files);
            } else {
                array_push($files, $nowPath);
            }
        }
        return $files;
    } else {
        array_push($files, $path);
        return $files;
    }
}


function listDir(string $path) {
    $dirIter = new DirectoryIterator($path);
    $files = array();
    foreach ($dirIter as $curr) {
        if($curr == '.' || $curr == "..") {
            continue;
        }
        $nowPath = $path . '/' .  $curr;
        if(is_dir($nowPath)) {
            recur($nowPath, $files);
        } else {
            array_push($files, $nowPath);
        }
    }
    foreach($files as $currFile) {
        print(filemtime($currFile));
        print("<br>");
    }
    print(implode("<br>", $files));
    print("<br>");
    return $files;
}

function check(string $fname) {

listDir("../");





