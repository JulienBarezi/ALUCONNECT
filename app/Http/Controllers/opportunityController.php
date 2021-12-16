<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class opportunityController extends Controller
{
    public function index(){
        $opportunities = Opportunity::orderBy('id', 'DESC')->get();
        foreach($opportunities as $key => $value){
            $user = User::where(['id' => $value->oppUserid])->get()->first();
            $category = Category::where(['id' => $value->oppCategoryid])->get()->first();

            $opportunities[$key]->user = $user;
            $opportunities[$key]->category = $category;
        }

        return response()->json($opportunities);
    }

    public function showbyCategory($catid){
        $opportunities = Opportunity::where('oppCategoryid', $catid)->orderBy('id', 'DESC')->get();
        foreach($opportunities as $key => $value){
            $user = User::where(['id' => $value->oppUserid])->get()->first();
            $opportunities[$key]->user = $user;
        }

        return response()->json($opportunities);
    }

    public function showAuthuserOpps(){
        $id = Auth::user()->id;
        $opportunities = Opportunity::where('oppUserid', $id)->orderBy('id', 'DESC')->get();
        return response()->json($opportunities);
    }

    public function showAuthuserOppsByCat($cat){
        $id = Auth::user()->id;
        $opportunities = Opportunity::where('oppCategoryid', $cat)->where('oppUserid', $id)->orderBy('id', 'DESC')->get();
        return response()->json($opportunities);
    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'oppUserid' => 'required|integer',
            'oppCategoryid' => 'required|integer',
            'companyName' => 'required',
            'jobTitle' => 'required',
            'dueDate' => 'required|date',
            'companyLink' => 'required',
            'description' => 'required',
            'postTime' => 'required|date',
        ])->validate();

        if($request->file('companyImg')){
            $file_name = 'aluconnect-' . $this->unique_code(9) . '.' . $request->file('companyImg')->getClientOriginalExtension();
            $request->file('companyImg')->move(public_path('uploads/images'), $file_name);
            $companyImg = $file_name;
        }

        try{
            $createOpportunity = new Opportunity([
                'oppUserid' => $request->input('oppUserid'),
                'oppCategoryid' => $request->input('oppCategoryid'),
                'companyName' => $request->input('companyName'),
                'jobTitle' => $request->input('jobTitle'),
                'dueDate' => $request->input('dueDate'),
                'companyImage' => $companyImg,
                'companyLink' => $request->input('companyLink'),
                'description' => $request->input('description'),
                'postTime' => $request->input('postTime'),
            ]);

            $createOpportunity->save();
            $status = true;
            $message = 'Opportunity created successfully';
        }

        catch (Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }

        // response
        $response = [
            'status' => $status,
            'message' => $message,
        ];
        return response()->json($response);
        
    } 
}
