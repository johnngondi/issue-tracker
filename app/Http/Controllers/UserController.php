<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Users/Index', [
            'canCreate' => Gate::allows('create', new User()),
            'roles' => Role::all(),
            'users' => User::all()->load('roles', 'tags'),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        Gate::authorize('create', new User());

        return Inertia::render('Users/Create', [
            'roles' => Role::all()->makeHidden(['created_at', 'updated_at']),
            'tags' => Tag::all()->makeHidden(['created_at', 'updated_at', 'description'])
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('create', new User());

        $input = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'roles' => 'required',
            'tags' => ''
        ]);

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make('P@$$w0rd')
            ]);

            $user->assignRole($input['roles']);
            $user->tags()->attach($input['tags']);

            return response([
                'code' => 0,
                'user' => $user
            ]);
        } catch (Exception $exception) {
            return response([
                'code' => 1
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        Gate::authorize('view', $user);

        $userRoles = $user->roles->pluck('id');
        $userTags = $user->tags->pluck('id');

        return Inertia::render('Users/Show', [
            'user' => [
                'info' => $user->makeHidden(['roles', 'tags']),
                'roles' => $userRoles,
                'tags' => $userTags
            ],
            'roles' => Role::all()->makeHidden(['created_at', 'updated_at']),
            'tags' => Tag::all()->makeHidden(['created_at', 'updated_at', 'description'])
        ]);
    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param User $user
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(User $user)
//    {
//        Gate::authorize('update', $user);
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|object $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user): \Illuminate\Http\Response
    {
        Gate::authorize('update', $user);

        try {
            $user->tags()->sync($request->tags);
            $user->syncRoles($request->roles);

            return response([
                'code' => 0
            ]);
        } catch (Exception $exception){

            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): \Illuminate\Http\Response
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response([
            'code' => 0,
        ]);
    }
}
