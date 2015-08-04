<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Backend\News\NewsRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Backend\NewsRequest;
use App\Services\UploadsManager;

class NewsController extends BaseController
{

    private $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $news = $this->repository->getNewsPaginated(config('custom.per_page'), 1, 'id', 'desc');

        return view('backend.news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest    $request
     * @param UploadsManager $manager
     * @return Response
     */
    public function store(NewsRequest $request, UploadsManager $manager)
    {
        if ($file = Input::file('page_image')) {
            $data['filename'] = $manager->uploadImage($file);
        } else {
            $data['error'] = 'Error while uploading file';
        }

        $input = Input::all();
        $input['page_image'] = $data['filename'];
        $ret = $this->repository->create($input);
        if ($ret) {
            return Redirect::to('admin/news');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
