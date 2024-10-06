<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\BookRepositoryInterface;
use App\Classes\ApiResponse;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    private BookRepositoryInterface $BookRepositoryInterface;

    public function __construct(BookRepositoryInterface $BookRepositoryInterface)
    {
        $this->BookRepositoryInterface = $BookRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->BookRepositoryInterface->index();

        return ApiResponse::sendResponse(BookResource::collection($data),'',200);
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
    public function store(StoreBookRequest $request)
    {
        $details =[
            'title' => $request->title,
            'description' => $request->description,
            'publish_date' => $request->publish_date,
            'author_id' => $request->author_id,
        ];
        DB::beginTransaction();
        try{
             $Book = $this->BookRepositoryInterface->store($details);

             DB::commit();
             return ApiResponse::sendResponse(new BookResource($Book),'Book Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Book = $this->BookRepositoryInterface->getById($id);
        // dd($Book);`
        return ApiResponse::sendResponse(new BookResource($Book),'',200);
    }

    public function showByAuthor($id)
    {
        $Book = $this->BookRepositoryInterface->getByAuthorId($id);
        return ApiResponse::sendResponse(BookResource::collection($Book),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $Book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $updateDetails =[
            'title' => $request->title,
            'description' => $request->description,
            'publish_date' => $request->publish_date,
            'author_id' => $request->author_id,
        ];
        DB::beginTransaction();
        try{
             $Book = $this->BookRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponse::sendResponse('Book Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $this->BookRepositoryInterface->delete($id);

        return ApiResponse::sendResponse('Book Delete Successful','',204);
    }
}
