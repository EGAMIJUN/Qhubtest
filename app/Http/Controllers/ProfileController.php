<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = Auth::user();
        $all_posts = Post::where('user_id', Auth::id())->with('user')->latest()->get();

        return view('users.profile.index', compact('user', 'all_posts'));
    }

    public function show($id)
    {
        $all_user = User::all();
        $user = $this->user->findOrFail($id);
        $all_posts = Post::where('user_id', $user->id)->with('user')->latest()->get();
        return view('users.profile.index', compact('user', 'all_posts', 'all_user'));
    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        // 🛡バリデーションするよ！変なデータはブロック！
        $request->validate([
            'name'                   => 'required|max:20',
            'email'                  => 'required|max:50',
            'introduction'           => 'required|min:1|max:1000',
            'avatar'                 => 'mimes:jpeg,jpg,png,gif|max:1048',
            'enrollment_start'  => 'nullable|date',   // 🆕 入学日
            'enrollment_end'    => 'nullable|date|after_or_equal:enrollment_start', // 🆕 卒業日は入学日以降
            'graduation_status'      => 'nullable|string|max:255', // 🆕 卒業ステータス
        ]);

        if ($request->enrollment_start && $request->enrollment_end) {
            if ($request->enrollment_end < $request->enrollment_start) {
                return back()->withErrors(['enrollment_end' => 'Graduation date must be after enrollment date.'])
                    ->withInput();
            }
        }

        $user = $this->user->findOrFail($id);

        // 💅 データをギャル仕様に着せ替え
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        // 🌸ここから新しく追加したプロパティたち
        $user->enrollment_start = $request->enrollment_start;
        $user->enrollment_end = $request->enrollment_end;
        $user->graduation_status = $request->graduation_status;

        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }
}
