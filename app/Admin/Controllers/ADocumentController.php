<?php

namespace App\Admin\Controllers;

use App\Models\ComponentModel;
use App\Models\DocumentModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ADocumentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý tài liệu";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DocumentModel());
        $grid->column('id', __('ID'));
        $grid->column('documentType.vi_name', __('Loại tài liệu'));
        $grid->column('vi_title', __('Tiêu đề tài liệu(Tiếng Việt)'));
        $grid->column('en_title', __('Tiêu đề tài liệu(Tiếng Anh)'));
        $grid->column('vi_description', __('Mô tả tài liệu(Tiếng Việt)'));
        $grid->column('en_description', __('Mô tả  tài liệu(Tiếng Anh)'));
        $grid->column('vi_content', __('Nội dung  tài liệu(Tiếng Việt)'));
        $grid->column('en_content', __('Nội dung  tài liệu(Tiếng Anh)'));
        $grid->column('image', __('Hình ảnh'))->image();
        $grid->column('downloaded', __('Số lượt tải'));

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

            $filter->like('vi_title', 'Tên  tài liệu(Tiếng Việt)');
            $filter->like('en_title', 'Tên  tài liệu(Tiếng Anh)');
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
        $show = new Show(DocumentModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('documentType.vi_name', __('Loại tài liệu'));
        $show->field('vi_title', __('Tiêu đề tài liệu(Tiếng Việt)'));
        $show->field('en_title', __('Tiêu đề tài liệu(Tiếng Anh)'));
        $show->field('vi_description', __('Mô tả tài liệu(Tiếng Việt)'));
        $show->field('en_description', __('Mô tả  tài liệu(Tiếng Anh)'));
        $show->field('vi_content', __('Nội dung  tài liệu(Tiếng Việt)'));
        $show->field('en_content', __('Nội dung  tài liệu(Tiếng Anh)'));
        $show->field('image', __('Hình ảnh'))->image();
        $show->field('downloaded', __('Số lượt tải'));

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

        $documentTypeOptions=(new UtilsQueryHelper())::getAllDocumentTypes();
        $documentTypeDefault = $documentTypeOptions->keys()->first();

        $form = new Form(new DocumentModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('document');
            $parentId = $form->model()->find($id)->getOriginal("document_type_id");

            $form->select('document_type_id', __('Loại tài liệu'))->options($documentTypeOptions)->default($parentId);

        }else{
            $form->select('document_type_id', __('Loại tài liệu'))->options($documentTypeOptions)->default($documentTypeDefault);
        }

        $form->text('vi_title', __('Tiêu đề tài liệu(Tiếng Việt)'));
        $form->text('en_title', __('Tiêu đề tài liệu(Tiếng Anh)'));
        $form->text('vi_description', __('Mô tả tài liệu(Tiếng Việt)'));
        $form->text('en_description', __('Mô tả  tài liệu(Tiếng Anh)'));
        $form->text('vi_content', __('Nội dung  tài liệu(Tiếng Việt)'));
        $form->text('en_content', __('Nội dung  tài liệu(Tiếng Anh)'));
        $form->number('downloaded', __('Số lượt tải'))->readonly()->value(0);
        $form->image('image', __('Hình ảnh'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
