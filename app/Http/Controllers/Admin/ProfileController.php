<?php
 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.profile.edit', [
            'user' => $request->user()
        ]);
    }

    public function update(Request $request)
	{
		$validated = $request->validate([

			'name' => [
				'required',
				'string',
				'max:255'
			],

			'email' => [
				'required',
				'email',
				Rule::unique('users')
					->ignore(auth()->id()),
			],

			'phone' => [
				'nullable',
				'string',
				'max:20',
			],

		]);

		auth()->user()->update($validated);

		return back()->with(
			'success',
			'Profile updated successfully.'
		);
	}
	
	

	public function updatePassword(Request $request)
	{
		$request->validate([

			'current_password' => [
				'required',
			],

			'password' => [
				'required',
				'confirmed',
				'min:8',
			],

		]);

		$user = auth()->user();

		/*
		|--------------------------------------------------------------------------
		| Check Current Password
		|--------------------------------------------------------------------------
		*/

		if (
			!Hash::check(
				$request->current_password,
				$user->password
			)
		) {

			return back()->withErrors([

				'current_password' =>
					'Current password is incorrect.'

			]);
		}

		/*
		|--------------------------------------------------------------------------
		| Update Password
		|--------------------------------------------------------------------------
		*/

 		
		$user->password = Hash::make($request->password);
        $user->save();


		return back()->with(

			'success',

			'Password updated successfully.'

		);
	}


}