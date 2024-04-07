<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Traits\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use CheckRole;

    public function index()
    {
        $this->checkRole(['admin']);
        try {
            $data = User::all();
            return response($data, 200);
        } catch (\Exception $e) {
            return response(["success" => false, "message" => 'something went wrong'], 404);
        }
    }

    public function store(StoreUserRequest $request)
    {
        $this->checkRole(['admin']);
        try {
            $valid = $request->validated();
            $data = User::create($valid);
            return response(["success" => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            return response(["success" => false, "message" => 'something went wrong'], 404);
        }
    }

    public function show(User $user)
    {
        $this->checkRoleAndUser(['admin'], $user->id);
        try {
            $data = $user;
            return response($data, 200);
        } catch (\Exception $e) {
            return response(["success" => false, "message" => 'something went wrong'], 404);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->checkRoleAndUser(['admin'], $user->id);
        try {
            $valid = $request->validated();
            if ($request->hasFile('photo')) {
                $user->photo ? Storage::disk('userphotos')->delete($user->photo) : '';
                $fileName = uniqid() . '.' . $request->file('photo')->extension();
                $photoPath = $request->file('photo')->storeAs('userphotos', $fileName);
                $user->photo = $fileName;
                $user->save();
                $user->refresh();
                $user->photo = url('userphotos/' . $user->photo);
                $data = $user;
                return response(["success" => true, 'data' => $data], 201);
            }
            $user->update($valid);
            $user->refresh();
            $user->photo = url('userphotos/' . $user->photo);
            $data = $user;
            return response(["success" => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            return response(["success" => false, "message" => $e->getMessage()], 404);
        }
    }

    public function destroy(User $user)
    {
        $this->checkRole(['admin']);
        try {
            if ($user->photo) {
                Storage::disk('userphotos')->delete($user->photo);
            }
            $user->delete();
            $data = $user;
            return response(["success" => true, 'data' => $data], 203);
        } catch (\Exception $e) {
            return response(["success" => false, "message" => $e->getMessage()], 404);
        }
    }
}
