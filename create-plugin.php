#!/usr/bin/env php
<?php

echo "What is the name of your plugin? ";
$pluginName = trim(fgets(STDIN));

echo "Where is the uri of your plugin? ";
$pluginUri = trim(fgets(STDIN));

echo "Where is the description of your plugin? ";
$pluginDescription = trim(fgets(STDIN));

echo "What is your name? ";
$authorName = trim(fgets(STDIN));

echo "What is the uri of author? ";
$authorUri = trim(fgets(STDIN));

$pluginDir = __DIR__ . '/output/' . $pluginName;
if (!file_exists($pluginDir)) {
    mkdir($pluginDir);
}

$variables = [
    '{{plugin_name}}' => $pluginName,
    '{{plugin_uri}}' => $pluginUri,
    '{{plugin_description}}' => $pluginDescription,
    '{{plugin_kebab-case}}' => strtolower(str_replace('_', '-', $pluginName)),
    '{{plugin_smallCamel}}' => lcfirst(str_replace('-', '', ucwords($pluginName, '-'))),
    '{{plugin_UpperCamel}}' => str_replace('-', '', ucwords($pluginName, '-')),
    '{{plugin_Upper_Snake_Case}}' => str_replace('-', '_', ucwords($pluginName, '-')),
    '{{plugin_CONST}}' => strtoupper(str_replace('-', '_', ucwords($pluginName, '-'))),
    '{{plugin_namespace}}' => str_replace('-', '', ucwords($pluginName, '-')),
    '{{author_name}}' => $authorName,
    '{{author_uri}}' => $authorUri,
];

function createTemplatesFromFolder($sourceFolder, $destinationFolder, $variables)
{
    // 確保源資料夾和目標資料夾存在
    if (!file_exists($sourceFolder) || !file_exists($destinationFolder)) {
        return false;
    }

    // 遍歷源資料夾
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceFolder, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        // 建立相對路徑
        $relativePath = $iterator->getSubPathname();

        // 檔名代換
        $newRelativePath = str_replace(array_keys($variables), array_values($variables), $relativePath);

        if ($item->isDir()) {
            // 如果是資料夾，則在目標資料夾中建立相同的資料夾結構
            if (!file_exists($destinationFolder . '/' . $newRelativePath)) {
                // 當資料夾不存在時建立
                mkdir($destinationFolder . '/' . $newRelativePath);
            }
        } else {
            // 如果是檔案，則將檔案複製到目標資料夾中的相應位置
            $template = file_get_contents($item->getPathname());
            $templateContent = str_replace(array_keys($variables), array_values($variables), $template);
            file_put_contents($destinationFolder . '/' . $newRelativePath, $templateContent);
        }
    }

    return True;
}

// 使用範例
$templateFolder = __DIR__ . '/templates';
if (createTemplatesFromFolder($templateFolder, $pluginDir, $variables)) {
    echo "Plugin template has been created in $pluginDir.\n";
} else {
    echo "[ERROR] Plugin create fail.\n";
}
