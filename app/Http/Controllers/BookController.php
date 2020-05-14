<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->book->all()->load('author');

        return view('admin.books.index',['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        if($authors->count() == 0) {
            return redirect()->back()->with('error','Сначала добавьте автора');
        }

        return view('admin.books.create',['authors'=>$authors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $this->book->create($request->validated());

        return response()->redirectToRoute('admin.books.index')->with('status','Книга успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();

        return view('admin.books.edit',['book'=>$book,'authors'=>$authors]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('admin.books.index')->with('status','Книга успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('status','Книга удалена');
    }
}
