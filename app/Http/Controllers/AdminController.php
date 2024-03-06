<?php

namespace App\Http\Controllers;



use App\Http\Requests\AdminUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        $users = user::all();
        return view('admin.index', ['users' => $users]);
    }
    public function show($id)
    {
        $users = user::find($id); //if id wrong return 404page
        return view('admin.show', ["users", $users]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'Name' => 'reqiured',
            'email' => 'reqiured',
        ]);

    }


    public function edit(Request $request)
    {
        return view('admin.edit', [
            'user' => $request->user(),
        ]);
    }


    public function update(AdminUpdateRequest $request ):RedirectResponse
    {
        $request->user()->fill($request->validated());
         if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('admin.edit')->with('status', 'user-updated');
    }



    public function destroy($id)
    {
        // $this->validate($request , [''=> '']);
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        }

    }
}