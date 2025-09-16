<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Destroy an authenticated session.
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function adminLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $verificationCode = random_int(100000, 999999);
            session(['verification_code'=>$verificationCode, 'user_id' => $user->id]);

            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

            Auth::logout();

            return redirect()->route('custom.verification.form')->with('status', 'Verification code sent to your mail');

            return redirect()->back()->withErrors(['email' => 'Invalid Credentials Provided']);
        }
    }

    public function showVerification(){
        return view('auth.verify');
    }
      // End Method

    public function verificationVerify(Request $request){
        $request->validate(['code' => 'required|numeric']);

        if ($request->code == session('verification_code')) {
            Auth::loginUsingId(session('user_id'));

            session()->forget(['verification_code','user_id']);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'Invalid Verification Code']);
    }

    public function adminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }

    public function profileStore(Request $request)
    {
        $id = Auth::user()->id;
        $userData = User::find($id);

        $userData->name = $request->name;
        $userData->email = $request->email;
        $userData->phone = $request->phone;
        $userData->address = $request->address;

        $oldPhotoPath = $userData->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'),$filename);
            $userData->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
            $this->deleteOldImage($oldPhotoPath);
            }
        }

        $userData->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
