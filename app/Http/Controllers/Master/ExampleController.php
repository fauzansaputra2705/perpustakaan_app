<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;
use App\Models\Example;
use App\Repositories\Crud\CrudRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExampleController extends Controller
{
    /**
     * @var CrudRepositoryInterface
     */
    protected $example;

    public function __construct(CrudRepositoryInterface $crud)
    {
        $this->example = $crud;
        $this->example->setModel(new Example());
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Master/Example/Index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $data = $this->example->queryWhere([], []);
        // @phpstan-ignore-next-line
        return datatables()->eloquent($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<div class="action-btn">
                          <a class="text-info edit" data-id="' . $data->id . '">
                            <i class="ti ti-edit fs-5"></i>
                          </a>
                          <a class="text-dark delete ms-2" data-id="' . $data->id . '">
                            <i class="ti ti-trash fs-5"></i>
                          </a>
                        </div>';
            })
            ->rawColumns([])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     * @param  ExampleRequest  $request
     * @return mixed
     */
    public function store(ExampleRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->example->create($request->all());

            DB::commit();
            return to_route('master.example.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.example.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return mixed
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param integer $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = $this->example->find($id);

        if (!$data) {
            return $this->oops('Data tidak ditemukan');
        }
        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     * @param ExampleRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(ExampleRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->example->update($request->all(), $id);

            DB::commit();
            return to_route('master.example.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.example.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param integer $id
     * @return mixed
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->example->delete($id);

            DB::commit();
            return to_route('master.example.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('master.example.index')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
