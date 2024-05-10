<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

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
        return view('home');
    }
    //PARA VERIFICAR EL OTP
    public function verificar(Request $request){
        $this->validate($request,[
            'otp'=>'required|numeric'
        ]);
        $usuario=User::where('id',auth()->user()->id)->first();
        if($usuario->otp==$request->otp){
            $usuario->verificado=true;
            $usuario->save();
            return redirect('home');
        } else{
            return back()->with('error','El codigo OTP es incorrecto');
        }
    }

    //FUNCION PARA REENVIAR otp
public function reenviar(){
    $paraOtp=rand(100000,999999);
    $usuario=User::where('id',auth()->user()->id)->first();
    $usuario->otp=$paraOtp;
    $usuario->save();
    $sid=env('TWILIO_SID');
        $token=env('TWILIO_TOKEN');
        $from=env('TWILIO_FROM');

        try {
            //code...
            $client = new Client($sid, $token);

            $client->messages->create($usuario->telefono,[
                'from'=>$from,
                'body'=>"Tu codigo OTP es: ".$paraOtp.". No lo compartas con nadie."
            ]);
             return redirect('home')->with('info','Se envio el otp a tu numero de tlefono.');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error','No se pudo enviar el mensaje. Intentalo de nuevo');

        }
}

}
