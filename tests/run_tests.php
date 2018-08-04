<?php
error_reporting(-1);

// Make sure we aren't using PHP7 during the exec calls
$php = "/usr/bin/php";

$tests_to_run = array_map(function($item) {
    return basename($item, '.php');
}, glob('example_*.php'));


foreach ($tests_to_run as $test) {
    if (file_exists("test_output/$test.pdf")) {
        unlink("test_output/$test.pdf");
    }

    exec("$php $test.php");
    exec("comparepdf -v=0 golden_masters/$test.pdf test_output/$test.pdf", $output, $return_code);

    if ($return_code !== 0) {
        echo "tests/$test.php produced different output.\n";
    } else {
        echo '.';
    }
}
echo "\n";
