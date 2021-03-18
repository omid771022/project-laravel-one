<?php


namespace App\Http\Controllers\Auth;


use App\User;
use App\ActiveCode;
use App\Notifications\LoginTowebsiteNotification;
use Illuminate\Http\Request;
use MohsenBostan\GhasedakSms;

trait TwoFactorAuthenticate
{
    public function loggendin(Request $request , $user)
    {
        if($user->hasTwoFactorAuthenticatedEnabled()) {
            auth()->logout();

            $request->session()->flash('auth' , [
                'user_id' => $user->id,
                'using_sms' => false,
                'remember' => $request->has('remember')
            ]);


            if($user->two_factor_type == 'sms') {
                $code = ActiveCode::generateCode($user);
                // Todo Send Sms
$user=User::where('email',$request['email'])->first();
 $id =$user['id'];
$active=ActiveCode::where('user_id',$id)->first();
$cavtive=$active['code'];
$user=$user['phone_number'];
GhasedakSms::sendSingleSMS("{$cavtive}  کاربر گرامی  رمز یک بار مصرف شما است ", $user);
// $comment->post()->associate($post)->save();
                $request->session()->push('auth.using_sms' , true);
            }


            return redirect(route('2fa.token'));
        }

        
$user->notify(new LoginTowebsiteNotification());
        return false;
    }
}
