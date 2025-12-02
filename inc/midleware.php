<?php

function allow($page)
{
    $level = $_SESSION['LEVEL_ID'] ?? null;

    if (!$level) return false;

    if ($level == 1) return true;

    $permissions = [
        2 => ['dashboard', 'order'],
        3 => ['dashboard', 'report', 'order']
    ];

    return in_array($page, $permissions[$level] ?? []);
}