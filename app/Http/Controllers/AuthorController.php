<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Interfaces\AuthorRepositoryInterface;
use App\Classes\ApiResponse;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    private AuthorRepositoryInterface $AuthorRepositoryInterface;

    public function __construct(AuthorRepositoryInterface $AuthorRepositoryInterface)
    {
        $this->AuthorRepositoryInterface = $AuthorRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->AuthorRepositoryInterface->index();

        return ApiResponse::sendResponse(AuthorResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $details =[
            'name' => $request->name,
            'bio' => $request->bio,
            'birth_date' => $request->birth_date
        ];
        DB::beginTransaction();
        try{
             $Author = $this->AuthorRepositoryInterface->store($details);

             DB::commit();
             return ApiResponse::sendResponse(new AuthorResource($Author),'Author Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Author = $this->AuthorRepositoryInterface->getById($id);

        return ApiResponse::sendResponse(new AuthorResource($Author),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $Author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, $id)
    {
        $updateDetails =[
            'name' => $request->name,
            'bio' => $request->bio,
            'birth_date' => $request->birth_date
        ];
        DB::beginTransaction();
        try{
             $Author = $this->AuthorRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponse::sendResponse('Author Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $this->AuthorRepositoryInterface->delete($id);

        return ApiResponse::sendResponse('Author Delete Successful','',204);
    }
}
