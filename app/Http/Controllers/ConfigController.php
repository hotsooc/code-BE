<?php

namespace App\Http\Controllers;

use App\Admin\Controllers\ConstantHelper;
use App\Http\Validators\PageValidator;
use App\Models\SystemConfigModel;
use App\Traits\ResponseFormattingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ConfigController extends Controller
{
    use ResponseFormattingTrait;

    public function configWebsite(): array
    {
        $config=SystemConfigModel::where('group','=','Website')
            ->where('type','=','Footer')
            ->get();

        return $this->_formatBaseResponse(200, $config, 'Success');
    }
}
