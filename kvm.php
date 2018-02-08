<?php

define("DEBUG", "vv");

/**
 * # DEBUG 调试说明
 *
 * ## 基础设置：
 *     DEBUG 设置为v输出eval的指令，vv输出全部虚拟机指令，vvv输出更多扩展信息
 *
 * ## DEBUG 日志代码缩写对应表
 *     s2p String to Pointer, 字符串转指针
 *     push 压入堆栈
 *     pop 出栈
 *     mov 赋值
 *     eval执行代码
 *
 * # 日志格式对应意义
 *     $src_index           $method         $code
 *     当前代码执行位置     方法缩写        相关信息
 *
 */

// Discuz 内部模拟
// define("IN_DISCUZ", true);
// define("IN_ADMINCP", true);
// define("DISCUZ_ROOT", 'C:\Users\computer\PhpstormProjects\untitled');

/**
 * @param $obj object
 * @return array
 */
function object_to_array($obj)
{
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
    return $obj;
}

$var_dict = object_to_array(json_decode('{"$_var_0": "JLWMyIuD", "$file_namespace": "JLWMyJ/D", "$_var_2": "JLWMyJPw", "$file_ns_index": "JLWMyNag", "$_var_4": "JLWMyLfF", "$src_index": "JLWMyLTk", "$encoded_src": "JLWMyOmV", "$tmp": "JLWMyOSx", "$plain_src": "JLWMyPz6", "s_eval(": "ZXZhbCg="}'));
foreach ($var_dict as $var_key => $var_value) {
    $var_dict[$var_key] = base64_decode($var_value);
}
function s_eval($code)
{
    global $var_dict;
    /** @noinspection PhpUnusedLocalVariableInspection */
    global $_var_0, $file_namespace, $_var_2, $file_ns_index, $_var_4, $src_index, $encoded_src, $tmp, $plain_src;
    foreach ($var_dict as $var_key => $var_value) {
        if (strpos($code, $var_value) === false) {
            continue;
        } else {
            $code = str_replace($var_value, $var_key, $code);
        }
    }
    write_log_line('eval', $code);
    dump_vminfo();
    dump_memory();
    $eval_result = eval($code);
    dump_vminfo();
    dump_memory();
    return $eval_result;
}

function write_log_line($method, $code)
{
    if (!defined('DEBUG') || substr_count(DEBUG, 'v') < 1) return;
    if ($method != 'eval' && substr_count(DEBUG, 'v') < 2) return;
    global $src_index;
    print(sprintf('0x%08s', dechex($src_index)) . "\t$method\t $code \r\n");
    return;
}

function dump_memory()
{
    if (!defined('DEBUG') || substr_count(DEBUG, 'v') < 3) return;
    global $file_namespace, $file_ns_index;
    for ($i = 0; $i <= $file_ns_index; $i++)
        echo "  \$file_namespace[$i]: $file_namespace[$i]\n";
    return;
}

function dump_vminfo()
{
    if (!defined('DEBUG') || substr_count(DEBUG, 'v') < 3) return;
    global $file_ns_index, $src_index;
    echo "  \$file_ns_index:$file_ns_index\t\$src_index:$src_index" . sprintf('0x%08s', dechex($src_index)) . "\r\n";
    return;
}

