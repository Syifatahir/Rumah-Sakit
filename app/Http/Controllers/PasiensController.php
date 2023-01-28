<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasiensController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        // validasi: hanya application/json atau application/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
        $pasiens = Pasien::OrderBy("id", "DESC")->paginate(10);

        if ($acceptHeader === 'application/json'){
            //response json
            return response()->json($pasiens->items('data'), 200);
        } else {
            // create xml pasiens element
            $xml = new \SimpleXMLElement('<pasiens/>');
            foreach ($pasiens->items('data') as $item){
                // create xml pasiens element
                $xmlItem = $xml->addChild('pasien');

                //mengubah setiap field pasien menjadi bentuk xml
                $xml->addChild('email', $item->email);
                $xml->addChild('nama', $item->nama);
                $xml->addChild('NIK', $item->NIK);
                $xml->addChild('alamat', $item->alamat);
                $xml->addChild('tempat_lahir', $item->tempat_lahir);
                $xml->addChild('umur', $item->umur);
                $xml->addChild('jk', $item->jk);
                $xml->addChild('created_at', $item->created_at);
                $xml->addChild('updated_at', $item->updated_at);
            }
            return $xml->asXML();
        }

        //$outPut = [
        //    "message" => "pasiens",
        //    "results" => $pasiens
        //];

        return response()->json($pasiens, 200);
    } else {
        return response('Not Acceptable!', 406);
    }
    }
    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        //validasi: hanya application/json atau application/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $contentTypeHeader = $request->header('Content-Type');

            // validasi : hanya application/json yang valid
            if ($contentTypeHeader === 'application/json'){
        $input = $request->all();
        $pasien = Pasien::create($input);

        return response()->json($pasien, 200);
    } else {
        return response('Unsupported Media Type', 415);
    }
    }else {
        return response ('Not Accepttable!', 406);
    }
    }
    public function show ($id)
    {
        $pasien = Pasien::find($id);

        if (!$pasien){
            abort(400);
        }
        return response()->json($pasien, 200);
    }
    public function update (Request $request, $id)
    {
        $input = $request->all();
        $pasien = Pasien::find($id);

        if (!$pasien){
            abort(400);
        }

        $pasien->fill($input);
        $pasien->save();

        return response()->json($pasien, 200);
    }
    public function destroy ($id)
    {
        $pasien = Pasien::find($id);

        if(!$pasien) {
            abort(404);
        }

        $pasien->delete();
        $message = ['messsage' => 'deleted successfully', 'pasien_id' => $id];

        return response()->json($message, 200);
    }
}