<?php

namespace App\Http\Controllers\Tasks;

use App\Events\CalendarEvent;
use Carbon\Carbon;
use Validator;
use App\Tasks\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('start_date', '<', Carbon::now())->get();

        foreach ($tasks as $task) {
            event(new CalendarEvent($task));
        }

        return response()->json($tasks);
    }

    /**
     * Creating task
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->_validateInputs($request->input());

        $task = Task::create($request->input());

        return response()->json($task, 201);
    }

    /**
     * View task
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id)
    {
        return response()->json(
            Task::findOrFail($id)
        );
    }

    /**
     * Editing task
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, Request $request)
    {
        $task = Task::findOrFail($id);

        $this->_validateInputs($request->input());

        $task->update($request->input());

        return response()->json($task);
    }

    /**
     * Delete task
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        return response()->json(
            Task::firOrFail($id)->delete(), 204
        );
    }

    /**
     * Validate inputs for task
     *
     * @param $inputs
     * @return \Illuminate\Http\JsonResponse
     */
    private function _validateInputs($inputs)
    {
        $rules = [
            'title' => 'required',
            'start_date' => 'required',
        ];

        $validate = Validator::make($inputs, $rules);

        if ($validate->fails()) {
            return response()->json($validate->messages(), 422);
        }
    }
}
