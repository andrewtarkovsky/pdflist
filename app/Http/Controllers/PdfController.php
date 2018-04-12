<?php

namespace App\Http\Controllers;

use App\Pdflist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf as spatie;
use Imagick;

class PdfController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static|static[]
     */
    public function getList() {
        $list = Pdflist::all();
        if($list && $list->isNotEmpty()) {
            $list = $list->map(function($value, $key) {
                $previewUrl         = str_replace('.pdf', '.jpg', $value['filename_local']);
                $value['path']      = $this->getAbsolutePath(Storage::disk('pdfpreview')->url($previewUrl));
                $value['path_pdf']  = $this->getAbsolutePath(Storage::disk('pdf')->url($value['filename_local']));
                return $value;
            });
        }
        return $list;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function uploadPdf(Request $request) {
        $this->validate($request, [
            "file" => "required|mimes:pdf"
        ]);

        $file = $request->file('file');
        $safename = str_replace(' ', '.', $file->getClientOriginalName());
        if($result = Storage::disk('pdf')->put($safename, file_get_contents($file->getRealPath()))) {
            $entity = new Pdflist();
            $entity->filename = $file->getClientOriginalName();
            $entity->filename_local = $safename;
            $entity->save();
            $this->saveImage($safename);
            return ['result' => true];
        } else {
            return ['result' => false];
        }
    }

    /**
     * @throws \Spatie\PdfToImage\Exceptions\InvalidLayerMethod
     * @throws \Spatie\PdfToImage\Exceptions\PageDoesNotExist
     * @throws \Spatie\PdfToImage\Exceptions\PdfDoesNotExist
     */
    public function parseExisting() {
        $list = Storage::disk('pdf')->files();
        if($list) {
            foreach($list as $k=>$v) {
                $this->saveImage($v);
            }
        }
    }

    /**
     * @param String $filename
     * @return bool
     * @throws \Spatie\PdfToImage\Exceptions\InvalidLayerMethod
     * @throws \Spatie\PdfToImage\Exceptions\PageDoesNotExist
     * @throws \Spatie\PdfToImage\Exceptions\PdfDoesNotExist
     */
    protected function saveImage(String $filename) {
        $filename       = str_replace('.pdf', '', $filename);
        $formatPdf      = '.pdf';
        $formatImg      = '.jpg';
        $filenameImg    = $filename.$formatImg;
        $filenamePdf    = $filename.$formatPdf;

        $url            = Storage::disk('pdf')->url($filenamePdf);
        $spatie         = (new spatie($url))
            ->setLayerMethod(null)
            ->setPage(1)
            ->setCompressionQuality(30);

        Storage::disk('pdfpreview')->put($filenameImg, $spatie->getImageData($url));

        return true;
    }

    /**
     * @param String $path
     * @return mixed
     */
    protected function getAbsolutePath(String $path = '') {
        $appUrl = $_SERVER['APP_URL'];
        $serverName = 'http://'.$_SERVER['SERVER_NAME'];

        return str_replace($appUrl, $serverName, $path);
    }
}
