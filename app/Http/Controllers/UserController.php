<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',

        ]);

        try {

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email_verified_at = now();
            $user->password = Hash::make(Str::random(25));
            $user->save();

            if($request->file){

                $pictureRoute = Storage::disk('public')->putFile('users/'.$user->id, $request->file);
                $user->photo = $pictureRoute;
                $user->save();
            }


            DB::commit();

            return redirect(route('users.index'))->with('message', ['success', __('The user was created')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('users.index'))->with('message', ['danger', $th->getLine().' '.$th->getMessage()]);

        }
    }

    public function show()
    {
        return Auth::user();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::whereId($id)->first();

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::whereId($id)->first();

        $validated = $request->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,

        ]);

        try {

            DB::beginTransaction();

            $user->name = $request->first_name;
            $user->email = $request->email;

            if($request->picture){

                //Delete old picture

                Storage::disk('public')->delete($user->photo);

                $pictureRoute = Storage::disk('public')->putFile('users/'.$user->id, $request->file);
                $user->photo = $pictureRoute;


            }

            $user->push();

            DB::commit();

            return redirect(route('users.index'))->with('message', ['success', __('The user was updated')]);
            

        } catch (\Exception $th) {
            
            DB::rollback();

            return redirect(route('users.index'))->with('message', ['danger', $th->getMessage()]);

        }

    }

    public function updateUsername(Request $request){

        if(!$request->username){

            return response([
                'message' => 'username is required'
            ], Response::HTTP_BAD_REQUEST);
            
        }

        $user = Auth::user();

        $user->update([
            'name' => $request->username
        ]);
        $user->save();

        return $user;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorFail($id);

        $user->delete();

        return redirect(route('users.index'))->with('message', ['danger', __('The user was deleted')]);
    }
}
