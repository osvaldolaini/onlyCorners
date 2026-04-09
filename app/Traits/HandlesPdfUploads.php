<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

trait HandlesPdfUploads
{
    public function handlePdfUpload($file, $directory, $filename = null, $deleteDirectory = true)
    {
        // Cria ou recria o diretório
        if (Storage::directoryMissing($directory)) {
            Storage::makeDirectory($directory, 0755, true, true);
        }
        if ($deleteDirectory) {
            Storage::deleteDirectory($directory);
            Storage::makeDirectory($directory, 0755, true, true);
            chmod(storage_path('app/' . $directory), 0755); // Garante a permissão correta

        } else {
            Storage::delete($directory . '/' . $filename);
        }

        // Gera nome aleatório
        $extension = $file->getClientOriginalExtension();
        if (!$filename) {
            $filename = Str::random(20) . '.pdf';
        }
        // $filename = $filename . Str::random(20) . '.pdf';
        $outputPath = storage_path('app/' . $directory . '/' . $filename);

        // Converte imagem ou move PDF
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
            $this->convertImageToPdf($file->getRealPath(), $outputPath);
        } else {
            $file->storeAs($directory, $filename);
        }

        return $filename;
    }

    public function convertImageToPdf($imagePath, $outputPath)
    {
        $imageData = base64_encode(file_get_contents($imagePath));
        $mime = mime_content_type($imagePath);
        $base64Image = "data:$mime;base64,$imageData";

        $html = "<html><body style='margin:0;padding:0;'>
                    <img src='{$base64Image}' style='width:100%;height:auto;'>
                 </body></html>";

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);
    }
    public function deletePdfDirectory($directory)
    {
        if (Storage::directoryMissing($directory)) {
            Storage::makeDirectory($directory);
        }
        Storage::deleteDirectory($directory);
        return false;
    }
}
