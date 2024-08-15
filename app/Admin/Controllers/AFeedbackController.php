<?php

namespace App\Admin\Controllers;

use App\Models\FeedbackModel;
use App\Models\PageModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AFeedbackController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý feedback";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FeedbackModel());
        $grid->column('id', __('ID'));
        $grid->column('name', __('Tên người feedback'));
        $grid->column('address', __('Địa chỉ'));
        $grid->column('avatar', __('Avatar'))->image();
        $grid->column('vi_content', __('Nội dung feedback (Tiếng Việt)'));
        $grid->column('en_content', __('Nội dung feedback (Tiếng Anh)'));
        $grid->column('image', __('Hình ảnh'))->image();
        $grid->column('image_2', __('Hình ảnh 2'))->image();
        $grid->column('image_3', __('Hình ảnh 3'))->image();
        $grid->column('image_4', __('Hình ảnh 4'))->image();
        $grid->column('image_5', __('Hình ảnh 5'))->image();
        $grid->column('image_6', __('Hình ảnh 6'))->image();
        $grid->column('image_7', __('Hình ảnh 7'))->image();
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

            $filter->like('name', 'Tên người feedback');
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
        $show = new Show(FeedbackModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('name', __('Tên người feedback'));
        $show->field('address', __('Địa chỉ'));
        $show->field('avatar', __('Avatar'))->image();
        $show->field('vi_content', __('Nội dung feedback (Tiếng Việt)'));
        $show->field('en_content', __('Nội dung feedback (Tiếng Anh)'));
        $show->field('image', __('Hình ảnh'))->image();
        $show->field('image_2', __('Hình ảnh 2'))->image();
        $show->field('image_3', __('Hình ảnh 3'))->image();
        $show->field('image_4', __('Hình ảnh 4'))->image();
        $show->field('image_5', __('Hình ảnh 5'))->image();
        $show->field('image_6', __('Hình ảnh 6'))->image();
        $show->field('image_7', __('Hình ảnh 7'))->image();
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

        $form = new Form(new FeedbackModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('feedback');
        }

        $form->text('name', __('Tên người feedback'));
        $form->text('address', __('Địa chỉ'));
        $form->image('avatar', __('Avatar'));
        $form->ckeditor('vi_content', __('Nội dung feedback (Tiếng Việt)'));
        $form->ckeditor('en_content', __('Nội dung feedback (Tiếng Anh)'));
        $form->image('image', __('Hình ảnh'));
        $form->image('image_2', __('Hình ảnh 2'));
        $form->image('image_3', __('Hình ảnh 3'));
        $form->image('image_4', __('Hình ảnh 4'));
        $form->image('image_5', __('Hình ảnh 5'));
        $form->image('image_6', __('Hình ảnh 6'));
        $form->image('image_7', __('Hình ảnh 7'));
        $form->number('order', __('Thứ tự'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
