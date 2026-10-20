<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller {
 public function login(Request $r){$d=$r->validate(['email'=>'required|email','password'=>'required|string']);$u=User::where('email',$d['email'])->first();if(!$u||!$u->active||!Hash::check($d['password'],$u->password))throw ValidationException::withMessages(['email'=>['Invalid credentials.']]);$u->tokens()->delete();return response()->json(['token'=>$u->createToken('yuasa-api')->plainTextToken,'user'=>$u]);}
 public function logout(Request $r){$r->user()->currentAccessToken()?->delete();return response()->json(['message'=>'Logged out']);}
 public function me(Request $r){return response()->json(['user'=>$r->user()]);}
 public function changePassword(Request $r){
  $d=$r->validate(['current_password'=>'required|string','password'=>'required|string|min:8|confirmed']);
  if(!Hash::check($d['current_password'],$r->user()->password)){
   throw ValidationException::withMessages(['current_password'=>['Current password is incorrect.']]);
  }
  $r->user()->update(['password'=>Hash::make($d['password'])]);
  return response()->json(['message'=>'Password updated successfully.']);
 }
}

