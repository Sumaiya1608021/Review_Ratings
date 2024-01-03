<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ServiceRating;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function registerUser(Request $request){
        $user=User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'user_type'=>$request->input('user_type'),
            'password'=>Hash::make($request->input('password')),

        ]);
        return response()->json([
            'status'=>'Success',
        'Data'=> $user
        ]);
      
    }


public function loginUser(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        if (!$token = auth()->attempt($validator->validated()))
        {
            return response() ->json(['error'=>'Unauthorized']);
        }
        return $this->responseWithToken($token);

    }
    protected function responseWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()-> getTTL() * 60
        ]);

    }
    public function saveRating(Request $request){
  
        $validator =Validator::make($request->all(),[
        'user_id'=>'required',
        'service_id'=>'required',
        'review'=>'required',
        'rating'=>'required',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        
        }
        $checkUser=auth()->user();
        $userId= $checkUser->id;
        
        $rating = new ServiceRating();
        $rating->user_id = $userId;
        $rating->service_id = $request->service_id;
        $rating->review=$request->review ;
        $rating->rating=$request->rating ;
        $rating->save();
        return response()->json(['message'=>'Review and ratings are added.']);
        }

        public function editServiceRating($id)
        {
            $editeRating = ServiceRating::where('id',$id)->first();
            return response()->json([
                'status'=>'success',
                'message'=>$editeRating
            ]);

        }

        public function updateServiceRating(Request $request,$id){
            $rating=ServiceRating::find($id);
            $rating->review=$request->review ;
            $rating->rating=$request->rating ;
            $rating->save();
            return response(['status'=>'200','message'=>'Ratings and reviews are updated successfully']);
           } 
        
        
           public function deleteServiceRating($id){
            $rating=ServiceRating::find($id);
            $rating->delete();
            return response(['status'=>'200','message'=>'Ratings and reviews  are deleted successfully']);
           } 
        
        
           
           public function showServiceRating(){
            $rating=ServiceRating::all();
            return $rating;
           } 
}
