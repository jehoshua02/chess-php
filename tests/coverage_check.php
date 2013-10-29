<?php

$expected = 100;
$inputFile = __DIR__ . '/tests/coverage/clover.xml';

if (!file_exists($inputFile)) {
    echo "No coverage reports found!\n";
    exit(1);
}

$xml = new SimpleXMLElement(file_get_contents($inputFile));
$metrics = $xml->project->metrics;
$actual = ($metrics['coveredelements'] / $metrics['elements']) * 100;
$fail = $actual < $expected;

if ($fail) {
    echo sprintf("Code coverage is %.3f%%, which is below the expected %.3f%%!\n", $actual, $expected);
    exit(1);
}

sprintf("Code coverage is %.3f%% - OK!\n", $actual);
exit(0);
