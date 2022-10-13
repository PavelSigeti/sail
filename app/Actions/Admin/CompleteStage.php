<?php

namespace App\Actions\Admin;

class CompleteStage
{
    public function __invoke($stage)
    {
        $status = $stage->status;

        if($status === 'default')
        {

        }
    }
}
