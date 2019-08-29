<?php

    namespace App\Http\Controllers;
    use App\Providers\UserDatabase;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;
    use App\User; 
    use Validator;
    use DB;
	
Class UserController extends Controller
{
    public $successStatus = 200;

    //Register un User 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'username' => 'required|string|max:255|unique:users',  
            'password' => 'required|string|min:8', 
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) 
        { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $input['c_password'] = bcrypt($input['c_password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['username'] =  $user;
        return response()->json(['success'=>$success], $this->successStatus); 
    }

     //Log un User
     public function login(Request $request)
     { 
         $pass = hash('sha256', request('password'));
         if(Auth::attempt(['username' =>request('username'), 'password' =>request('password')]))
         { 
             $user = Auth::user();  
             $success['token'] =  $user->createToken('MyApp')->accessToken; 
             return response()->json(['success' => $success], $this->successStatus); 
         } 
         else
         {
         return response()->json(['error'=>'Unauthorised'], 401); 
         }
     }
 
     //Logout
     public function logout(Request $request)
     {
         $request->user()->token()->revoke();
         return response()->json(['succes'=>true, 'status'=>200]);
     }

        //Afficher les users
    public function getUsers()
        {
            $db = new UserDatabase();
            $users = $db->getAll();
            if (count($users) == 0)
            {
                $msg = "No Users Found";
                return response()->json(['about'=> $msg], $this->echecStatus);
            }
            return response()->json($users);
        }
}