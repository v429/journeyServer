<?php

return [
    'custom' =>[
        'name' => ['required' => '请输入用户名', 'max' => '用户名不能超过16个字符'],
        'password' => ['required' => '请输入密码', 'max' => '密码不能超过20个字符', 'min' => '密码不能小于6个字符'],
        'email' => ['required' => '请输入邮箱','email' => '邮箱格式不正确']
    ]
];