<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-9
 * 描述: 配送范围管理相关controller
 */
// Heading
$_['heading_title']          = '配送范围设置';

// Text
$_['text_success']           = '成功： 您已成功更新配送范围设置！';
$_['text_list']               = '配送范围清单';
$_['text_add']                = '添加配送范围';
$_['text_edit']               = '编辑配送范围';

// Column
$_['column_city']            = '城市';
$_['column_service_zone']    = '服务区';
$_['column_name']            = '配送范围';
$_['column_action']          = '管理';

// Entry
$_['entry_name']             = '配送范围名称：';
$_['entry_city']             = '选择城市：';
$_['entry_service_zone']     = '所属服务区：';
$_['entry_description']      = '描述：';
$_['entry_status']           = '状态：';

// Help
$_['help_description']       = '务必详细描述配送范围所指的具体情况';

// Error
$_['error_permission']       = '警告： 您没有权限更改配送范围设置！';
$_['error_name']             = '警告： 配送范围名称必须在2至32个字符之间！';
$_['error_service_zone']     = '请选择服务区！';
$_['error_address']          = '警告： 该配送范围不能删除，因为被绑定到 %s 个地址簿记录！';
$_['error_delivery_staff']   = '警告： 该配送范围不能删除，因为被绑定到 %s 个配送员！';