<?php

namespace App\Http\Controllers;

use App\Admin\Controllers\ConstantHelper;
use App\Http\Validators\SectionValidator;
use App\Models\PageModel;
use App\Traits\ResponseFormattingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SectionController extends Controller
{
    use ResponseFormattingTrait;

    protected $sectionValidator;

    /**
     * @param SectionValidator $sectionValidator
     */
    public function __construct(SectionValidator $sectionValidator)
    {
        $this->sectionValidator = $sectionValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->sectionValidator->validateSectionByPage($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $pageId = $dataInput['page_id'];

            $columns = ['ba.id', 'ba.image', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by', 'ba.order', 'ba.status'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_name as name', 'ba.vi_description as description']);
            } else {
                $columns = array_merge($columns, ['ba.en_name as name', 'ba.en_description as description']);
            }

            $result = DB::table('section as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->where('ba.page_id', '=', $pageId)
                ->orderBy('order', 'asc')
                ->get();

            return $this->_formatBaseResponse(200, $result, 'Success');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return $this->_formatBaseResponse(400, $errors, 'Failed');
        }
    }

    public function getByPageUrl(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->sectionValidator->validateGetByPageUrl($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $pageUrl = $dataInput['url'];

            $page=PageModel::where('url','=',$pageUrl)->first();
            if(is_null($page)){
                return $this->_formatBaseResponse(400, null, 'Not found page with url ' . $pageUrl);
            }

            $columns = ['ba.id', 'ba.image', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by', 'ba.order', 'ba.status'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_name as name', 'ba.vi_description as description']);
            } else {
                $columns = array_merge($columns, ['ba.en_name as name', 'ba.en_description as description']);
            }

            $result = DB::table('section as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->where('ba.page_id', '=', $page->id)
                ->orderBy('order', 'asc')
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
