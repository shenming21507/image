<?php
error_reporting(E_ERROR);
require_once 'imgdata.php';
$karnc = new imgdata();

/**
 * 遍历获取目录下的指定类型的文件
 * @param $path
 * @param array $files
 * @return array
 */
function getfiles($path, $allowFiles, &$files = array()) {
    if (!is_dir($path)) return null;
    if (substr($path, strlen($path) - 1) != '/') $path .= '/';
    $handle = opendir($path);
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            $path2 = $path . $file;
            if (is_dir($path2)) {
                getfiles($path2, $allowFiles, $files);
            } else {
                if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                    $files[] = substr($path2, strlen($_SERVER['DOCUMENT_ROOT']));
                }
            }
        }
    }
    return $files;
}

/**
 * 域名白名单校验函数
 * @param $domain_list
 * @return true/false
 */
function checkReferer($domain_list = array(
    'haremu.com',
    'acg.sx'
)) {
    $status = false;
    $refer
