<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Response;

class DocumentController extends Controller
{

public function unduhPDF($id)
{
    $data = Post::findOrFail($id);

    $response = Response::make($data->data_file);
    $response->header('Content-Type', 'application/pdf');
    $response->header('Content-Disposition', 'inline; filename="nama_file.pdf"');

    return $response;
}

    
}
