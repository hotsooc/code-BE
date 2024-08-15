<?php

namespace App\Admin\Controllers;

use App\Models\LectureModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ALectureController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý bài giảng";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LectureModel());
        $grid->column('id', __('ID'));
        $grid->column('lectureType.vi_name', __('Loại bài giảng'));
        $grid->column('vi_title', __('Tiêu đề bài giảng(Tiếng Việt)'));
        $grid->column('en_title', __('Tiêu đề bài giảng(Tiếng Anh)'));
        $grid->column('vi_description', __('Mô tả bài giảng(Tiếng Việt)'));
        $grid->column('en_description', __('Mô tả  bài giảng(Tiếng Anh)'));
        $grid->column('vi_content', __('Nội dung  bài giảng(Tiếng Việt)'));
        $grid->column('en_content', __('Nội dung  bài giảng(Tiếng Anh)'));
        $grid->column('associate_link', __('Link liên kết'));
        $grid->column('image', __('Hình ảnh'))->image();
        $grid->column('viewer', __('Số lượt xem'));

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

            $filter->like('vi_title', 'Tên  bài giảng(Tiếng Việt)');
            $filter->like('en_title', 'Tên  bài giảng(Tiếng Anh)');
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
        $show = new Show(LectureModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('lectureType.vi_name', __('Loại bài giảng'));
        $show->field('vi_title', __('Tiêu đề bài giảng(Tiếng Việt)'));
        $show->field('en_title', __('Tiêu đề bài giảng(Tiếng Anh)'));
        $show->field('vi_description', __('Mô tả bài giảng(Tiếng Việt)'));
        $show->field('en_description', __('Mô tả  bài giảng(Tiếng Anh)'));
        $show->field('vi_content', __('Nội dung  bài giảng(Tiếng Việt)'));
        $show->field('en_content', __('Nội dung  bài giảng(Tiếng Anh)'));
        $show->field('associate_link', __('Link liên kết'));
        $show->field('image', __('Hình ảnh'))->image();
        $show->field('viewer', __('Số lượt xem'));

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

        $lectureTypeOptions=(new UtilsQueryHelper())::getAllLectureTypes();
        $lectureTypeDefault = $lectureTypeOptions->keys()->first();

        $form = new Form(new LectureModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('lecture');
            $parentId = $form->model()->find($id)->getOriginal("lecture_type_id");

            $form->select('lecture_type_id', __('Loại bài giảng'))->options($lectureTypeOptions)->default($parentId);

        }else{
            $form->select('lecture_type_id', __('Loại bài giảng'))->options($lectureTypeOptions)->default($lectureTypeDefault);
        }

        $form->text('vi_title', __('Tiêu đề bài giảng(Tiếng Việt)'));
        $form->text('en_title', __('Tiêu đề bài giảng(Tiếng Anh)'));
        $form->ckeditor('vi_description', __('Mô tả bài giảng(Tiếng Việt)'));
        $form->ckeditor('en_description', __('Mô tả  bài giảng(Tiếng Anh)'));
        $form->ckeditor('vi_content', __('Nội dung  bài giảng(Tiếng Việt)'));
        $form->ckeditor('en_content', __('Nội dung  bài giảng(Tiếng Anh)'));
        $form->text('associate_link', __('Link liên kết'));
        $form->number('viewer', __('Số lượt xem'))->readonly()->value(0);
        $form->image('image', __('Hình ảnh'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
