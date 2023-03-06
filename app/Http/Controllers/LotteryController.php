<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Lottery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Illuminate\Support\Facades\Http;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name_lottery)
    {
        $data = Event::where('id_event', $name_lottery)->get()->toArray();
        if (empty($data)){
            return view('notfound');
        }else{
            return view('sorteo', ['name_lottery' => $name_lottery]);
        }
    }
    public function datos($id)
    {
        return view('datos', ['id' => $id]);
    }
    public function consultar_registro($id)
    {
        $data = Lottery::select(['name_lottery','name','city','email','whatsapp','cedula_p','practice','agent'])->where('id', $id)->get();
        return response()->json($data, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send_sms_whatsapp($cliente){
        $url = 'https://api.zenvia.com/v2/channels/whatsapp/messages';
        $curl = curl_init();
        $id_template = "cc550597-aa45-4972-8140-8c1f2ba07462";
        $from = "5213337874960";
        $to = "521".$cliente["asesor"]["telefono"];
        
        /* MENSAJE PARA EL ASESOR*/

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "from": "'.$from.'",
                "to": "'.$to.'",
                "contents": [
                  {
                    "type": "template",
                    "templateId": "'.$id_template.'",
                    "fields": {
                      "date_regis": "'.date("d/m/Y").'",
                      "name_client": "asesor, tu cliente '.$cliente["cliente"]["nombre"].'",
                      "event": "Congreso Internacional de Dermatología RegioDerma 2023",
                      "soporte": "'.$cliente["cliente"]["evento"].'"
                    }
                  }
                ]
              }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-API-TOKEN: Fz5aMHh6-JtRm892djS3SNhBdzv0mbLQwFSB'
            ),
        ));

        /* MENSAJE AL CLIENTE */
        
        $response[] = curl_exec($curl);
        curl_close($curl);

        $curl = curl_init();
        $id_template = "4e1ed346-06c5-4d21-a291-dbe671bd9678";
        $from = "5213337874960";
        $to = "521".$cliente["cliente"]["telefono"];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "from": "'.$from.'",
                "to": "'.$to.'",
                "contents": [
                  {
                    "type": "template",
                    "templateId": "'.$id_template.'",
                    "fields": {
                      "telefono": "'.$cliente["asesor"]["telefono"].'",
                      "asesordata": "'.$cliente["asesor"]["prefijo"].' '.$cliente["asesor"]["nombre"].'"
                    }
                  }
                ]
              }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-API-TOKEN: Fz5aMHh6-JtRm892djS3SNhBdzv0mbLQwFSB'
            ),
        ));

        $response[] = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

    public function create(Request $request)
    {
        $contact['data'] = json_decode($request->data,true);

        $messages = [
            'email.required' => 'El correo electrónico es obligatorio',
            'cedula_p.required' => 'La cédula profesional es obligatoria',
            'whatsapp.required' => 'El número de Whatsapp es obligatorio',
            'email.unique' => 'El correo electrónico ya se encuentra registrado',
            'cedula_p.unique' => 'La cédula profesional ya se encuentra registrada',
            'whatsapp.unique' => 'El número de Whatsapp  ya se encuentra registrado',
        ];

        $name_lottery = $contact['data']['info']['name_lottery'];
        $email = $contact['data']['info']['email'];
        $cedula_p = $contact['data']['info']['cedula_p'];
        $whatsapp = $contact['data']['info']['whatsapp'];

        $data = Validator::make($contact['data']['info'], [
            'email' => [
                'required',
                Rule::unique('lottery')->where(function ($query) use($name_lottery, $email) {
                    return $query->where('name_lottery', $name_lottery)
                    ->where('email', $email);
                }),
            ],
            'cedula_p' => [
                'required',
                Rule::unique('lottery')->where(function ($query) use($name_lottery, $cedula_p) {
                    return $query->where('name_lottery', $name_lottery)
                    ->where('cedula_p', $cedula_p);
                }),
            ],
            'whatsapp' => [
                'required',
                Rule::unique('lottery')->where(function ($query) use($name_lottery, $whatsapp) {
                    return $query->where('name_lottery', $name_lottery)
                    ->where('whatsapp', $whatsapp);
                }),
            ],
        ],
        $messages
        );
        if ($data->errors()->first()){
            return response()->json($data->errors()->first(), 201);
        }

        # Buscando agente por cedula profesional
        $url = "https://app.daneapp.com/danemed/index.php/Clientes/buscaragenteAPI/".$whatsapp;
        $result = file_get_contents($url);
        $data = json_decode($result, true);
        if ($data['status'] == 'success'){
            $contact['data']['info']['agent'] = $data['datos']['username'];
        }

        $register = Lottery::Create($contact['data']['info']);
        $client = Lottery::find($register->id);
        unset($data);
        $url = "https://app.daneapp.com/danemed/index.php/Clientes/buscardatosagenteAPI/?id=".$client->agent;
        $result = file_get_contents($url);
        $data = json_decode($result, true);
        if ($data['status'] == 'success'){
            $mensaje["cliente"] = array("nombre"=>$client->name,"telefono"=>$client->whatsapp,"evento"=>$client->id,"fecha"=>'04/03/2023');
            $mensaje["asesor"] = array("nombre"=>$data['datos']['nombre'].' '.$data['datos']['nombre2'],"telefono"=>$data['datos']['telefono'],"prefijo"=>$data['datos']['prefijo_sms']);
        }
        $this->send_sms_whatsapp($mensaje);
        return response()->json('¡Registro completado con Exito!', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function show(Lottery $lottery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function edit(Lottery $lottery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lottery $lottery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lottery $lottery)
    {
        //
    }

    public function all(Request $request)
    {   
        
        $query = Lottery::eloquentQuery(
            $request->input('column'),
            $request->input('dir'),
            $request->input('search'),
            [
                "name","city","email","whatsapp","cedula_p","practice"
            ]
        );
        

        $name_lottery = $request->input('name_lottery');

        if (isset($name_lottery)) {
            $query->where("name_lottery", $name_lottery);
        }

        $data = $query->paginate($request->input('length'));
        
        
        return new DataTableCollectionResource($data);
    }

    public function allData()
    {   
        $data = Lottery::select(['name_lottery','name','city','email','whatsapp','cedula_p','practice','agent'])->get();
        return $data;
    }

    public function updateData()
    {
        $datai = Lottery::get();

        foreach ($datai as $info){
            $score = Lottery::find($info['id']);
            $url = "https://app.daneapp.com/danemed/index.php/Clientes/buscaragenteAPI/".$info['whatsapp'];
            $result = file_get_contents($url);
            $data = json_decode($result, true);
            if ($data['status'] == 'success'){
                $score->agent = $data['datos']['username'];
                $score->save();
            }
            //dd($data);exit;
        }
    }
}
