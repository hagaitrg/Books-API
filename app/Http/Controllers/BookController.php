<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::all();

        if($book){
            return response()->json([
                'success' => "true",
                'data' => $book,
                'mesasge' => 'success store book',
                'code' => http_response_code(200)
            ]);
        }else{
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed store book',
                'code' => http_response_code(404)
            ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'status' => 'required'
        ]);

        $data = $request->all();
        $book = Book::create($data);

        if($book){
            return response()->json([
                'success' => "true",
                'data' => $data,
                'mesasge' => 'success store book',
                'code' => http_response_code(200)
            ]);
        }else{
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed store book',
                'code' => http_response_code(404)
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        
        if($book){
            return response()->json([
                'success' => "true",
                'data' => $book,
                'mesasge' => 'success show detail book by id',
                'code' => http_response_code(200)
            ]);
        }else{
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed show detail book by id',
                'code' => http_response_code(404)
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'book not found',
                'code' => 204
            ]);
        }

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'status' => 'required'
        ]);

        $data = $request->all();
        $book->fill($data);
        $book->save();

        if($book){
            return response()->json([
                'success' => "true",
                'data' => $data,
                'mesasge' => 'success update book',
                'code' => http_response_code(200)
            ]);
        }else{
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'failed update book',
                'code' => http_response_code(404)
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => "false",
                'data' => null,
                'mesasge' => 'book not found',
                'code' => 204
            ]);
        }

        $book->delete();

        if($book){
            return response()->json([
                'success' => "true",
                'mesasge' => 'success delete book',
                'code' => http_response_code(200)
            ]);
        }else{
            return response()->json([
                'success' => "false",
                'mesasge' => 'failed delete book',
                'code' => http_response_code(404)
            ]);
        }
    }
}
