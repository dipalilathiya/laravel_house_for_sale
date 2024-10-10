<?php
namespace App\Http\Controllers;
use App\Models\Blog_Model;
use App\Models\Category_Model;
use App\Models\Contact_Model;
use App\Models\Rent_Model;
use App\Models\Tools_Model;
use Illuminate\Http\Request;

class admin_controller extends Controller
{
    function index(Request $res){
        $Tools = Tools_Model::count();
        $rent = Rent_Model::count();
        $type = Category_Model::count();
        $contect = Contact_Model::count();
        if($res->session()->has('email') ){
            return view("admin/index",compact('Tools','rent','type','contect'));
            // compact->with ni jgya a
            // all- get ni jgya a
            // create->insert ni jgya a
        }else{
            return redirect()->route('login');
        }
    }
    function Category(Request $res){
        $data = Category_Model::get();
        if(isset($res->id)){
        
            $filename = $res->file('img')->getClientOriginalName();
            $res->file('img')->move('image/',$filename);  

            $arr=array("name"=>$res->name, "img"=>$filename);
            Category_Model::where("id","=",$res->id)->update($arr);
            $data = Category_Model::get(); 
        }else{
            if(isset($res->name)){
            $filename = $res->file('img')->getClientOriginalName();
            $res->file('img')->move('image/',$filename);  
            $arr=array(  "name"=>$res->name,"img"=>$filename);
            Category_Model::insert($arr);
                $data = Category_Model::get();
            }
        }
        if($res->session()->has('email') ){
            return view("admin/category")->with('data',$data);
        }else{
            return redirect()->route('login');
        }
    }
    function Rent(){
        $data = Rent_Model::get();
        return view("admin/Rent")->with('data',$data);
    }
    function Tools(Request $res){
        $data = Tools_Model::get();
        if(isset($res->id)){
            $file = $res->file('img');
            $destinationPath = "img/";
            $originalFile = $file->getClientOriginalName();
            $file->move($destinationPath,$originalFile);
            $arr=array(  "name"=>$res->name,"Rate_Per_Day"=>$res->r_p_d,"Rate_Per_Month"=>$res->r_p_m,
            "Rate_Per_Year"=>$res->r_p_y,"Rate_Per_Hour_With_Operator"=>$res->r_p_h_w_o,"Location"=>$res->Location,
            "Description"=>$res->Description,"cat_id"=>$res->cat_id, "img"=>$originalFile);
            Tools_Model::where("id","=",$res->id)->update($arr);      
        }else{
                if(isset($res->name)){
                    $file = $res->file('img');
                    $destinationPath = "img/";
                    $originalFile = $file->getClientOriginalName();
                    $file->move($destinationPath,$originalFile);
                    $arr=array( "name"=>$res->name,"Rate_Per_Day"=>$res->r_p_d, "Rate_Per_Month"=>$res->r_p_m,
                    "Rate_Per_Year"=>$res->r_p_y,"Rate_Per_Hour_With_Operator"=>$res->r_p_h_w_o,
                     "Location"=>$res->Location,"Description"=>$res->Description , "cat_id"=>$res->cat_id,"img"=>$originalFile);
                      Tools_Model::insert($arr);
        }
    }
        if($res->session()->has('email') ){
            return view("admin/Tools",compact('data'));
        }else{
            return redirect()->route('login');
        }
    }
    function Contact(Request $res){
        if($res->session()->has('email') ){
            return view("admin/contectus");
        }else{
            return redirect()->route('login');
        }    
    }
    function Blog(Request $res){
        $data = Blog_Model::get();
        if($res->session()->has('email') ){
            return view("admin/Blog",compact('data'));
        }else{
            return redirect()->route('login');
        }   
     }
     function update($id){
        $data = Category_Model::get();
        return view('admin/category')->with($id,'data');
     }
     function delete($id){
        $data = Category_Model::find($id)->delete();
        if($data){
            return redirect('/Category');
        }
     }
     function update_cat($id){
        $data = Tools_Model::get();
        return view("admin/tools")->with('data',$id);
     }
     function delete_tools($id){
        $data = Tools_Model::find($id)->delete();
        if($data){
            return redirect('/Tools');
        }
     }
     function delete_rent($id){
        $data = Rent_Model::find($id)->delete();
        if($data){
            return redirect('/Rent');
        }  
     }
}