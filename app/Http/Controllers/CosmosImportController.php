<?php

namespace App\Http\Controllers;

use App\Imports\CosmosImport;
use App\Models\CosmosFeed;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Throwable;

class CosmosImportController extends Controller
{
    public function index()
    {
        return view('import_view');
    }
    public $import;
    public function showImportForm(Request $request)
    {
        if (!$request->has('imported')) {
            $feed = CosmosFeed::whereDate('Date', Carbon::now())
                ->orderByDesc('Date')
                ->paginate(100);
        } else {
            $feed = [];
        }

        return view('acquirerFeed', compact('feed'));
    }
    public function dataimport(Request $request)
    {
        info('Data import method called');
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv',
        ]);
        set_time_limit(1800);
        ini_set('memory_limit', '2048M');
        try {
            $file = $request->file('file');
            $import = new CosmosImport;

            // Load the first sheet of the uploaded file
            $importedData = Excel::toArray($import, $file)[0];

            // Get the headers of the uploaded file and trim them
            $uploadedHeaders = array_map('trim', array_keys($importedData[0]));

            // Get the expected model fields and trim them
            $expectedHeaders = array_map('trim', (new CosmosFeed())->getFillable());

            // Get the expected model fields
            $expectedHeaders = (new CosmosFeed())->getFillable();

            // Check if the uploaded headers match the expected model fields
            if (count(array_diff_assoc(array_map('strtolower', array_map('trim', $expectedHeaders)), array_map('strtolower', array_map('trim', $uploadedHeaders)))) > 0) {
                // If there are differences, throw a validation exception
                throw ValidationException::withMessages([
                    'file' => 'The headers of the uploaded file do not match the expected model fields.',
                ]);
            }

            $encounteredTxnids = [];
            // If validation passes, proceed with importing the data
            foreach (array_chunk($importedData, 200) as $chunk) {
                foreach ($chunk as $row) {
                    $txnid = $row['Ext Id'];
                    if (in_array($txnid, $encounteredTxnids)) {
                        continue;
                    }

                    $encounteredTxnids[] = $txnid;
                    $row['Date'] = Carbon::now();
                    $model = new CosmosFeed();
                    $model->fill($row);
                    $model->save();
                    dd($model);
                }
            }
            session()->flash('success', 'File imported successfully!');
        } catch (ValidationException $e) {
            info('ValidationException caught');
            session()->flash('error', $e->getMessage());
        } catch (Throwable $e) {
            info('Other exception caught');
            session()->flash('error', 'Error during import: ' . $e->getMessage());
            if (strpos($e->getMessage(), 'Maximum execution time') !== false || strpos($e->getMessage(), 'Allowed memory size') !== false) {
                return response()->view('error', [], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        info('Data import method completed');
        return view('import_view')->with('status', 'Data imported successfully');
    }
}
