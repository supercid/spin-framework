<?php
/**
 * Update VERSION file with the version from composer.json
 * 
 * This script is used by GitHub Actions to keep the VERSION file in sync
 * with the version in composer.json
 */

// Load composer.json
$composerJson = file_get_contents(__DIR__ . '/../../composer.json');
$composer = json_decode($composerJson, true);

if (!isset($composer['version'])) {
    echo "No version found in composer.json\n";
    exit(1);
}

$version = $composer['version'];

// Load VERSION file
$versionFile = __DIR__ . '/../../VERSION';
$currentVersion = trim(file_get_contents($versionFile));

// Update VERSION file if version is different
if ($version !== $currentVersion) {
    echo "Updating VERSION file from $currentVersion to $version\n";
    file_put_contents($versionFile, $version . "\n");
} else {
    echo "Version is already up to date: $version\n";
}