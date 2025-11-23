<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class ReceiptController extends Controller
{
    public function PrintReceipt(Request $request)
    {
        $id=$request->query('app_id');
        $applicant=Applicant::query()->where('id',$id)->first();

        $printUrl = url('/print-receipt?app_id=') .  $id;

        // SVG-based QR code (no Imagick required)
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qr = $writer->writeString($printUrl);


        $qrImage = 'data:image/svg+xml;base64,' . base64_encode($qr);
        return view('receipt.receiptview', compact('applicant','qrImage'));
    }
}
