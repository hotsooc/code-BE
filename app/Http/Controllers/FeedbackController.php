<?php

namespace App\Http\Controllers;

use App\Admin\Controllers\ConstantHelper;
use App\Http\Validators\FeedbackValidator;
use App\Traits\ResponseFormattingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FeedbackController extends Controller
{
    use ResponseFormattingTrait;

    protected $feedbackValidator;

    /**
     * @param FeedbackValidator $feedbackValidator
     */
    public function __construct(FeedbackValidator $feedbackValidator)
    {
        $this->feedbackValidator = $feedbackValidator;
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

            $validator = $this->feedbackValidator->validateGetAllFeedbacks($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $size = $dataInput['size'] ?? 10;
            $page = $dataInput['page'] ?? 1;

            $columns = ['ba.id', 'ba.name', 'ba.address', 'ba.avatar', 'ba.image', 'ba.image_2', 'ba.image_3', 'ba.image_4', 'ba.image_5', 'ba.image_6', 'ba.order', 'ba.status', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_content as content']);
            } else {
                $columns = array_merge($columns, ['ba.en_content as content']);
            }

            $result = DB::table('feedback as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->orderBy('ba.order', 'asc')
                ->paginate($size, ['*'], 'page', $page);

            return $this->_formatBaseResponse(200, $result, 'Success');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return $this->_formatBaseResponse(400, $errors, 'Failed');
        }
    }

    public function getHighlightClasses(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->classValidator->validateHighlightClass($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $size = $dataInput['size'] ?? 10;
            $page = $dataInput['page'] ?? 1;

            $columns = ['ba.id', 'ba.image', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by', 'ba.order', 'ba.status'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_name as name', 'ba.vi_description as description', 'ba.vi_content as content']);
            } else {
                $columns = array_merge($columns, ['ba.en_name as name', 'ba.en_description as description', 'ba.en_content as content']);
            }

            $result = DB::table('class as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->orderBy('order', 'asc')
                ->paginate($size, ['*'], 'page', $page);

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
