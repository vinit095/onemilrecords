<?php

namespace App\Http\Controllers;

use App\Jobs\SalesCsvProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('csv')) {
            $data = file(request()->csv);
            unset($data[0], $data[1], $data[2], $data[3], $data[4]);

            // Chunking the data 
            $chunks = array_chunk($data, 100);
            $header = [];
            $batch = Bus::batch([])->dispatch();
            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key === 0) {
                    $header = array_shift($data);
                    unset($header[0]);
                    $header = array_values(array_map(function ($header) {
                        return strtolower(str_replace(' ', '_', str_replace('/', ' ', str_replace('.', '', $header))));
                    }, $header));
                }
                $batch->add(new SalesCsvProcess($data, $header));
            }
            return $batch;
        }
        return 'this is not normal';
    }

    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $path = storage_path('temp');
    //     $files = glob("$path/*.csv");
    //     $header = [];
    //     foreach ($files as $key => $file) {
    //         $data = array_map('str_getcsv', file($file));
    //         if ($key === 0) {
    //             $header = array_shift($data);
    //             unset($header[0]);
    //             $header = array_values(array_map(function ($header) {
    //                 return strtolower(str_replace(' ', '_', str_replace('/', ' ', str_replace('.', '', $header))));
    //             }, $header));
    //         }
    //         SalesCsvProcess::dispatch($data, $header);
    //         unlink($file);
    //     }
    //     return 'Data Queued';
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
