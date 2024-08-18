<?php

namespace App\Http\Controllers;

use App\Admin\Controllers\ConstantHelper;
use App\Http\Validators\DocumentValidator;
use App\Http\Validators\NewsValidator;
use App\Http\Validators\SectionValidator;
use App\Traits\ResponseFormattingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\isNull;

class NewsController extends Controller
{
    use ResponseFormattingTrait;

    protected $newsValidator;

    /**
     * @param NewsValidator $newsValidator
     */
    public function __construct(NewsValidator $newsValidator)
    {
        $this->newsValidator = $newsValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getByCategory(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->newsValidator->validateNewsByCategory($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $newsCategoryId = $dataInput['news_category_id'];
            $size = $dataInput['size'] ?? 10;
            $page = $dataInput['page'] ?? 1;

            $columns = ['ba.id', 'ba.news_category_id', 'ba.slug', 'ba.read_time', 'ba.image', 'ba.order', 'ba.status', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_title as title','ba.vi_content as content', 'ba.vi_description as description']);
            } else {
                $columns = array_merge($columns, ['ba.en_title as title','ba.en_content as content', 'ba.en_description as description']);
            }


            if (isNull($newsCategoryId)) {
                $result = DB::table('news as ba')
                    ->select($columns)
                    ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                    ->orderBy('order', 'asc')
                    ->paginate($size, ['*'], 'page', $page);
            } else {

                $result = DB::table('news as ba')
                    ->select($columns)
                    ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                    ->where('ba.news_category_id', '=', $newsCategoryId)
                    ->orderBy('order', 'asc')
                    ->paginate($size, ['*'], 'page', $page);
            }
            return $this->_formatBaseResponse(200, $result, 'Success');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return $this->_formatBaseResponse(400, $errors, 'Failed');
        }
    }

    public function getBySlug(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->newsValidator->validateNewsBySlug($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $slug = $dataInput['slug'];

            $columns = ['ba.id', 'ba.news_category_id', 'ba.slug', 'ba.read_time', 'ba.image', 'ba.order', 'ba.status', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_title as title','ba.vi_content as content', 'ba.vi_description as description']);
            } else {
                $columns = array_merge($columns, ['ba.en_title as title','ba.en_content as content', 'ba.en_description as description']);
            }

            $result = DB::table('news as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->where('ba.slug', '=', $slug)
                ->orderBy('order', 'asc')
                ->get();


            return $this->_formatBaseResponse(200, $result, 'Success');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return $this->_formatBaseResponse(400, $errors, 'Failed');
        }
    }

    public function getRelatedNews(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->newsValidator->validateGetRelatedNews($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $newsCategoryId = $dataInput['news_category_id'];
            $size = $dataInput['size'] ?? 3;
            $id = $dataInput['id'];

            $columns = ['ba.id', 'ba.news_category_id', 'ba.slug', 'ba.read_time', 'ba.image', 'ba.order', 'ba.status', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_title as title','ba.vi_content as content', 'ba.vi_description as description']);
            } else {
                $columns = array_merge($columns, ['ba.en_title as title','ba.en_content as content', 'ba.en_description as description']);
            }

            $result = DB::table('news as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->where('ba.news_category_id', '=', $newsCategoryId)
                ->where('ba.id', '!=', $id)
                ->orderBy('order', 'asc')
                ->limit($size)
                ->get();

            return $this->_formatBaseResponse(200, $result, 'Success');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return $this->_formatBaseResponse(400, $errors, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
