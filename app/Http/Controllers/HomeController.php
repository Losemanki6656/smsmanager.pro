<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cadry;
use App\Sms;
use App\Archive;
use App\ArchiveTb;
use App\ArchiveRelay;
use App\UserRole;
use App\Relay;
use App\Tb;
use App\CommentRelay;
use App\Numbers;
use App\Department;
use App\Organization;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
            $cadry = Cadry::query()
                ->when(\Request::input('search'),function ($query,$search){
                    $query->where(function ($query) use ($search) {
                        $query->where('fullname', 'like', "%$search%");
                    });
                })->with(['department','number'])->orderBy('created_at','ASC');
            $departments = Department::all();

            return view('home',[
                'cadry' => $cadry->paginate(10),
                'departments' => $departments
            ]);
    }

    public function filter(Request $request)
    {
  
            $cadry = Cadry::query()
            ->when(\Request::input('search'),function ($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('fullname', 'like', "%$search%");
                });
            })->orderBy('next_date','ASC');
            $departments = Numbers::all();
            return view('home',[
                'cadry' => $cadry->paginate(10),
                'departments' => $departments
            ]);
    }


    public function add_worker(Request $request)
    {
        $dep = Department::with('number')->find($request->department_id);
        
            $cadry = new Cadry();
            $cadry->fullname = $request->fullname;
            $cadry->organization_id = $dep->organization_id;
            $cadry->number_id = $dep->number_id;
            $cadry->department_id = $request->department_id;
            $cadry->phone = $dep->number->phone;
            $cadry->last_date = $request->last_date;
            $cadry->next_date = $request->next_date;
            $cadry->passport = $request->passport;
            $cadry->stativ = $request->stativ;
            $cadry->rad = $request->rad;
            $cadry->mesto = $request->mesto;
            $cadry->save();

        return redirect()->back();
    }

    public function smstoken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://notify.eskiz.uz/api/auth/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email": "bbiznestg@gmail.com",
            "password": "sgiBsoQEyLKsh71Z3ikVLhh8LtzI66ntvDm47J13"
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $json = json_decode($response, true);
        $x = $json['data'];
      
        $smstoken = Sms::find(1);
        $smstoken->token = $x['token'];
        $smstoken->save();
        //dd($response);
        curl_close($curl);

        return 'success';
    }

    public function success_user(Request $request)
    {
        $x = UserRole::where('user_id',Auth::user()->id)->value('role_id');

        if($x == 1)
        {
            $user = Cadry::find($request->idrelay);
            $user->last_date = now();
            $user->next_date = $request->next_date;
            $user->save();

             $comments = new CommentRelay();
             $comments->user_id = $request->idrelay;
             $comments->comment = $request->comment;
             $comments->save();
        }
        else if($x == 2)
        {
            $user = Relay::find($request->iduser);
            $user->date_vacation = $request->date_vacation;
            $user->save();

            $comments = new CommentRelay();
            $comments->user_id = $request->iduser;
            $comments->comment = $request->commentrelay;
            $comments->save();
        }
        else
        if ($x == 3)
        {
            $user = Tb::find($request->iduser);
            $user->date_vacation = $request->date_vacation;
            $user->save(); 
        }
       

        return redirect()->back()->with('msg' ,1);
    }

    public function edit_user(Request $request)
    {
        $x = UserRole::where('user_id',Auth::user()->id)->value('role_id');

        if($x == 1)
        {
           // dd(Numbers::find($request->department_id)->numbers;);
            $user = Cadry::find($request->iduseredit);
            $user->fullname = $request->nameedit;
            $user->department_id = $request->department_id;
            $user->phone = Numbers::find($request->department_id)->numbers;
            $user->last_date = $request->last_date;
            $user->next_date = $request->next_date;
            $user->save();
        }
        else
        if($x == 2)
        {
            $user = Relay::find($request->iduseredit);
            $user->fullname = $request->nameedit;
            $user->department = $request->departmentedit;
            $user->date_pos = $request->date_pos_relay;
            $user->date_vacation = $request->date_vac;
            $user->save();
        }
        else
        if($x == 3)
        {
            $user = Tb::find($request->iduseredit);
            $user->fullname = $request->nameedit;
            $user->department = $request->departmentedit;
            $user->phone = $request->phone2;
            $user->date_vacation = $request->date_vac;
            $user->save();
        }
       

        return redirect()->back()->with('msg' ,1);
    }

    public function commentsrelay()
    {
       $comments = CommentRelay::all();

       return view('commentsrelay',[
           'comments' => $comments
       ]);
    }

    public function delete_user(Request $request)
    {
        $x = UserRole::where('user_id',Auth::user()->id)->value('role_id');

        if($x == 1)
        {
            Cadry::find($request->iduserdelete)->delete();  
            Archive::where('user_id',$request->iduserdelete)->delete();  
        }
        else
        if($x == 2)
        {
             Relay::find($request->iduserdelete)->delete();  
             CommentRelay::where('user_id',$request->iduserdelete)->delete();  
             ArchiveRelay::where('user_id',$request->iduserdelete)->delete();  
            
        }
        else 
        if($x == 3)
        {
            Tb::find($request->iduserdelete)->delete();  
            ArchiveTb::where('user_id',$request->iduserdelete)->delete(); 
        }
        

        return redirect()->back()->with('msg' ,1);
    }
    public function archive()
    {
        $x = UserRole::where('user_id',Auth::user()->id)->value('role_id');
        
        if($x == 1)
        {
            $archive = Archive::with('cadry')->orderBy('created_at','DESC')->get();
            return view('archive',[
                'archive' => $archive
            ]);
        } else
        if($x == 2)
        {
            $archive = ArchiveRelay::with('cadry')->get();

            return view('archiverelay',[
                'archive' => $archive
            ]);
        }
        else 
        if($x == 3)
        {
            $archive = ArchiveTb::with('cadry')->get();

            return view('archivetb',[
                'archive' => $archive
            ]); 
        }        
    }

    public function numbers(Request $request)
    {
        $numbers = Numbers::query()
            ->when(\Request::input('search'),function ($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('fullname', 'like', "%$search%");
                });
            })->get();

        return view('numbers',[
            'numbers' => $numbers
        ]);
    }

    public function departments()
    {
        $numbers = Numbers::all();
        $organizations = Organization::all();

        $departments = Department::query()
            ->when(\Request::input('search'),function ($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('fullname', 'like', "%$search%");
                });
            })->with(['organization','number'])->get();

        return view('departments',[
            'departments' => $departments,
            'organizations' => $organizations,
            'numbers' => $numbers
        ]);
    }
    public function add_department(Request $request)
    {
        $deps = new Department();
        $deps->organization_id = $request->organization_id;
        $deps->number_id = $request->number_id;
        $deps->name = $request->name;
        $deps->save();
        
        return redirect()->back()->with('msg' ,1);
    }

    public function edit_department(Request $request)
    {
        $deps =  Department::find($request->department_id);
        $deps->organization_id = $request->organization_id;
        $deps->number_id = $request->number_id;
        $deps->name = $request->name;
        $deps->save();
        
        return redirect()->back()->with('msg' ,1);
    }

    public function delete_department(Request $request)
    {
        $deps = Department::find($request->department_id)->delete();
        
        return redirect()->back()->with('msg' ,1);
    }


    public function organizations()
    {
        $organizations = Organization::query()
            ->when(\Request::input('search'),function ($query,$search){
                $query->where(function ($query) use ($search) {
                    $query->where('fullname', 'like', "%$search%");
                });
            })->get();
            
        return view('organizations',[
            'organizations' => $organizations
        ]);
    }


    public function add_number(Request $request)
    {
        $comments = new Numbers();
        $comments->fullname = $request->fullname;
        $comments->staff_name = $request->staff_name;
        $comments->phone = $request->phone;
        $comments->save();
        
        return redirect()->back()->with('msg' ,1);
    }

    public function edit_number(Request $request)
    {
        $user = Numbers::find($request->number_id);

        $relays = Cadry::where('number_id',$user->id)->get();

        $user->fullname = $request->fullname;
        $user->staff_name = $request->staff_name;
        $user->phone = $request->phone;

            foreach ($relays as $relay) {
                $relay->phone = $user->phone;
                $relay->save();
            }

        $user->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function deletenumber(Request $request)
    {
        Numbers::find($request->iduserdelete)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function add_organization(Request $request)
    {
        $comments = new Organization();
        $comments->name = $request->name;
        $comments->save();
        
        return redirect()->back()->with('msg' ,1);
    }

    public function edit_organization(Request $request)
    {
        $user = Organization::find($request->organization_id);

        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('msg' ,1);
    }

    public function delete_organization(Request $request)
    {
        Organization::find($request->organization_id)->delete();

        return redirect()->back()->with('msg' ,1);
    }

    public function send_message(Request $request)
    {
        $x = UserRole::where('user_id',Auth::user()->id)->value('role_id');
        
        if($x == 1)
        {
            $token = Sms::find(1)->token;

            $msg = 0;
            $char = ['(', ')', ' ','-','+'];
            $replace = ['', '', '','',''];
            $x = "";
    
            $phone = str_replace($char, $replace, $request->phonesenduser);
    
            $text = $request->textmessage; 
            $id = $request->idusersend;
    
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://notify.eskiz.uz/api/message/sms/send-batch',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>"{ \"messages\":[ {\"user_sms_id\":\"$id\",\"to\": \"$phone\",\"text\": \"$text\"} ],\"from\":\"4546\",\"dispatch_id\":\"123\"}",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
                'Content-Type: application/json'
            ),
            ));
    
            $response = curl_exec($curl);
    
            $err = curl_error($curl);
            curl_close($curl);
            $json = json_decode($response, true);

            if($json['status'] == "success")
            {
                $msg = 1;
    
                $archive = new Archive();
                $archive->user_id = $id;
                $archive->text_message = $request->textmessage;
                $archive->status = 1;
                $archive->save();
            }
            else
            {
                $edit_token = $this->smstoken();
                //dd($edit_token);
            }
        }
      

        return redirect()->back()->with('msg' ,$msg);
    }

}
