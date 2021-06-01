<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where("role", "!=", "A")->get();
        return view('admin.users.indexx', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {
        
          
        $request->validate([
         'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'address' => 'required|string|max:255',
            // 'city' => 'required|string|max:255',
            // 'hospital_name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          // 'mobile' => 'required|unique:users',
          'password' => 'required|string|min:6',
        ],

        [     'name.required' => 'Name cannot be empty',
              'last_name.required' => 'Name cannot be empty',
                   'email.required' => 'Email field is required',
                   'email.unique' => 'Email has been already taken !',
                   'password.required' => 'Password cannot be empty',
                   'password.min' => 'Min Password length must be 6',
                ]
          
       );

    //     $input = $request->all();
    // dd($input);
        $input = new User();
        $input->name= $request->name;
        $input->last_name = $request->last_name;
        // $input->hospital_name = $request->hospital_name;
        $input->email= $request->email;
        $input->password = bcrypt($request->password);
        $input->role = $request->role;
        // $input->mobile =$request->mobile;
        // $input->city =$request->city;
        // $input->address =$request->address;
        // $input = request()->except(['_token']);
        $input->save();
        // $input['password'] =  bcrypt($request->password);
       

      // $new = User::create($input);

       return back()->with('added', 'Student has been added');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email',
          'password' => 'required|string|min:6',
          'mobile' => 'unique:users',
        ]);

        $input = $request->all();

         // if(isset($request->changepass))
         //    {
         //       DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($request->password)]);
         //    }
         //    else
         //    {
         //      $input['password'] = $user->password;
         //    }

        if (Auth::user()->role == 'A') {
          $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'mobile' => $input['mobile'],
            'address' => $input['address'],
            'city' => $input['city'],
            'role' => $input['role'],
          ]);
        } else if (Auth::user()->role == 'S') {
          $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'mobile' => $input['mobile'],
            'address' => $input['address'],
            'city' => $input['city'],
          ]);
        }

        return back()->with('updated', 'Student has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('deleted', 'User has been deleted');
    }

}
