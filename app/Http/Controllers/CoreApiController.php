<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CoreApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository = null;
    protected $saveValidator  = null;
    protected $updateValidator = null;

    public function index(Request $request)
    {
        return $this->repository
            ->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($errors = $this->saveValidator->init($request))
            return Response::json(
                $errors,
                '422'
            );

        $model = $this->repository->save($request->input());

        return Response::json(
            $model,
            '200'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $response = ['error' => 'not found'];
        $status   = '422';

        if ($model = $this->repository->find($id)) {
            $response = $model;
            $status   = '200';
        }

        return Response::json(
            $response,
            $status
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if ($errors = $this->updateValidator->init($request))
            return Response::json(
                $errors,
                '422'
            );

        $response = [
            'data' =>
            [
                'errors' =>
                [
                    ['not found']
                ]
            ]
        ];

        $status   = '422';

        if ($model = $this->repository
            ->edit($request->input(), $id)
        ) {
            $response = $model;
            $status   = '200';
        }

        return Response::json(
            $response,
            $status
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

        $response = [
            'data' =>
            [
                'errors' =>
                [
                    ['not found']
                ]
            ]
        ];
        $status   = '422';

        if ($this->repository->remove($id)) {
            $response = 'success';
            $status   = '200';
        }

        return Response::json(
            $response,
            $status
        );
    }
}
