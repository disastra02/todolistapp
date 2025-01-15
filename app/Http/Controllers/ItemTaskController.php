<?php

namespace App\Http\Controllers;

use App\Models\ItemTask;
use App\Models\Task;
use Illuminate\Http\Request;

class ItemTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function detailSubTask($idParent)
    {
        $data = ItemTask::where('parent_id', $idParent)->orderBy('id', 'DESC')->get();
        return $this->sendResponse($data, 'Data sub task');
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
    public function store(Request $req)
    {
        $req->validate([
            'task_id' => 'required',
            'name' => 'required|string|max:255',
            'is_completed' => 'required'
        ]);

        $task = ItemTask::create([
            'task_id' => $req->task_id,
            'name' => $req->name,
            'is_completed' => $req->is_completed,
            'parent_id' => $req->parent_id ?? null
        ]);

        $message = $req->parent_id ? 'Sub item task berhasil dibuat' : 'Item Task berhasil dibuat';
        return $this->sendResponse($task, $message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemTask  $itemTask
     * @return \Illuminate\Http\Response
     */
    public function show(ItemTask $itemTask)
    {
        $message = $itemTask->parent_id ? 'Detail sub item task' : 'Detail item task';
        return $this->sendResponse($itemTask, $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemTask  $itemTask
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemTask $itemTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemTask  $itemTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, ItemTask $itemTask)
    {
        $req->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemTask->update([
            'name' => $req->name,
        ]);

        $message = $itemTask->parent_id ? 'Sub item task berhasil diperbarui' : 'Item Task berhasil diperbarui';
        return $this->sendResponse($itemTask, $message);
    }

    public function updateStatus(Request $req, ItemTask $itemTask)
    {
        $req->validate([
            'is_completed' => 'required',
        ]);

        $itemTask->update([
            'is_completed' => $req->is_completed,
        ]);

        $message = $itemTask->parent_id ? 'Status sub item task berhasil diperbarui' : 'Status item task berhasil diperbarui';
        return $this->sendResponse($itemTask, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemTask  $itemTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemTask $itemTask)
    {
        $message = $itemTask->parent_id ? 'Sub item task berhasil dihapus' : 'Item task berhasil dihapus';
        $itemTask->delete();

        return $this->sendResponse([], $message);
    }
}
