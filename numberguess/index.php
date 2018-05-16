<?php
session_start();
$action = filter_input(INPUT_GET, 'action');
if (!isset($_SESSION['name'])) {
    $_SESSION['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
if ($action == 'show_success') { 
    // like htmlspecialchars with ENT_QUOTES set--
    include 'numberguess_success.php';
} else {
    $guess = filter_input(INPUT_POST, 'guess', FILTER_VALIDATE_INT);
    if (isset($guess) && $guess == 43) {
        error_log("adding $100 to account of" . $_SESSION['name'] . " only once");
      // make sure refresh of page doesn't repeat the $100 addition--
        header("Location: .?action=show_success");
        exit();
    }
    include 'numberguess_form.php';
}
?>