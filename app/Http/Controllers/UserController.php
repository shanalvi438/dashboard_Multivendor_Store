<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\NewUser;
// use Illuminate\Support\Facades\Notification;
use App\Notifications\TestingNotification;
use Carbon\Carbon;

class UserController extends Controller
{

    // User CRUD === Saliha
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $users = User::all();
        $query = User::query();

        if ($request->has('name')) {
            $name = $request->input('name');
            if (is_array($name)) {
                $query->whereIn('name', $name);
            } else {
                $query->where('name', $name);
            }
        }

        if ($request->has('country')) {
            $country = $request->input('country');
            if (is_array($country)) {
                $query->whereIn('country', $country);
            } else {
                $query->where('country', $country);
            }
        }

        if ($request->has('city')) {
            $city = $request->input('city');
            if (is_array($city)) {
                $query->whereIn('city', $city);
            } else {
                $query->where('city', $city);
            }
        }

        if ($request->has('gender')) {
            $gender = $request->input('gender');
            if (is_array($gender)) {
                $query->whereIn('gender', $gender);
            } else {
                $query->where('gender', $gender);
            }
        }

        if ($request->has('email')) {
            $email = $request->input('email');
            if (is_array($email)) {
                $query->whereIn('email', $email);
            } else {
                $query->where('email', $email);
            }
        }

        if ($request->has('phone')) {
            $phone = $request->input('phone');
            if (is_array($phone)) {
                $query->whereIn('phone', $phone);
            } else {
                $query->where('phone', $phone);
            }
        }

        if ($request->has('addres')) {
            $addres = $request->input('addres');
            if (is_array($addres)) {
                $query->whereIn('addres', $addres);
            } else {
                $query->where('addres', $addres);
            }
        }

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }
        $users = $query->get();
        return view('users.userlist', compact('users'));
    }

    public function add()
    {
        $users = User::where('role', '=', 'Customer')->get();
        return view('users.create', compact('users'));
    }

    public function adduser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'The email field is required',
            'name.required' => 'The Name field is required',
            'password.required' => 'The Password field is required'
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->addres = $request->input('addres');
        $user->password = Hash::make($request->input('password'));
        $user->gender = $request->input('gender');
        $user->save();
        notify()->success('User created successfully', 'Success');
        Toastr::success('User added successfully', 'Success');

        return redirect()->route('userlist');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ], [
            'email.required' => 'The email field is required',
            'name.required' => 'The Name field is required',
            'password.required' => 'The Password field is required'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->addres = $request->input('addres');
        $user->gender = $request->input('gender');
        $user->save();
        notify()->success('User update successfully', 'Success');
        return redirect()->route('userlist');
    }

    public function delete_user($id)
    {
        $user = User::find($id);
        $user->delete();
        notify()->success('User deleted successfully', 'Success');
        return redirect()->back();
    }

    public function createUser(Request $request)
    {
        // Your user creation logic here
        $user = User::find($userId); // Retrieve the user instance
        Notification::send($user, new NewUser);

        $message = "This is a custom message.";
        Notification::send($user, new ExampleNotification($message));
        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $notifiable->prefers_sms ? ['vonage'] : ['mail', 'database'];
    }

    public function showNotifications()
    {
        $user = User::find(1);

        foreach ($user->notifications as $notification) {
            echo $notification->type;
        }
    }

    public function showUnreadNotifications()
    {
        $user = User::find(1);

        foreach ($user->unreadNotifications as $notification) {
            echo $notification->type;
        }
    }

    public function markAllNotificationsAsRead($userId)
    {
        $user = User::find($userId);

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        // Alternatively, you can use the following line to mark all unread notifications as read:
        // $user->unreadNotifications->markAsRead();

        return redirect()->back(); // Redirect back to the previous page or wherever you want
    }
}
