<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function newcompany(Request $request){
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'website'   => 'required',
            'logo'      => 'image|required|max:3999'
        ]);

        /* File upload */
        if($request->hasFile('logo')){
            $fileObject = $request->file('logo');
            $filename = pathinfo($fileObject, PATHINFO_FILENAME);
            $ext = $request->file('logo')->getClientOriginalExtension();
            $file = $filename.'_'.time().'.'.$ext;
            $path = $request->file('logo')->storeAs('public', $file);
        }else{
            $file = "";
        }

        $values = $request->only(['name', 'email', 'phone', 'website']);
        $values['logo'] = $file;


        $id = DB::table('company')->insertGetId($values);
        $route = 'company/'.$id;
        return redirect($route);
    }

    public function newemployee(Request $request){
        $values = $request->only(['company_id', 'first_name', 'last_name', 'position', 'email', 'phone']);
        $id = DB::table('employees')->insertGetId($values);
        $route = 'employee/'.$id;
        return redirect($route);
    }

    public function editemployee(Request $request){
        $id = $request->input('id');
        $values = $request->only(['company_id', 'first_name', 'last_name', 'position', 'email', 'phone']);
        DB::table('employees')->where('id', $id)->update($values);
        $route = 'employee/'.$id;
        return redirect($route);
    }

    public function editcompany(Request $request){
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'website'   => 'required',
            'logo'      => 'image|max:3999'
        ]);

        $id = $request->input('id');
        $company = DB::select('select * from company where id=(?)', [$id])[0];


        /* File upload */
        if($request->hasFile('logo')){
            $fileObject = $request->file('logo');
            $filename = pathinfo($fileObject, PATHINFO_FILENAME);
            $ext = $request->file('logo')->getClientOriginalExtension();
            $file = $filename.'_'.time().'.'.$ext;
            $path = $request->file('logo')->storeAs('public', $file);
        }else{
            $file = $company->logo;
        }

        $values = $request->only(['name', 'email', 'phone', 'website']);
        $values['logo'] = $file;

   


        DB::table('company')->where('id', $id)->update($values);
        $route = 'company/'.$id;
        return redirect($route);
    }

}