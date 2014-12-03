<?php
/*
+--------------------------------------------------------------------------
|   WeCenter [#RELEASE_VERSION#]
|   ========================================
|   by WeCenter Software
|   © 2011 - 2014 WeCenter. All Rights Reserved
|   http://www.wecenter.com
|   ========================================
|   Support: WeCenter@qq.com
|
+---------------------------------------------------------------------------
*/


if (!defined('IN_ANWSION'))
{
    die;
}

class main extends AWS_CONTROLLER
{
    public function get_access_rule()
    {
        $rule_action['rule_type'] = 'white';

        $rule_action['actions'] = array();

        return $rule_action;
    }

    public function index_action()
    {
        TPL::output('ticket/index');
    }

    public function index_square_action()
    {
        $this->crumb(AWS_APP::lang()->_t('工单'), '/ticket/');

        TPL::output('ticket/square');
    }

    public function data_action()
    {
        TPL::output('ticket/data');
    }

    public function topic_action()
    {
        TPL::output('ticket/topic');
    }

    public function publish_action()
    {
        if (!$this->user_info['permission']['publish_ticket'])
        {
            H::redirect_msg(AWS_APP::lang()->_t('你所在用户组没有权限发布问题'));
        }

        $draft_content = $this->model('draft')->get_data(1, 'ticket', $this->user_id);

        if ($draft_content)
        {
            TPL::assign('message', $draft_content['message']);
        }

        TPL::assign('attach_access_key', md5($this->user_id . time()));

        TPL::assign('human_valid', human_valid('question_valid_hour'));

        TPL::import_js('js/app/publish.js');

        if (get_setting('advanced_editor_enable') == 'Y')
        {
            import_editor_static_files();
        }

        if (get_setting('upload_enable') == 'Y')
        {
            // fileupload
            TPL::import_js('js/fileupload.js');
        }

        TPL::output('ticket/publish');
    }
}
