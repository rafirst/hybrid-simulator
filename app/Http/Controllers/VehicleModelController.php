<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleModel;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class VehicleModelController extends Controller
{
    public function getStoredModel()
    {
        $model = VehicleModel::where('is_active', true)->latest()->first();

        if (!$model) {
            return response()->json([
                'status' => 'empty',
                'message' => 'Belum ada model 3D aktif yang diupload'
            ]);
        }

        // Cek apakah file fisik ada di public storage
        $relativePath = $model->file_path;
        $fullPath = public_path($relativePath);

        $base64 = null;
        if (file_exists($fullPath)) {
            $base64 = base64_encode(file_get_contents($fullPath));
        }

        return response()->json([
            'status' => 'success',
            'id' => $model->id,
            'fileName' => $model->file_name,
            'mimeType' => $model->mime_type,
            'url' => asset($model->file_path),
            'base64' => $base64,
            'defaultColor' => $model->default_color,
            'defaultOpacity' => $model->default_opacity,
        ]);
    }

    public function upload(Request $request)
    {
        $uploadPassword = Setting::getVal('upload_password', 'Dms1234');

        // Validasi password
        if ($request->input('password') !== $uploadPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah.'
            ], 403);
        }

        $fileName = $request->input('fileName', 'model_' . time() . '.glb');
        $mimeType = $request->input('mimeType', 'model/gltf-binary');
        $base64Data = $request->input('base64');

        if (!$base64Data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data file base64 tidak ditemukan'
            ], 422);
        }

        $decodedBinary = base64_decode($base64Data);
        $fileSize = strlen($decodedBinary);

        // Simpan ke direktori public/models
        $saveDirectory = public_path('models');
        if (!file_exists($saveDirectory)) {
            mkdir($saveDirectory, 0777, true);
        }

        $cleanFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $fileName);
        $targetFile = $saveDirectory . DIRECTORY_SEPARATOR . $cleanFileName;
        file_put_contents($targetFile, $decodedBinary);

        // Non-aktifkan model lama
        VehicleModel::where('is_active', true)->update(['is_active' => false]);

        // Buat record baru di MySQL
        $newModel = VehicleModel::create([
            'name' => 'Custom Vehicle (' . $cleanFileName . ')',
            'file_name' => $cleanFileName,
            'file_path' => 'models/' . $cleanFileName,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'is_active' => true,
            'default_color' => $request->input('default_color', 'blue'),
            'default_opacity' => $request->input('default_opacity', 0.50),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Model 3D berhasil disimpan ke server dan database MySQL',
            'fileName' => $cleanFileName,
            'id' => $newModel->id,
            'url' => asset('models/' . $cleanFileName)
        ]);
    }
}
