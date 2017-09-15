<?php
$connect = mysqli_connect('localhost', 'root', '3035651', 'cooking');

if (mysqli_connect_errno())
{
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

for($i = 0; $i < count($_POST['company']); $i++)
{
    $company = mysqli_real_escape_string($connect, $_POST['company'][$i]);
    $project = mysqli_real_escape_string($connect, $_POST['project'][$i]);
    $duration = mysqli_real_escape_string($connect, $_POST['duration'][$i]);
    $key_learning = mysqli_real_escape_string($connect, $_POST['key_learning'][$i]);

    if (empty(trim($company))) continue;

    $sql = "INSERT INTO internship(company, project, duration, key_learning)
            VALUES('$company', '$project', '$duration', '$key_learning')";
    mysqli_query($connect, $sql);
}

if(mysqli_error($connect))
{
    echo "Data base error occured";
}
else
{
    echo $i . " rows added";
}
?>