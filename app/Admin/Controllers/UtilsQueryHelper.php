<?php

namespace App\Admin\Controllers;

use App\Models\DocumentTypeModel;
use App\Models\LectureTypeModel;
use App\Models\NewsCategoryModel;
use App\Models\PageModel;
use App\Models\SectionModel;
use Illuminate\Support\Collection;

class UtilsQueryHelper
{
    public static function getAllPages(): Collection
    {
        return PageModel::all()->where('status', '=', ConstantHelper::STATUS_ACTIVE)->pluck('vi_name', 'id');
    }

    public static function getAllSections(): Collection
    {
        return SectionModel::all()->where('status', '=', ConstantHelper::STATUS_ACTIVE)->pluck('vi_name', 'id');
    }

    public static function getAllLectureTypes(): Collection
    {
        return LectureTypeModel::all()->where('status', '=', ConstantHelper::STATUS_ACTIVE)->pluck('vi_name', 'id');
    }

    public static function getAllDocumentTypes(): Collection
    {
        return DocumentTypeModel::all()->where('status', '=', ConstantHelper::STATUS_ACTIVE)->pluck('vi_name', 'id');
    }

    public static function getAllNewCategories(): Collection
    {
        return NewsCategoryModel::all()->where('status', '=', ConstantHelper::STATUS_ACTIVE)->pluck('vi_name', 'id');
    }

    public static function getAllWorkerCombined(): Collection
    {
        return WorkerModel::where('status', '=', ConstantHelper::STATUS_ACTIVE)
            ->get()
            ->map(function ($worker) {
                $display_name = $worker->id == 1
                    ? $worker->name
                    : $worker->name . ' - ' . $worker->phone_number . ' - ' . $worker->branch_name;

                return [
                    'id' => $worker->id,
                    'display_name' => $display_name
                ];
            })
            ->pluck('display_name', 'id');
    }


}
