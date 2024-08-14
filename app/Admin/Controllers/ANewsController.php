<?php

namespace App\Admin\Controllers;

use App\Models\NewsModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ANewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Quản lý tin tức";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsModel());
        $grid->column('id', __('ID'));
        $grid->column('newsCategory.vi_name', __('Loại tin tức'));
        $grid->column('vi_title', __('Tiêu đề tin tức(Tiếng Việt)'));
        $grid->column('en_title', __('Tiêu đề tin tức(Tiếng Anh)'));
        $grid->column('vi_description', __('Mô tả tin tức(Tiếng Việt)'));
        $grid->column('en_description', __('Mô tả  tin tức(Tiếng Anh)'));
        $grid->column('vi_content', __('Nội dung  tin tức(Tiếng Việt)'));
        $grid->column('en_content', __('Nội dung  tin tức(Tiếng Anh)'));
        $grid->column('slug', __('Đường dẫn'));
        $grid->column('image', __('Hình ảnh'))->image();
        $grid->column('read_time', __('Thời gian đọc (phút)'));

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

            $filter->like('vi_title', 'Tên  tin tức(Tiếng Việt)');
            $filter->like('en_title', 'Tên  tin tức(Tiếng Anh)');
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
        $show = new Show(NewsModel::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('newsCategory.vi_name', __('Loại tin tức'));
        $show->field('vi_title', __('Tiêu đề tin tức(Tiếng Việt)'));
        $show->field('en_title', __('Tiêu đề tin tức(Tiếng Anh)'));
        $show->field('vi_description', __('Mô tả tin tức(Tiếng Việt)'));
        $show->field('en_description', __('Mô tả  tin tức(Tiếng Anh)'));
        $show->field('vi_content', __('Nội dung  tin tức(Tiếng Việt)'));
        $show->field('en_content', __('Nội dung  tin tức(Tiếng Anh)'));
        $show->field('slug', __('Đường dẫn'));
        $show->field('image', __('Hình ảnh'))->image();
        $show->field('read_time', __('Thời gian đọc (phút)'));

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

        $newsCategoryOptions = (new UtilsQueryHelper())::getAllNewCategories();
        $newsCategoryDefault = $newsCategoryOptions->keys()->first();

        $form = new Form(new NewsModel());
        if ($form->isEditing()) {
            $id = request()->route()->parameter('news');
            $parentId = $form->model()->find($id)->getOriginal("news_category_id");

            $form->select('news_category_id', __('Loại tin tức'))->options($newsCategoryOptions)->default($parentId);

        } else {
            $form->select('news_category_id', __('Loại tin tức'))->options($newsCategoryOptions)->default($newsCategoryDefault);
        }

        $form->text('vi_title', __('Tiêu đề tin tức(Tiếng Việt)'));
        $form->text('en_title', __('Tiêu đề tin tức(Tiếng Anh)'));
        $form->ckeditor('vi_description', __('Mô tả tin tức(Tiếng Việt)'));
        $form->ckeditor('en_description', __('Mô tả  tin tức(Tiếng Anh)'));
        $form->ckeditor('vi_content', __('Nội dung  tin tức(Tiếng Việt)'));
        $form->ckeditor('en_content', __('Nội dung  tin tức(Tiếng Anh)'));
        $form->image('image', __('Hình ảnh'));
        $form->hidden('slug', __('Đường dẫn'));
        $form->number('read_time', __('Thời gian đọc (phút)'));

        $form->select('status', __('Trạng thái'))->options($statusOptions)->default($statusDefault)->required();

        $form->saving(function ($form) {
            $urlFrontEnd = env('FRONT_END_PRODUCT_URL');
            if (!($form->model()->id && $form->model()->vi_title === $form->vi_title)) {
                $slugConvert = UtilsCommonHelper::create_slug($form->vi_title, NewsModel::get());
                $form->slug = $slugConvert;
//                $form->qr_code = $urlFrontEnd . $slugConvert;
            }
        });
        return $form;
    }
}
