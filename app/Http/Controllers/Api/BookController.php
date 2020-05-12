<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function list() {
        $books = Book::get(['id','title','author_id'])->load(['author' => function($query) {
            return $query->select(['id','name']);
        }]);

        return response()->json($books);
    }

    public function byId($id) {
        $book = Book::select(['id','title','author_id'])->findOrFail($id)->load(['author' => function($query) {
            return $query->select(['id','name']);
        }]);

        return response()->json($book);
    }

    public function update(Request $request) {

        $book = Book::findOrFail($request->id);

        $book->update([
            'title'=>$request->title,
            'author_id'=>$request->author_id
        ]);

        return response()->json($book->only(['id','title','author_id']));

    }

    public function destroy($id) {
        Book::findOrFail($id)->delete();

        return response()->json(['status'=>'ok']);
    }
}
