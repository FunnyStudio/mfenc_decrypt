# mfenc_decrypt
魔方加密解密测试

调试方法可见文档内注释。

```php
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

```



:) Enjoy a sunny crack day.