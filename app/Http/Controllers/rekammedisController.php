<?php

namespace App\Http\Controllers;

use App\Models\Rekammedis;
use Illuminate\Http\Request;

class rekammedisController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        // validasi: hanya application/json atau application/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
        $rekammedis = Rekammedis::OrderBy("id", "DESC")->paginate(10);

        if ($acceptHeader === 'application/json'){
            //response json
            return response()->json($rekammedis->items('data'), 200);
        } else {
            // create xml rekamedis element
            $xml = new \SimpleXMLElement('<rekamedis/>');
            foreach ($rekammedis->items('data') as $item){
                // create xml rekamedis element
                $xmlItem = $xml->addChild('rekamedis');

                //mengubah setiap field rekammedis menjadi bentuk xml
                //'jenis_pendaftaran', 'surat_rujukan', 'tgl_pendaftaran', 'pasien_id'
                $xmlItem->addChild('jenis_pendaftaran', $item->jenis_pendaftaran);
                $xmlItem->addChild('surat_rujukan', $item->surat_rujukan);
                $xmlItem->addChild('tgl_pendaftarann', $item->tgl_pendaftaran);
                $xmlItem->addChild('pasien_id', $item->no_rm);
                $xmlItem->addChild('created_at', $item->created_at);
                $xmlItem->addChild('updated_at', $item->updated_at);
            }
            return $xml->asXML();
        }

        //$outPut = [
        //    "message" => "pasiens",
        //    "results" => $pasiens
        //];

        return response()->json($rekammedis, 200);
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
        $rekammedis = Rekammedis::create($input);

        return response()->json($rekammedis, 200);
    } else {
        return response('Unsupported Media Type', 415);
    }
    }else {
        return response ('Not Accepttable!', 406);
    }
    }
    public function show ($id)
    {
        $rekammedis = Rekammedis::find($id);

        if (!$rekammedis){
            abort(400);
        }
        return response()->json($rekammedis, 200);
    }
    public function update (Request $request, $id)
    {
        $input = $request->all();
        $rekammedis = Rekammedis::find($id);

        if (!$rekammedis){
            abort(400);
        }

        $rekammedis->fill($input);
        $rekammedis->save();
        
        return response()->json($rekammedis, 200);
    }
    public function destroy ($id)
    {
        $rekammedis = Rekammedis::find($id);

        if(!$rekammedis) {
            abort(404);
        }

        $rekammedis->delete();
        $message = ['messsage' => 'deleted successfully', 'rekammedis_id' => $id];
        return response()->json($message, 200);
    }
}