<?PHP
session_start();
session_unset();
session_destroy();

header("Location: opdracht_13.php")
?>