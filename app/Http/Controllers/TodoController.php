<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use App\Services\TodoService;
use App\Mail\TodoCreateMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class TodoController extends Controller
{
    /**
     * @param TodoService $todoService
     * @return JsonResponse
     */
    public function index(TodoService $todoService)
    {
        $todo = $todoService->getAllTodo();

        if ($todo) {
            return response()->json(['status' => 'success', 'result' => $todo]);
        }

        return response()->json(['status' => 'fail', 'message' => 'Lütfen görev ekleyiniz']);
    }

    /**
     * @param Request $request
     * @param TodoService $todoService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, TodoService $todoService)
    {
        $user = $request->user();

        if (!$user->hasRole(Role::ADMIN)) {
            return response()->json(['status' => 'fail', 'message' => 'Görev eklemek için yetkisniz bulunmamaktadır.']);
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'email' => 'required',
            'status' => 'required',
        ]);

        $todo = $todoService->create($request->all());

        try {
            Mail::to($todo->email)->send(new TodoCreateMail($todo));
        } catch (\Exception $exception) {
            Log::error('Mail Send Error : ' . $todo->id, $exception->getTrace());
        }

        return response()->json(['status' => 'success', 'message' => 'Görev başarıyla eklendi']);
    }

    /**
     * @param Request $request
     * @param $id
     * @param TodoService $todoService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id, TodoService $todoService)
    {
        $user = $request->user();
        $todo = $todoService->findById($id);

        if (!$user->hasRole(Role::ADMIN)) {
            $this->validate($request, [
                'status' => 'filled',
            ]);
            $todo->status = $request->input('status');
            $todo->save();

            return response()->json(['status' => 'success', 'message' => 'Görev başarıyla güncellendi']);
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'email' => 'required',
            'status' => 'required',
        ]);

        $todo->title = $request->input('title');
        $todo->description = $request->input('description');
        $todo->date = $request->input('date');
        $todo->email = $request->input('email');
        $todo->status = $request->input('status');
        $todo->save();

        return response()->json(['status' => 'success', 'message' => 'Görev başarıyla güncellendi']);
    }

    /**
     * @param Request $request
     * @param $id
     * @param TodoService $todoService
     * @return JsonResponse
     */
    public function destroy(Request $request, $id, TodoService $todoService)
    {
        $user = $request->user();

        if (!$user->hasRole(Role::ADMIN)) {
            return response()->json(['status' => 'failed', 'message' => 'Yönetici olmadığınız için bu görevi silemezsiniz.']);
        }

        $todo = $todoService->findById($id);
        $todo->delete();

        return response()->json(['status' => 'success', 'message' => 'Görev başarıyla silindi']);
    }
}
