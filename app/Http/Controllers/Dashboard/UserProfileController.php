<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\Intl\Countries;
// use Symfony\Component\Intl\Languages;

class UserProfileController extends Controller
{
    public function edit(){

        $user=Auth::user();

        return view('dashboard.profile.edit',[
            'user'=>$user,
             'countries'=>['egypt','usa','canada','england','saudi','uke'],
             'locales'=>['en','ar','fr'],
        ]);
    }

    public function update(Request $request){

        $request->validate([
            'first_name'=>['required','string','max:255'],
            'last_name'=>['required','string','max:255'],
        ]);

        $user=$request->user();

        $user->profile->fill($request->all())->save();

        return redirect()->route('userprofile.edit')->with('success','Profile Updated Success');


        //to viedo 8.3 belongto realationship porduct tag
    }
}
