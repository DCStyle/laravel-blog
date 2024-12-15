<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->input('q') !== null) {
            $terms = $request->input('q');
        } else {
            $terms = '';
        }

        if ($request->input('order') !== null) {
            $order = $request->input('order');
        } else {
            $order = 'desc';
        }
        if ($request->input('limit') !== null) {
            $limit = $request->input('limit');
        } else {
            $limit = 20;
        }

        $users = User::orderBy('id', $order);

        if ($terms !== null && $terms !== '') {
            $keywords = explode(' ', $terms);

            $users->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('firstname', 'like', '%' . $keyword . '%')
                        ->orWhere('lastname', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%');
                }
            });
        }

        if ($limit === 0) {
            $users = $users->get();
        } else {
            $users = $users->paginate($limit);
        }

        return view('user.index', [
            'users' => $users,
            'terms' => $terms,
            'order' => $order,
            'limit' => $limit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $input['image_path'] = '/images/user.png';

        $user = User::create($input);

        $input['send_mail'] = $request->send_mail == 'on' ? true : false;

        if ($input['send_mail']) {
            $data['subject'] = 'Tạo tài khoản thành công!';
            $data['user'] = $request->firstname.' '.$request->lastname;
            $data['login'] = $request->email;
            $data['password'] = $request->password;
            $data['toEmail'] = $data['login'];

            return redirect()->route('mail.send', [
                'data' => $data,
            ]);
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        // $user = User::find($id);
        // return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            abort(403);
        }

        return view('user.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        if ($request->profile_update) {
            $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
            ]);

            if ($id != Auth::id()) {
                abort(403);
            }
        } else {
            $path = parse_url($request->headers->get('referer'), PHP_URL_PATH);
            $user_id = explode('/', $path)[3];

            if ($user_id != $id) {
                abort(403);
            }

            if ($user_id == Auth::id()) {
                abort(403);
            }

            if (! Auth::User()->can('user-edit')) {
                abort(403);
            }

            $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
            ]);
        }

        $input = $request->all();

        if (! empty($input['password'])) {
            if ($request->profile_update) {
                $this->validate($request, [
                    'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'min:8',
                ]);

                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = Hash::make($input['password']);
            }
        } else {
            $input = Arr::except($input, ['password']);
        }

        if (! empty($input['image'])) {
            $input['image_path'] = $this->storeImage($request);
        }

        $data = [];

        $user = User::findOrFail($id);

        $oldName = $user->firstname.' '.$user->lastname;

        $user->update($input);

        $changes = Arr::except($user->getChanges(), 'updated_at');

        if (isset($changes['firstname'])) {
            $data['user'] = $changes['firstname'];
            $data['new_name'] = $data['user'];
        }
        if (isset($changes['lastname'])) {
            if (isset($changes['firstname'])) {
                $data['user'] = $changes['firstname'].' '.$changes['lastname'];
                $data['new_name'] = $data['user'];
            } else {
                $data['user'] = $request->firstname.' '.$changes['lastname'];
                $data['new_name'] = $data['user'];
            }
        } else {
            if (isset($changes['firstname'])) {
                $data['user'] = $changes['firstname'].' '.$request->lastname;
                $data['new_name'] = $data['user'];
            } else {
                $data['user'] = $request->firstname.' '.$request->lastname;
            }
        }

        if (isset($changes['email'])) {
            $data['login'] = $changes['email'];
            $data['toEmail'] = $changes['email'];
        } else {
            $data['toEmail'] = $request->email;
        }
        if (isset($changes['password'])) {
            $data['password'] = $request->password;
        }

        $input['send_mail'] = $request->send_mail == 'on' ? true : false;

        if ($changes) {
            $data['subject'] = 'Những thay đổi đã được thực hiện đối với tài khoản của bạn.';
            $data['user'] = $oldName;
            if ($input['send_mail']) {
                return redirect()->route('mail.send', [
                    'data' => $data,
                ]);
            }
            if ($data['toEmail'] == 'admin@db.com' || ! isset($data['toEmail'])) {
                return redirect()->back();
            }
        } else {
            if ($request->profile_update) {
                return redirect()->back();
            }
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        if (Auth::id() == $id) {
            abort(403);
        }

        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index');
    }


    private function storeImage(Request $request)
    {
        $imageName = str_replace(' ', '-', $request->image->getClientOriginalName());
        $newImageName = uniqid().'-'.$imageName;
        $request->file('image')->move(public_path('images/avatars'), $newImageName);

        return '/images/avatars/'.$newImageName;
    }
}
