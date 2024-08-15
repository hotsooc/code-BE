<?php

namespace App\Admin\Controllers;

use App\Models\LecturerModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AGCLecturerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý giảng viên";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LecturerModel());
        $grid->column('id', __('ID'));
        $grid->column('name', __('Tên giảng viên'));
        $grid->column('avatar', __('Avatar'))->image();
        $grid->column('address', __('Địa chỉ'));
        $grid->column('vi_title', __('Tiêu đề (Tiếng Việt)'));
        $grid->column('en_title', __('Tiêu đề (Tiếng Anh)'));
        $grid->column('vi_content', __('Nội dung (Tiếng Việt)'));
        $grid->column('en_content', __('Nội dung (Tiếng Anh)'));
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
        $grid->model()->orderBy('order', 'asc');
        $grid->fixColumns(0, -1);

        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $statusOptions = (new UtilsCommonHelper)::commonCode("Core", "Status", "description_vi", "value");

            $filter->like('name', 'Tên giảng viên');
            $filter->like('vi_title', 'Tiêu đề (Tiếng Việt)');
            $filter->like('en_title', 'Tiêu đề (Tiếng Anh)');
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
        $show = new Show(LecturerModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('name', __('Tên giảng viên'));
        $show->field('avatar', __('Avatar'))->image();
        $show->field('address', __('Địa chỉ'));
        $show->field('vi_title', __('Tiêu đề (Tiếng Việt)'));
        $show->field('en_title', __('Tiêu đề (Tiếng Anh)'));
        $show->field('vi_content', __('Nội dung (Tiếng Việt)'));
        $show->field('en_content', __('Nội dung (Tiếng Anh)'));
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

        $form = new Form(new LecturerModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('lecturer');
        }

        $form->text('name', __('Tên giảng viên'));
        $form->image('avatar', __('Avatar'));
        $form->text('address', __('Địa chỉ'));
        $form->text('vi_title', __('Tiêu đề (Tiếng Việt)'));
        $form->text('en_title', __('Tiêu đề (Tiếng Anh)'));
        $form->ckeditor('vi_content', __('Nội dung (Tiếng Việt)'));
        $form->ckeditor('en_content', __('Nội dung (Tiếng Anh)'));
        $form->number('order', __('Thứ tự'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