if (isset($_var_0)) {
    array_push($_var_0, $file_namespace, $_var_2, $file_ns_index, $_var_4, $src_index);
} else {
    $_var_0 = array();
}
static $encoded_src = null;
if (empty($encoded_src)) {
    $encoded_src = file_get_contents('pec.vmc');
}
$file_namespace = array(__FILE__);
$_var_2 = array(0);
$file_ns_index = $_var_4 = $src_index = 0;
$tmp = $plain_src = null;
try {
    while (1) {
        while ($src_index >= 0) {
            $plain_src = $encoded_src[$src_index++];
            switch ($plain_src ^ $encoded_src[$src_index++]) {
                case '1':
                    $tmp = (int)(($plain_src ^ $encoded_src[$src_index]) . ($plain_src ^ $encoded_src[$src_index + 1]));
                    $src_index += 2;
                    break;
                case '2':
                    $tmp = (int)(($plain_src ^ $encoded_src[$src_index]) . ($plain_src ^ $encoded_src[$src_index + 1]) . ($plain_src ^ $encoded_src[$src_index + 2]) . ($plain_src ^ $encoded_src[$src_index + 3]));
                    $src_index += 4;
                    break;
                case '3':
                    $tmp = (int)(($plain_src ^ $encoded_src[$src_index]) . ($plain_src ^ $encoded_src[$src_index + 1]) . ($plain_src ^ $encoded_src[$src_index + 2]) . ($plain_src ^ $encoded_src[$src_index + 3]) . ($plain_src ^ $encoded_src[$src_index + 4]) . ($plain_src ^ $encoded_src[$src_index + 5]) . ($plain_src ^ $encoded_src[$src_index + 6]) . ($plain_src ^ $encoded_src[$src_index + 7]) . ($plain_src ^ $encoded_src[$src_index + 8]) . ($plain_src ^ $encoded_src[$src_index + 9]));
                    $src_index += 10;
                    break;
                case 'a':
                    write_log_line('pop', "$file_ns_index: $file_namespace[$file_ns_index]");
                    unset($file_namespace[$file_ns_index--]);
                    dump_memory();
                    continue 2;
                case 'b':
                    //花指令
                    $plain_src = null;
                    continue 2;
                case 'c':
                    write_log_line('push', 'null');
                    $file_namespace[++$file_ns_index] = null;
                    dump_memory();
                    continue 2;
                case 'd':
                    if (is_scalar($file_namespace[$file_ns_index - 1])) {
                        $plain_src = $file_namespace[$file_ns_index - 1];
                        unset($file_namespace[$file_ns_index - 1]);
                        $file_namespace[$file_ns_index - 1] = $plain_src[$file_namespace[$file_ns_index]];
                    } else {
                        if (!is_array($file_namespace[$file_ns_index - 1])) {
                            $file_namespace[$file_ns_index - 1] = array();
                        }
                        $plain_src =& $file_namespace[$file_ns_index - 1][$file_namespace[$file_ns_index]];
                        unset($file_namespace[$file_ns_index - 1]);
                        $file_namespace[$file_ns_index - 1] =& $plain_src;
                        unset($plain_src);
                    }
                    continue 2;
                case 'e':
                    //s2p String to Pointer, 字符串转指针
                    write_log_line('s2p', "\$$file_namespace[$file_ns_index]");
                    switch ($file_namespace[$file_ns_index]) {
                        case 'this':
                            $file_namespace[$file_ns_index] =& $this;
                            break;
                        case 'GLOBALS':
                            $file_namespace[$file_ns_index] =& $GLOBALS;
                            break;
                        case '_SERVER':
                            $file_namespace[$file_ns_index] =& $_SERVER;
                            break;
                        case '_GET':
                            $file_namespace[$file_ns_index] =& $_GET;
                            break;
                        case '_POST':
                            $file_namespace[$file_ns_index] =& $_POST;
                            break;
                        case '_FILES':
                            $file_namespace[$file_ns_index] =& $_FILES;
                            break;
                        case '_COOKIE':
                            $file_namespace[$file_ns_index] =& $_COOKIE;
                            break;
                        case '_SESSION':
                            $file_namespace[$file_ns_index] =& $_SESSION;
                            break;
                        case '_REQUEST':
                            $file_namespace[$file_ns_index] =& $_REQUEST;
                            break;
                        case '_ENV':
                            $file_namespace[$file_ns_index] =& $_ENV;
                            break;
                        default:
                            $file_namespace[$file_ns_index] =& ${$file_namespace[$file_ns_index]};
                    }
                    dump_memory();
                    continue 2;
                case 'f':
                    $tmp = $plain_src ^ $encoded_src[$src_index++];
                    if ($tmp == 'd') {
                        $tmp = (int)(($plain_src ^ $encoded_src[$src_index]) . ($plain_src ^ $encoded_src[$src_index + 1]));
                        $src_index += 2;
                    } elseif ($tmp == 'q') {
                        $tmp = (int)(($plain_src ^ $encoded_src[$src_index]) . ($plain_src ^ $encoded_src[$src_index + 1]) . ($plain_src ^ $encoded_src[$src_index + 2]) . ($plain_src ^ $encoded_src[$src_index + 3]));
                        $src_index += 4;
                    } elseif ($tmp == 'x') {
                        $tmp = (int)(($plain_src ^ $encoded_src[$src_index]) . ($plain_src ^ $encoded_src[$src_index + 1]) . ($plain_src ^ $encoded_src[$src_index + 2]) . ($plain_src ^ $encoded_src[$src_index + 3]) . ($plain_src ^ $encoded_src[$src_index + 4]) . ($plain_src ^ $encoded_src[$src_index + 5]) . ($plain_src ^ $encoded_src[$src_index + 6]) . ($plain_src ^ $encoded_src[$src_index + 7]) . ($plain_src ^ $encoded_src[$src_index + 8]) . ($plain_src ^ $encoded_src[$src_index + 9]));
                        $src_index += 10;
                    } else {
                        break 2;
                    }
                    $file_namespace[++$file_ns_index] = '';
                    while ($tmp-- > 0) {
                        $file_namespace[$file_ns_index] .= $plain_src ^ $encoded_src[$src_index++];
                    }
                    write_log_line('mov', "\$file_namespace[$file_ns_index], $file_namespace[$file_ns_index]");
                    dump_memory();
                    continue 2;
                default:
                    break 2;
            }
            while ($tmp-- > 0) {
                $plain_src .= $plain_src[0] ^ $encoded_src[$src_index++];
            }
            s_eval(substr($plain_src, 1));
        }
        if ($src_index == -1) {
            break;
        } elseif ($src_index == -2) {
            s_eval($_var_2[$_var_4 - 1]);
            $src_index = $_var_2[$_var_4];
            $_var_4 -= 2;
        } else {
            exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($src_index < 0 ? $src_index : sprintf('%08X', $src_index)));
        }
    }
} catch (Exception $plain_src) {
    if (!empty($_var_0)) {
        $src_index = array_pop($_var_0);
        $_var_4 = array_pop($_var_0);
        $file_ns_index = array_pop($_var_0);
        $_var_2 = array_pop($_var_0);
        $file_namespace = array_pop($_var_0);
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    throw $plain_src;
}
if (!empty($_var_0)) {
    $src_index = array_pop($_var_0);
    $_var_4 = array_pop($_var_0);
    $file_ns_index = array_pop($_var_0);
    $_var_2 = array_pop($_var_0);
    $file_namespace = array_pop($_var_0);
}
