<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models; //модель пользоватля
use Illuminate\Support\Facades\Storage;
use Mail; // фасад для отправки почты
use Illuminate\Support\Facades\Redirect;
use View;
use File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $rules=[
            'username' => 'required|max:255|unique:users',
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'patronymic' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
        ];
        $this -> validate($request, $rules);
        //Insert user
        $user=\App\Models\User::create([
            'username' => $request -> input('username'),
            'surname' => $request -> input('surname'),
            'patronymic' => $request -> input('patronymic'),
            'position' => $request -> input('position'),
            'phone' => $request -> input('phone'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        if(!empty($user->id))
        {
            $email=$user->email;  //это email, который ввел пользователь
            $token=str_random(32); //это наша случайная строка
            $model=new \App\Models\ConfirmUser; //создаем экземпляр нашей модели
            $model->email=$email; //вставляем в таблицу email
            $model->token=$token; //вставляем в таблицу токен
            $model->save();      // сохраняем все данные в таблицу
//отправляем ссылку с токеном пользователю


            Mail::send('email.confirm',['token'=>$token,'user' => $user],function($u) use ($user)
            {
                $u->from('admin@etp-rb.ru','Электронная торговая площадка «etp-rb.ru»');
                $u->to($user->email);
                $u->subject('Активация учетной записи');
            });
            return Redirect::to('/auth/userStatus');
        }
        else {
            return Redirect::back()->with('message','Ошибка соединения с базой данных, попробуйте позже.');
        }
    }
    public function confirm($token)
    {
        $model=\App\Models\ConfirmUser::where('token','=',$token)->firstOrFail(); //выбираем запись с переданным токеном, если такого нет то будет ошибка 404
        $user=\App\Models\User::where('email','=',$model->email)->first(); //выбираем пользователя почта которого соответствует переданному токену
        $user->status=1; // Меняем статус на 1;
        $user->save();  // сохраняем изменения
        $model->delete(); //Удаляем запись из confirm_users
        return redirect('/auth/login')->with('confirm_message', 'Ваша учетная запись успешно активирована, для продолжения регистрации Вам необходимо авторизироваться');
    }
    public function createOrganization($id)
    {
        $organization = \App\Models\Organization::find($id);
        return View::make('auth.organization_register',compact('organization'));
    }
    public function storeOrganization(Request $request, $id)
    {
        $organization =\App\Models\Organization::find($id);
        //Validation Rules
        $rules_fact_address =[
            'fact_post_code' => 'required|max:255',
            'fact_state' => 'required|max:255',
            'fact_city' => 'required|max:255',
            'fact_street' => 'required|max:255',
            'fact_building_number' => 'required|max:255',
        ];
        $rules_legal_address = [
            'legal_post_code' => 'required|max:255',
            'legal_state' => 'required|max:255',
            'legal_city' => 'required|max:255',
            'legal_street' => 'required|max:255',
            'legal_building_number' => 'required|max:255',
        ];
        $rules_bank =[
            'bank_bik' => 'required|digits:9',
            'bank_ks' => 'required|digits:20',
            'bank_rs' => 'required|digits:20',
            'bank_name' => 'required|max:255',
        ];
        $fact_address_checkbox = $request -> input('fact_address_checkbox');
        if($organization->type == 'legal_entity'){
            $rules_organization=[
                'full_name' =>'required|max:255',
                'short_name' => 'required|max:255',
                'inn' => 'required|digits:10',
                'kpp' => 'required|digits:9',
                'ogrn' => 'required|digits:13',
                'okpo' => 'required|digits:8',
                'contact_phone' => 'required',
                'contact_email' => 'required|email|max:255',

            ];
            $rules_files = [
                'file_egrul' => 'required',
                'file_founding' => 'required',
                'file_procuration' => 'required',
                'file_boss' => 'required',
                'file_approval' => 'required',
            ];

        }
        if($organization->type == 'individual_entrepreneur'){
            $rules_organization=[
                'full_name' =>'required|max:255',
                'short_name' => 'required|max:255',
                'inn' => 'required|digits:12',
                'kpp' => 'required|digits:9',
                'ogrn' => 'required|digits:15',
                'okpo' => 'required|digits:10',
                'contact_phone' => 'required',
                'contact_email' => 'required|email|max:255',
            ];
            $rules_files = [
                'file_egrul' => 'required',
                'file_founding' => 'required',
                'file_procuration' => 'required',
                'file_boss' => 'required',
                'file_approval' => 'required',
            ];
        }
        if ($organization->type =='individual'){
            $rules_organization=[
                'inn' => 'required|digits:12',
                'tax_registration' => 'required',
            ];
            $rules_files = [
                'file_passport' => 'required',
                'file_inn' => 'required',
                'file_snils' => 'required'
            ];
        }
        if($fact_address_checkbox == true){
            $rules = $rules_organization + $rules_legal_address + $rules_bank + $rules_files; // Don't validate inputs of legal address
        }
        else{
            $rules = $rules_organization + $rules_legal_address + $rules_fact_address + $rules_bank + $rules_files;
        }
        $this -> validate($request, $rules);
        $organization -> inn = $request-> input('inn');
        $organization ->save();
        if($organization->type == 'individual'){
            $individual = new \App\Models\Individual;
            $individual -> organization_id = $organization ->id;
            $tax_registration = Carbon::createFromFormat('d.m.Y', $request-> input('tax_registration'));
            $individual -> tax_registration = $tax_registration;
            $individual -> save();
        }
        if(($organization -> type == 'legal_entity') || ($organization -> type == 'individual_entrepreneur')){
            $legal = new \App\Models\Legal;
            $legal-> organization_id = $organization -> id;
            $legal -> full_name = $request-> input('full_name');
            $legal -> short_name = $request-> input('short_name');
            $legal -> kpp = $request-> input('kpp');
            $legal -> ogrn = $request-> input('ogrn');
            $legal -> okpo = $request-> input('okpo');
            $legal -> phone = $request-> input('contact_phone');
            $legal -> email = $request-> input('contact_email');
            $legal -> fax = $request-> input('contact_fax');
            $legal -> website = $request-> input('contact_website');
            $legal -> save();
        }
        //Legal Address
        $legalAddress=new \App\Models\Address;
        $legalAddress -> organization_id = $organization ->id;
        $legalAddress -> type = 'legal';
        $legalAddress -> post_code = $request-> input('legal_post_code');
        $legalAddress -> district = $request -> input('legal_district');
        $legalAddress -> state = $request -> input('legal_state');
        $legalAddress -> city = $request -> input('legal_city');
        $legalAddress -> street = $request -> input('legal_street');
        $legalAddress -> building_number = $request -> input('legal_building_number');
        $legalAddress -> building_number_2 = $request -> input('legal_building_number_2');
        $legalAddress -> flat = $request -> input('legal_flat');
        $legalAddress -> save();
        //Fact Address
       $factAddress=new \App\Models\Address;
        $factAddress -> organization_id = $organization ->id;
        if ($fact_address_checkbox == true)
        {
            $factAddress -> post_code = $legalAddress  -> post_code;
            $factAddress -> district = $legalAddress  -> district;
            $factAddress -> state = $legalAddress  -> state;
            $factAddress -> city = $legalAddress  -> city;
            $factAddress -> street = $legalAddress  -> street;
            $factAddress -> building_number = $legalAddress  -> building_number;
            $factAddress -> building_number_2 = $legalAddress  -> building_number_2;
            $factAddress -> flat = $legalAddress  -> flat;
        }
        else{
            $factAddress -> post_code = $request-> input('fact_post_code');
            $factAddress -> state = $request -> input('fact_state');
            $factAddress -> district = $request -> input('fact_district');
            $factAddress -> city = $request -> input('fact_city');
            $factAddress -> street = $request -> input('fact_street');
            $factAddress -> building_number = $request -> input('fact_building_number');
            $factAddress -> building_number_2 = $request -> input('fact_building_number_2');
            $factAddress -> flat = $request -> input('fact_flat');
        }
        $factAddress -> type ='fact';
        $factAddress -> save();
        //Bank
        $bank = new \App\Models\Bank;
        $bank -> organization_id = $organization -> id;
        $bank -> name = $request -> input('bank_name');
        $bank -> bik = $request -> input('bank_bik');
        $bank -> ks = $request -> input('bank_ks');
        $bank -> rs = $request -> input('bank_rs');
        $bank->save();
        //Files of organization documents
        if(($organization -> type == 'legal_entity') || ($organization -> type == 'individual_entrepreneur')){
            $file_egrul = $request->file('file_egrul');
            if($request->file('file_egrul')->isValid()){
                $this->fileUpload($file_egrul,'file_egrul', $organization->id);
            }
            $file_founding = $request->file('file_founding');
            if($request->file('file_founding')->isValid()){
                $this->fileUpload($file_founding, 'file_founding', $organization->id);
            }
            $file_procuration = $request->file('file_procuration');
            if($request->file('file_procuration')->isValid()){
                $this->fileUpload($file_procuration,'file_procuration', $organization->id);
            }
            $file_boss = $request->file('file_boss');
            if($request->file('file_boss')->isValid()){
                $this->fileUpload($file_boss,'file_boss', $organization->id);
            }
            $file_approval = $request->file('file_approval');
            if($request->file('file_approval')->isValid()){
                $this->fileUpload($file_approval,'file_approval', $organization->id);
            }
        }
        if ($organization -> type == 'individual'){
            $file_passport = $request->file('file_passport');
            if($request->file('file_passport')->isValid()){
                $this->fileUpload($file_passport,'file_passport', $organization->id);
            }
            $file_inn = $request->file('file_inn');
            if($request->file('file_inn')->isValid()){
                $this->fileUpload($file_inn,'file_inn', $organization->id);
            }
            $file_snils = $request->file('file_snils');
            if($request->file('file_inn')->isValid()){
                $this->fileUpload($file_snils,'file_snils', $organization->id);
            }
        }
        return Redirect::action('RegistrationController@success');

    }
    public function createOrganizationType()
    {
            return View::make('auth.organization_type_register');
    }
    public function storeOrganizationType(Request $request)
    {
        $rules=[
            'residence' => 'required',
            'role' => 'required',
            'type' => 'required',
        ];
        $this -> validate($request, $rules);
        $user = Auth::user();
        $organization =\App\Models\Organization::create([
            'residence' => $request -> input('residence'),
            'role' => $request -> input('role'),
            'type' => $request -> input('type'),
        ]);
        $user -> organization_id = $organization->id;
        $user->save();
        return redirect()->route('register.organization',[$organization->id]);
    }
    public function success()
    {
        return View::make('auth.register_success');
    }
    public function getBaseRegister()
    {
        return view('auth.base_register');
    }

    //Service functions
    public function fileUpload($file,$type, $id)
    {
        $destinationPath = public_path().'/uploads/'.$id.'/organization/';
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put('/organizations/'.$id.'/orgDocs/'.$file->getFilename().'.'.$extension,  File::get($file));
        $document = new \App\Models\Document();
        $document ->organization_id = $id;
        $document->type=$type;
        $document -> mime = $file -> getClientMimeType();
        $document -> original_filename = $file ->getClientOriginalName();
        $document ->filename = $file->getFilename().'.'.$extension;
        $document->save();
    }
}
