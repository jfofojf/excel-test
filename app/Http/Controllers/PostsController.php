<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use App\Service\ExcelService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PostsController extends Controller
{
    public function __construct(
        protected ExcelService $excelService
    ) {}

    public function getFile(Request $request)
    {
        try {
            $data = $request->hasFile('data')
                ? $this->excelService->prepareFromFile($request->file('data'))
                : $this->excelService->getFromResource();
        } catch (GuzzleException $e) {
            return response('Error', 500);
        }

        return Excel::download($data, 'data.xlsx');
    }
}
