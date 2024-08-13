<?php

namespace App\Admin\Controllers;

use App\Models\ClassModel;
use App\Models\DocumentTypeModel;
use App\Models\LectureTypeModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ALectureTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Phân loại bài giảng";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LectureTypeModel());
        $grid->column('id', __('ID'));
        $grid->column('vi_name', __('Tên loại bài giảng(Tiếng Việt)'));
        $grid->column('en_name', __('Tên loại bài giảng(Tiếng Anh)'));
        $grid->column('vi_description', __('Mô tả loại bài giảng(Tiếng Việt)'));
        $grid->column('en_description', __('Mô tả loại bài giảng(Tiếng Anh)'));
        $grid->column('order', __('Thứ tự'));

        $grid->column('status', __('Trạng thái'))->display(function ($status) {
            return UtilsCommonHelper::statusFormatter($status, "Core", 'Status', "grid");
        });
        $grid->column('created_at', __('Ngày tạo'))->display(function ($createdAt) {
            return ConstantHelper::dateFormatter($createdAt);
        });
        $grid->column('created_by', __('Người tạo'));
        $grid->column('updated_at', __('Ngày cập nhật'))->display(function ($updatedAt) {
            return ConstantHelper::dateFormatter($updatedAt);
        });
        $grid->column('updated_by', __('Người cập nhật'));
        $grid->model()->orderBy('created_at', 'desc');
        $grid->fixColumns(0, -1);

        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $statusOptions = (new UtilsCommonHelper)::commonCode("Core", "Status", "description_vi", "value");

            $filter->like('vi_name', 'Tên loại bài giảng(Tiếng Việt)');
            $filter->like('en_name', 'Tên loại bài giảng(Tiếng Anh)');
            $filter->like('url', 'Đường dẫn');
            $filter->equal('status', 'Trạng thái')->select($statusOptions);
            $filter->date('created_at', 'Ngày tạo');
            $filter->date('updated_at', 'Ngày cập nhật');
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(LectureTypeModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('vi_name', __('Tên loại bài giảng(Tiếng Việt)'));
        $show->field('en_name', __('Tên loại bài giảng(Tiếng Anh)'));
        $show->field('vi_description', __('Mô tả loại bài giảng(Tiếng Việt)'));
        $show->field('en_description', __('Mô tả loại bài giảng(Tiếng Anh)'));
        $show->field('order', __('Thứ tự'));

        $show->field('status', __('Trạng thái'))->as(function ($status) {
            return UtilsCommonHelper::statusFormatter($status, "Core", 'Status', null);
        });
        $show->field('created_at', __('Ngày tạo'))->as(function ($updatedAt) {
            return ConstantHelper::dateFormatter($updatedAt);
        });
        $show->field('created_by', __('Người tạo'));
        $show->field('updated_at', __('Ngày cập nhật'))->as(function ($updatedAt) {
            return ConstantHelper::dateFormatter($updatedAt);
        });
        $show->field('updated_by', __('Người cập nhật'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $statusOptions = (new UtilsCommonHelper)::commonCode("Core", "Status", "description_vi", "value");
        $statusDefault = $statusOptions->keys()->first();

        $form = new Form(new LectureTypeModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('lecture_type');
        }

        $form->text('vi_name', __('Tên loại bài giảng(Tiếng Việt)'));
        $form->text('en_name', __('Tên loại bài giảng(Tiếng Anh)'));
        $form->text('vi_description', __('Mô tả loại bài giảng(Tiếng Việt)'));
        $form->text('en_description', __('Mô tả loại bài giảng(Tiếng Anh)'));
        $form->number('order', __('Thứ tự'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
