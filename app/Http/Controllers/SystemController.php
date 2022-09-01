<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\Systems;
use App\Models\System;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class SystemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //get systems
        $systems = Systems::getAccessibleByUser();

        return Inertia::render('Systems/Index', [
            'systems' => $systems,
            'canCreate' => Gate::check('create', new System())
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        Gate::allows('create', new System());

        $users = User::all();
        $tags = Tag::all()->makeHidden(['created_at', 'updated_at']);

        return Inertia::render('Systems/Create', [
            'users' => $users,
            'tags' => $tags
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        Gate::allows('create', new System());
        $input = $request->validate([
            'name' => 'required|unique:systems',
            'repository_url' => 'required',
            'description' => '',
            'users' => 'required',
            'tags' => 'required'
        ]);

        try {
            $system = System::create([
                'name' => $input['name'],
                'slug' => strtolower(str_replace(' ', '-', $input['name'])),
                'repository_link' => $input['repository_url'],
                'description' => $input['description'],
            ]);

            $system->tags()->attach($input['tags']);
            $system->users()->attach($input['users']);

            //create api key
            $systemApiKey = $system->createToken($system->name . ' - Key')->plainTextToken;
            $system->update([
                'system_api_key' => $systemApiKey
            ]);

            return response([
                'code' => 0,
                'system' => $system
            ]);
        } catch (Exception $exception) {
            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param System $system
     * @return Response
     */
    public function show(System $system): Response
    {
        Gate::authorize('view', $system);

        $systemUsers = $system->users->pluck('id');
        $systemTags = $system->tags->pluck('id');

//        return response($system);

        return Inertia::render('Systems/Show', [
            'system' => [
                'info' => $system->makeHidden(['users', 'tags']),
                'users' => $systemUsers,
                'tags' => $systemTags
            ],
            'users' => User::all()->makeHidden(['created_at', 'updated_at']),
            'tags' => Tag::all()->makeHidden(['created_at', 'updated_at', 'description'])
        ]);
    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param System $system
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(System $system)
//    {
////        Gate::authorize('update', new);
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request | object $request
     * @param System $system
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, System $system): \Illuminate\Http\Response
    {
        Gate::authorize('update', $system);
        try {

            $system->update([
                'name' => $request->name,
                'repository_link' => $request->repository_url
            ]);

            $system->users()->sync($request->users);
            $system->tags()->sync($request->tags);

            return response([
                'code' => 0
            ]);
        } catch (Exception $exception) {

            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param System $system
     * @return \Illuminate\Http\Response
     */
    public function destroy(System $system): \Illuminate\Http\Response
    {
        Gate::authorize('delete', $system);
        $system->delete();
        return response([
            'code' => 0,
        ]);
    }
}
