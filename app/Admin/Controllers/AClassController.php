<?php

namespace App\Admin\Controllers;

use App\Models\ClassModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AClassController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý lớp học";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ClassModel());
        $grid->column('id', __('ID'));
        $grid->column('vi_name', __('Tên lớp học(Tiếng Việt)'));
        $grid->column('en_name', __('Tên lớp học(Tiếng Anh)'));
        $grid->column('vi_description', __('Mô tả lớp học(Tiếng Việt)'));
        $grid->column('en_description', __('Mô tả lớp học(Tiếng Anh)'));
        $grid->column('image', __('Hình ảnh'))->image();
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

            $filter->like('vi_name', 'Tên lớp học(Tiếng Việt)');
            $filter->like('en_name', 'Tên lớp học(Tiếng Anh)');
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
        $show = new Show(ClassModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('vi_name', __('Tên lớp học(Tiếng Việt)'));
        $show->field('en_name', __('Tên lớp học(Tiếng Anh)'));
        $show->field('vi_description', __('Mô tả lớp học(Tiếng Việt)'));
        $show->field('en_description', __('Mô tả lớp học(Tiếng Anh)'));
        $show->field('image', __('Hình ảnh'))->image();
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

        $form = new Form(new ClassModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('class');
        }

        $form->text('vi_name', __('Tên lớp học(Tiếng Việt)'));
        $form->text('en_name', __('Tên lớp học(Tiếng Anh)'));
        $form->ckeditor('vi_description', __('Mô tả lớp học(Tiếng Việt)'));
        $form->ckeditor('en_description', __('Mô tả lớp học(Tiếng Anh)'));
        $form->image('image', __('Hình ảnh'));
        $form->number('order', __('Thứ tự'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
