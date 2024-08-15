<?php

namespace App\Http\Controllers;

use App\Admin\Controllers\ConstantHelper;
use App\Http\Validators\DocumentValidator;
use App\Http\Validators\LectureValidator;
use App\Http\Validators\SectionValidator;
use App\Models\LecturerModel;
use App\Traits\ResponseFormattingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LectureController extends Controller
{
    use ResponseFormattingTrait;

    protected $lectureValidator;

    /**
     * @param LectureValidator $lectureValidator
     */
    public function __construct(LectureValidator $lectureValidator)
    {
        $this->lectureValidator = $lectureValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getByLectureType(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->lectureValidator->validateGetLectureByLectureType($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $lectureTypeId = $dataInput['lecture_type_id'];
            $size = $dataInput['size'] ?? 10;
            $page = $dataInput['page'] ?? 1;

            $columns = ['ba.id', 'ba.lecture_type_id','ba.associcate_link','ba.viewer','ba.image', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by', 'ba.order', 'ba.status'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_title as title', 'ba.vi_description as description','ba.vi_content as content' ]);
            } else {
                $columns = array_merge($columns, ['ba.en_title as title', 'ba.en_description as description','ba.en_content as content']);
            }

            $result = DB::table('lecture as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->where('ba.lecture_type_id', '=', $lectureTypeId)
                ->orderBy('order', 'asc')
                ->paginate($size, ['*'], 'page', $page);

            return $this->_formatBaseResponse(200, $result, 'Success');

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return $this->_formatBaseResponse(400, $errors, 'Failed');
        }
    }

    public function getById(Request $request): array
    {
        try {
            $dataInput = $request->all();

            $validator = $this->lectureValidator->validateGetLectureById($dataInput);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $language = $dataInput['language'];
            $lectureId = $dataInput['id'];

            $columns = ['ba.id', 'ba.lecture_type_id','ba.associcate_link','ba.viewer','ba.image', 'ba.created_at', 'ba.updated_at', 'ba.created_by', 'ba.updated_by', 'ba.order', 'ba.status'];
            if ($language === 'vi') {
                $columns = array_merge($columns, ['ba.vi_title as title', 'ba.vi_description as description','ba.vi_content as content' ]);
            } else {
                $columns = array_merge($columns, ['ba.en_title as title', 'ba.en_description as description','ba.en_content as content']);
            }

            //update viewer
            $lecture=LecturerModel::findOrFail($lectureId);
            ++$lecture->viewer;
            $lecture->update();


            $result = DB::table('lecture as ba')
                ->select($columns)
                ->where('ba.status', '=', ConstantHelper::STATUS_ACTIVE)
                ->where('ba.id', '=', $lectureId)
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
