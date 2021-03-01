<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Mail\SubscribeConfirmation;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(config('view.item_per_page'));
        return view('backend.userList', compact('users'));
    }

    public function show($userId)
    {
        $user = User::find($userId);
        return view('backend.userDetails', compact('user'));
    }

    public function destroy($userId)
    {
        if (Auth::user()->id == $userId) {
            return back()->with('errorMsg', 'You cannot delete yourself');
        }
        try {
            User::destroy($userId);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return redirect()->back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'User deleted');
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'owner')->get();
        return view('backend.user_create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $newUser = $request->only('title', 'name', 'username', 'email', 'website');
        $newUser['password'] = Hash::make($request->get('password'));
        $newAddress = $request->only('city', 'country_name');
        try {
            $newAddress = Address::create($newAddress);
            $newAddress['address_id'] = $newAddress->id;
            $newUser = User::create($newUser);
            $newUser->assignRole($request->get('role'));
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->withInput()->with('errorMsg', $this->getMessage($e));
        }
        return redirect()->route('users')->with('successMsg', 'User created!');
    }

    public function edit($userId)
    {
        $roles = Role::all();
        $user = User::findOrFail($userId);
        return view('backend.user_edit', compact('roles', 'user'));
    }

    public function update(UserRequest $request, $userId)
    {
        $newUser = $request->only('name', 'username', 'email');
        $newUser['is_active'] = $request->has('is_active');
        try {
            if ($request->has('password')) {
                $newUser['password'] = \Hash::make($request->get('password'));
            }
            $user = User::where('id', $userId)->first();
            $user->update($newUser);
            if ($request->has('role')) {
                $user->syncRoles(Role::where('name', $request->get('role'))->get());
            }
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $e->getMessage());
        }
        return redirect()->route('get-user', ['userId' => $userId])->with('successMsg', 'User updated');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $newPassword = $request->get('new_password');

        if (!Hash::check($request->get('old_password'), Auth::user()->password)) {
            return back()->with('errorMsg', 'Unauthorized request');
        }
        try {
            User::where('id', Auth::user()->id)->update(['password' => Hash::make($newPassword)]);
        } catch (\PDOException $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }

        return back()->with('successMsg', 'Password changed');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('backend.userDetails', compact('user'));
    }

    public function subscribe(Request $request)
    {
        $clientIP = $_SERVER['REMOTE_ADDR'] ?? null;
        $newAddress = ['ip' => $clientIP];

        try {
            $this->validate($request, ['name' => 'required', 'email' => 'required|email']);

            DB::beginTransaction();
            $newAddress = Address::create($newAddress);
            $newUser = User::where('email', $request->get('email'))->first();

            if (is_null($newUser)) {
                $newUser = $request->only('email', 'name');
                $newUser['last_ip'] = $clientIP;
                $newUser['address_id'] = $newAddress->id;
                $newUser['token'] = Hash::make($request->get('email'));
                $newUser = User::create($newUser);
                $newUser->assignRole(Role::where('name', 'reader')->first());

                $newUser->reader()->create(['notify' => 0, 'is_verified' => 0]);
                Mail::to($request->get('email'))->queue(new SubscribeConfirmation($newUser));
            } else {
                return back()->with('warningMsg', 'You have already subscribed, please contact with admin');
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Thanks, a mail has been to confirm you subscription');
    }

    public function confirmSubscribe(Request $request, $userId)
    {
        try {
            $this->validate($request, ['token' => 'required']);

            $user = User::where('id', $userId)
                ->where('token', $request->get('token'))
                ->first();

            if (is_null($user)) {
                return redirect()->route('home')->with('errorMsg', 'Invalid request');
            }

            if ($user->isReader()) {
                $user->reader->update(['is_verified' => 1, 'notify' => 1]);
                return redirect()->route('home')->with('successMsg', 'Congratulation, your subscription confirmed');
            }
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return response()->json(['errorMsg' => $this->getMessage($e)]);
        }
        return redirect()->route('home')->with('warningMsg', 'Something went wrong');
    }

    public function unSubscribe(Request $request, $userId)
    {
        try {
            $this->validate($request, ['token' => 'required']);

            $user = User::where('id', $userId)
                ->where('token', $request->get('token'))
                ->first();

            if (is_null($user)) {
                return redirect()->route('home')->with('errorMsg', 'Invalid request');
            }

            if ($user->isReader() && $user->reader->notify) {
                $user->reader->update(['is_verified' => 1, 'notify' => 0]);
                return redirect()->route('home')->with('successMsg', 'You have un-subscribed confirmed');
            }
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return response()->json(['errorMsg' => $this->getMessage($e)]);
        }
        return redirect()->route('home')->with('errorMsg', 'No subscription found');
    }

    public function toggleActive($userId)
    {
        try {
            $user = User::find($userId);
            $user->update(['is_active' => !$user->is_active]);
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'User updated successfully!');
    }
}
