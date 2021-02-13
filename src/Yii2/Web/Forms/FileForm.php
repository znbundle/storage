<?php

namespace ZnBundle\Storage\Yii2\Web\Forms;

use ZnYii\Base\Forms\BaseForm;

class FileForm extends BaseForm
{

    public $title = null;
    public $content = null;
    public $source_url = null;

    public function i18NextConfig(): array
    {
        return [
            'bundle' => 'storage',
            'file' => 'file',
        ];
    }

    public function translateAliases(): array
    {
        return [
            'status_id' => 'status',
        ];
    }

}