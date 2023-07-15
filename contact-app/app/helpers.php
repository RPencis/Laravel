<?php
use Illuminate\Support\Str;
function sortable($label, $column = null)
{
    $column = $column ?? Str::snake($label);
    $sortBy = request()->query('sort_by');

    $direction = "";
    if (ltrim($sortBy, "-") === $column) {
        $direction = strpos($sortBy, "-") === 0 ? "desc" : "asc";
    }

    $sortBy = !$sortBy || strpos($sortBy, "-") === 0 ? $column : "-{$column}";
    $url = request()->fullUrlWithQuery(['sort_by' => $sortBy]);

    return "<a class='sortable {$direction}' href='{$url}'>{$label}</a>";
}
