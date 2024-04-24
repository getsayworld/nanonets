<?php

namespace App\Http\Controllers;

use App\Models\Document;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParseController extends Controller
{
    //

    public function PredictionforImageFile(Request $request)
    {
        $type = '';
        $msg = '';
        $files = [];
        if ($request->hasFile("document")) {
            $curl = curl_init();

            foreach ($request->file('document') as $key => $file) {
                if ($file->isValid()) {
                    $name = explode('.', $file->getClientOriginalName());


                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://app.nanonets.com/api/v2/OCR/Model/cd2d42f1-307d-48f6-ad0b-d689bd0a3936/LabelFile/',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array('file' => new CURLFile($file->getPathname())),
                        CURLOPT_HTTPHEADER => array(
                            'accept: multipart/form-data',
                            'Authorization: Basic NTIzNjFmODgtMDE4OS0xMWVmLThkN2UtZTY1YjhhY2E2ZWUzOg=='
                        ),
                    ));

                    $response = curl_exec($curl);

                    if ($response === false) {
                        $error = curl_error($curl);
                        $msg = $error;
                        $type = "error";
                    } else {
                        $data = json_decode($response, 1);
                        // echo "<pre>";
                        // print_r($data);

                        if (count($data['result']) > 0) {
                            foreach ($data['result'] as $value) {
                                $insert = array(
                                    'json' => json_encode($value),
                                    'user_id' => Auth::user()->id,
                                    'filename' => $name[0],
                                    'fileurl' => $data['signed_urls'][$value['filepath']]['original']
                                );
                                Document::insert($insert);
                            }
                        }
                        $type = "success";
                        $msg = "Document Uploaded";
                    }
                }
            }
            curl_close($curl);
        }

        if($type == 'success'){
            return redirect()->route('document')->with("$type","$msg");
        }else{
            return redirect()->back()->with("$type","$msg");
        }
    }

    public function documentlist()
    {
        // dd('ok');

        $data = Document::where('user_id', Auth::user()->id)->orderBy('id', "DESC")->get();
        return view('doc_list', compact('data'));
    }

    public function doc_details($id = '')
    {

        $data = Document::where('id', $id)->first();
        $doc_data = json_decode($data['json'], 1);
        return view('doc_details', compact('doc_data', 'data'));
    }
}
