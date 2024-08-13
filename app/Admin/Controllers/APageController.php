<?php

namespace App\Admin\Controllers;

use App\Models\PageModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class APageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý trang";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PageModel());
        $grid->column('id', __('ID'));
        $grid->column('vi_name', __('Tên trang(Tiếng Việt)'));
        $grid->column('en_name', __('Tên trang(Tiếng Anh)'));
        $grid->column('url', __('Đường dẫn'));
        $grid->column('seo', __('SEO'));
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

            $filter->like('vi_name', 'Tên trang(Tiếng Việt)');
            $filter->like('en_name', 'Tên trang(Tiếng Anh)');
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
        $show = new Show(PageModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('vi_name', __('Tên trang(Tiếng Việt)'));
        $show->field('en_name', __('Tên trang(Tiếng Anh)'));
        $show->field('url', __('Đường dẫn'));
        $show->field('seo', __('SEO'));
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

        $form = new Form(new PageModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('page');
        }

        $form->text('vi_name', __('Tên trang(Tiếng Việt)'));
        $form->text('en_name', __('Tên trang(Tiếng Anh)'));
        $form->text('url', __('Đường dẫn'));
        $form->text('seo', __('SEO'));
        $form->text('order', __('Thứ tự'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        return $form;
    }
}
