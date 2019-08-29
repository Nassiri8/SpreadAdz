<?php

    namespace App\Http\Controllers;
    use App\Providers\AnnonceDatabase;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;
    use App\User; 
    use Validator;
    use DB;
	
Class AnnoncesController extends Controller
{
    public $successStatus = 200;
    public $echecStatus = 400;

    public function getAnnonces()
    {
        $db = new AnnonceDatabase();
        $posts = $db->getAll();
        if (count($posts) == 0)
        {
            $msg = "Annonce Not Found";
            return response()->json(['about'=> $msg], $this->echecStatus);
        }
        return response()->json($posts);
    }

    public function annonceById($id)
    {
        $db = new AnnonceDatabase();
        $posts = $db->getAnnonceById($id);
        if (count($posts) == 0)
        {
            $msg = "Annonce Not Found";
            return response()->json(['about'=> $msg], $this->echecStatus);
        }
        return response()->json($posts);
    }

    public function annonceByUserId($id)
    {
        $db = new AnnonceDatabase();
        $posts = $db->getAnnonceByUserId($id);
        if (count($posts) == 0)
        {
            $msg = "Annonce Not Found";
            return response()->json(['about'=> $msg], $this->echecStatus);
        }
        return response()->json($posts);
    }

    public function postAnnonce(Request $request)
    {
        $id_user = Auth::user()->id;

            $validator = Validator::make($request->all(), [ 
                'categorie' => 'required|string|max:255',
                'titre' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'prix' => 'required|integer',
                'phone' => 'required|regex:/^[0-9]{10}/'
            ]);

            if($validator->fails())
            {
                return response()->json(['error'=>$validator->errors()], 401);
            }

            $date = date("Y-m-d H:i:s");

            $input = $request->all(); 

            DB::table('annonces')
            ->insert([
            'categorie'=> $input['categorie'],
            'user_id'=>$id_user,
            'description' => $input['description'],
            'titre' => $input['titre'],
            'phone' => $input['phone'],
            'prix' => $input['prix'],
            'date' => $date]);
            $success= $input['titre'];
            return response()->json(['success'=>$success, 'status'=>200]); 
    }

    public function deleteAnnonce($id)
    {
        $id_user = Auth::user()->id;
        DB::table('annonces')->where([['user_id','=' ,$id_user], ['id', '=', $id]])->delete();
        return response()->json(['message'=>'élément supprimé', 'status'=>200]);
    }

    public function updateAnnonce(Request $request, $id)
    {
        $date = date("Y-m-d H:i:s");
        $validator = Validator::make($request->all(), [ 
            'categorie' => 'nullable|string|max:255',
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'prix' => 'nullable|integer',
            'phone' => 'nullable|regex:/^[0-9]{10}/'
        ]);

        if($validator->fails())
            {
                return response()->json(['error'=>$validator->errors()], 401);
            }
        
        $input = $request->all();
        $input['date'] = $date;
        DB::table('annonces')
        ->where('id', '=', $id)
        ->update($input);

        return response()->json(['about'=>'update'], 200);;
    }
}