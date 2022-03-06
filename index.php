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
echo "Connected successfully<br>";



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
        clearstatcache();
        $lastMod = filemtime($currFile);
        check($currFile, $lastMod);
        print($lastMod);
        print("<br>");
    }
    //print(implode("<br>", $files));
    //print("<br>");
    return $files;
}

function check(string $fname, int $modTime) {
    $conn = $GLOBALS['conn'];
    $database = "wordpress";
    $table = "backup_ts";
    $lastModTimeSql = "SELECT lastUpdated FROM $database.$table where fname='$fname'";
    $res = $conn->query($lastModTimeSql);
    if ($res->num_rows > 0) {
        // output data of each row
        while($row = $res->fetch_assoc()) {
            $fname = $row["fname"];
            $lastUpdated = $row["lastUpdated"];
            if($lastUpdated < $modTime) {
                print("Updating last ts for file: $fname");
                $sql = "UPDATE $database.$table SET lastUpdated=$modTime where fname='$fname'";
                $res = $conn->query($sql);
                if ($res === TRUE) {
                    echo "Last update ts for $fname updated";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        print("Tracking new file: $fname");
        $sql = "INSERT INTO $database.$table values ('$fname', $modTime);";
        $res = $conn->query($sql);
        if ($res === TRUE) {
            echo "Tracking $fname successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

listDir("../");
$conn->close();




